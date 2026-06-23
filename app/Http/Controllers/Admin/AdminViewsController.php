<?php

namespace App\Http\Controllers\admin;
use App\Http\Controllers\Controller;

use App\Models\Home;
use App\Models\HomeTable1;
use App\Models\ExamBoard;
use App\Models\Resource;
use App\Models\SavedResource;
use App\Models\ActivityLog;
use App\Models\Logo;
use App\Models\Opportunity;

use App\Models\BoardYear;
use App\Models\BoardSession;
use App\Models\BoardProgram;
use App\Models\BoardCourse;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AdminViewsController extends Controller
{
    // ======================================================
    // HOME PAGE
    // ======================================================
    public function index(Request $request)
    {
        $examBoards = ExamBoard::orderBy('name')->get();
        $logo = Logo::latest()->first();
        $opportunities = Opportunity::all();
        $home = Home::first();
        $home_table1 = HomeTable1::all();

        $query = Resource::with([
                'examBoard',
                'boardYear',
                'boardSession',
                'boardProgram',
                'boardCourse',
                'uploader'
            ])
            ->approved()
            ->latest();

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'like', "%{$request->search}%")
                  ->orWhere('paper_number', 'like', "%{$request->search}%");
            });
        }

        if ($request->filled('exam_board_id')) {
            $query->where('exam_board_id', $request->exam_board_id);
        }

        $resources = $query->paginate(12)->withQueryString();

        $trending = Resource::approved()
            ->where('created_at', '>=', now()->subMonth())
            ->orderByDesc('downloads_count')
            ->take(6)
            ->get();

        return view('admin.home.index', compact(
            'examBoards',
            'logo',
            'resources',
            'trending',
            'opportunities',
            'home',
            'home_table1'
        ));
    }

    // ======================================================
    // STEP FLOW
    // ======================================================

       public function selectBoard()
    {
        $query = ExamBoard::orderBy('name');

        // Search support
        if ($search = request('search')) {
            $query->where('name', 'like', "%{$search}%");
        }

        $examBoards = $query->paginate(16);   // Nice number for boards

        return view('admin.home.select.board', compact('examBoards'));
    }

    // ======================================================
    // SELECT YEAR
    // ======================================================
    public function selectYear(ExamBoard $examBoard)
    {
        $query = BoardYear::where('exam_board_id', $examBoard->id)
            ->orderByDesc('year');

        if ($search = request('search')) {
            $query->where('year', 'like', "%{$search}%");
        }

        $years = $query->paginate(16);

        return view('admin.home.select.year', compact('examBoard', 'years'));
    }

    // ======================================================
    // SELECT SESSION
    // ======================================================
    public function selectSession(ExamBoard $examBoard, BoardYear $year)
    {
        $query = BoardSession::where('exam_board_id', $examBoard->id)
            ->where('board_year_id', $year->id)
            ->orderBy('name');

        if ($search = request('search')) {
            $query->where('name', 'like', "%{$search}%");
        }

        $sessions = $query->paginate(15);

        return view('admin.home.select.session', compact('examBoard', 'year', 'sessions'));
    }

    // ======================================================
    // SELECT PROGRAM
    // ======================================================
    public function selectProgram(ExamBoard $examBoard, BoardYear $year, BoardSession $session)
    {
        $query = BoardProgram::where('board_session_id', $session->id)
            ->orderBy('name');

        if ($search = request('search')) {
            $query->where('name', 'like', "%{$search}%");
        }

        $programs = $query->paginate(16);

        return view('admin.home.select.program', compact('examBoard', 'year', 'session', 'programs'));
    }

    // ======================================================
    // SELECT COURSE
    // ======================================================
    public function selectCourse(ExamBoard $examBoard, BoardYear $year, BoardSession $session, BoardProgram $program)
    {
        $query = BoardCourse::where('board_program_id', $program->id)
            ->orderBy('name');

        if ($search = request('search')) {
            $query->where('name', 'like', "%{$search}%");
        }

        $courses = $query->paginate(12);

        $savedIds = auth()->user()
            ->savedResources()
            ->pluck('resource_id')
            ->toArray();

        return view('admin.home.select.course', compact(
            'examBoard',
            'year',
            'session',
            'program',
            'courses',
            'savedIds'
        ));
    }
    public function showResources(
        ExamBoard $examBoard,
        BoardYear $year,
        BoardSession $session,
        BoardProgram $program,
        BoardCourse $course
    ) {
        $resources = Resource::with(['boardCourse', 'admin'])
            ->where('exam_board_id', $examBoard->id)
            ->where('board_year_id', $year->id)
            ->where('board_session_id', $session->id)
            ->where('board_program_id', $program->id)
            ->where('board_course_id', $course->id)
            ->approved()
            ->latest()
            ->paginate(15);

    $savedIds = auth()->user()
    ->savedResources()
    ->pluck('resource_id')
    ->toArray();

        return view('admin.home.resources.list', compact(
            'examBoard',
            'year',
            'session',
            'program',
            'course',
            'resources',
            'savedIds'
        ));

    }

    // ======================================================
    // PREVIEW PDF (VIEW IN BROWSER)
    // ======================================================
    public function preview(Resource $resource)
    {
        $key = 'view_' . $resource->id;

        if (!session()->has($key)) {
            $resource->increment('views_count');
            session()->put($key, true);
        }

        return response()->file(
            storage_path('app/public/' . $resource->file_path)
        );
    }

    // ======================================================
    // DOWNLOAD (FIXED)
    // ======================================================
    public function download(Resource $resource)
    {
        $key = 'download_' . $resource->id;

        if (!session()->has($key)) {
            $resource->increment('downloads_count');

            ActivityLog::create([
                'type' => 'download',
                'resource_id' => $resource->id,
                'user_id' => Auth::id(),
                'exam_board_id' => $resource->exam_board_id,
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent(),
            ]);

            session()->put($key, true);
        }

        //  FIX: correct disk usage
        return Storage::disk('public')->download(
            $resource->file_path,
            Str::slug($resource->title) . '.pdf'
        );
    }
// ==========================
// SAVE RESOURCE
// ==========================
public function save(Resource $resource)
{
    SavedResource::firstOrCreate([
        'user_id' => auth()->id(),
        'resource_id' => $resource->id,
    ]);

    return back()->with('success', 'Saved!');
}


// ==========================
// SAVED RESOURCES PAGE
// ==========================
public function saved()
{
    // Get saved resources (actual Resource models)
    $resources = Resource::whereIn('id', function ($query) {
            $query->select('resource_id')
                  ->from('saved_resources')
                  ->where('user_id', auth()->id());
        })
        ->with(['examBoard', 'boardCourse'])
        ->latest()
        ->paginate(12);

    // For button state (star active)
    $savedIds = auth()->user()
        ->savedResources()
        ->pluck('resource_id')
        ->toArray();

    return view('admin.saved.index', compact('resources', 'savedIds'));
}


// ==========================
// UNSAVE RESOURCE
// ==========================
public function unsave(Resource $resource)
{
    SavedResource::where('user_id', auth()->id())
        ->where('resource_id', $resource->id)
        ->delete();

    return back()->with('success', 'Removed!');
}

}