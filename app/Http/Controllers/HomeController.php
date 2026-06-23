<?php

namespace App\Http\Controllers;

use App\Models\Home;
use App\Models\HomeTable1;
use App\Models\ExamBoard;
use App\Models\Resource;
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

class HomeController extends Controller
{
    // ======================================================
    // HOME PAGE
    // ======================================================
    public function index(Request $request)
    {
       
        $logo = Logo::latest()->first();
        $opportunities = Opportunity::all();
        $home = Home::first();
        $home_table1 = HomeTable1::all();

      

        return view('home.index', compact(
           
            'logo',
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
    $query = ExamBoard::query();

    if ($search = request('search')) {
        $query->where('name', 'like', "%{$search}%");
    }

    $examBoards = $query->orderBy('name')
        ->paginate(12)
        ->appends(request()->only('search'));

    return view('home.select.board', compact('examBoards'));
}

public function selectYear(ExamBoard $examBoard)
{
    $query = BoardYear::where('exam_board_id', $examBoard->id);

    if ($search = request('search')) {
        $query->where('year', 'like', "%{$search}%");
    }

    $years = $query->orderByDesc('year')
        ->paginate(12)
        ->appends(request()->only('search'));

    return view('home.select.year', compact('examBoard', 'years'));
}

public function selectSession(ExamBoard $examBoard, BoardYear $year)
{
    $query = BoardSession::where('exam_board_id', $examBoard->id)
        ->where('board_year_id', $year->id);

    if ($search = request('search')) {
        $query->where('name', 'like', "%{$search}%");
    }

    $sessions = $query->paginate(12)
        ->appends(request()->only('search'));

    return view('home.select.session', compact('examBoard', 'year', 'sessions'));
}

    /**
     * Step 4: Select Program (under specific Session)
     */
public function selectProgram(ExamBoard $examBoard, BoardYear $year, BoardSession $session)
{
    $query = BoardProgram::where('board_session_id', $session->id);

    if ($search = request('search')) {
        $query->where('name', 'like', "%{$search}%");
    }

    $programs = $query->orderBy('name')
                      ->paginate(15)
                      ->appends(request()->only('search')); // Important

    return view('home.select.program', compact('examBoard', 'year', 'session', 'programs'));
}

    /**
     * Step 5: Select Course
     */
public function selectCourse(ExamBoard $examBoard, BoardYear $year, BoardSession $session, BoardProgram $program)
{
    $query = BoardCourse::where('board_program_id', $program->id);

    if ($search = request('search')) {
        $query->where('name', 'like', "%{$search}%");
    }

    $courses = $query->orderBy('name')
        ->paginate(12)
        ->appends(request()->only('search'));

    return view('home.select.course', compact(
        'examBoard',
        'year',
        'session',
        'program',
        'courses'
    ));
}

    public function showResources(
        ExamBoard $examBoard,
        BoardYear $year,
        BoardSession $session,
        BoardProgram $program,
        BoardCourse $course
    ) {
        $resources = Resource::with(['boardCourse', 'uploader'])
            ->where('exam_board_id', $examBoard->id)
            ->where('board_year_id', $year->id)
            ->where('board_session_id', $session->id)
            ->where('board_program_id', $program->id)
            ->where('board_course_id', $course->id)
            ->approved()
            ->latest()
            ->paginate(15);

        return view('home.resources.list', compact(
            'examBoard',
            'year',
            'session',
            'program',
            'course',
            'resources'
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

        // ✅ FIX: correct disk usage
        return Storage::disk('public')->download(
            $resource->file_path,
            Str::slug($resource->title) . '.pdf'
        );
    }


public function statistics()
{
    // Overall Stats
    $totalBoards = ExamBoard::count();
    $boardsWithData = ExamBoard::whereHas('boardYears')->count();
    $boardPercent = $totalBoards ? round(($boardsWithData / $totalBoards) * 100, 1) : 0;

    $totalYears = BoardYear::count();
    $yearsWithData = BoardYear::whereHas('boardSessions.boardPrograms.boardCourses.resources')->count();
    $yearPercent = $totalYears ? round(($yearsWithData / $totalYears) * 100, 1) : 0;

    $totalPrograms = BoardProgram::count();
    $programsWithData = BoardProgram::whereHas('boardCourses.resources')->count();
    $programPercent = $totalPrograms ? round(($programsWithData / $totalPrograms) * 100, 1) : 0;

    $totalCourses = BoardCourse::count();
    $coursesWithResources = BoardCourse::whereHas('resources')->count();
    $coursePercent = $totalCourses ? round(($coursesWithResources / $totalCourses) * 100, 1) : 0;

    // Per Board Advanced Stats
    $boards = ExamBoard::with(['boardYears.boardSessions.boardPrograms.boardCourses.resources'])->get();

    $boardStats = $boards->map(function ($board) {
        $totalYears = $board->boardYears->count();
        $yearsWithData = $board->boardYears->filter(fn($y) => 
            $y->boardSessions->some(fn($s) => 
                $s->boardPrograms->some(fn($p) => 
                    $p->boardCourses->some(fn($c) => $c->resources->count() > 0)
                )
            )
        )->count();

        $totalSessions = $board->boardYears->flatMap->boardSessions->count();
        $sessionsWithData = $board->boardYears->flatMap(fn($y) => 
            $y->boardSessions->filter(fn($s) => 
                $s->boardPrograms->some(fn($p) => 
                    $p->boardCourses->some(fn($c) => $c->resources->count() > 0)
                )
            )
        )->count();

        $totalPrograms = $board->boardYears->flatMap->boardSessions->flatMap->boardPrograms->count();
        $programsWithData = $board->boardYears->flatMap->boardSessions->flatMap(fn($s) => 
            $s->boardPrograms->filter(fn($p) => 
                $p->boardCourses->some(fn($c) => $c->resources->count() > 0)
            )
        )->count();

        $totalCourses = $board->boardYears->flatMap->boardSessions->flatMap->boardPrograms->flatMap->boardCourses->count();
        $coursesWithResources = $board->boardYears->flatMap->boardSessions->flatMap->boardPrograms->flatMap(fn($p) => 
            $p->boardCourses->filter(fn($c) => $c->resources->count() > 0)
        )->count();

        $yearPercent    = $totalYears ? round(($yearsWithData / $totalYears) * 100, 1) : 0;
        $sessionPercent = $totalSessions ? round(($sessionsWithData / $totalSessions) * 100, 1) : 0;
        $programPercent = $totalPrograms ? round(($programsWithData / $totalPrograms) * 100, 1) : 0;
        $coursePercent  = $totalCourses ? round(($coursesWithResources / $totalCourses) * 100, 1) : 0;

        $overallPercent = round(($yearPercent * 0.25 + $sessionPercent * 0.2 + $programPercent * 0.25 + $coursePercent * 0.3), 1);

        return [
            'id' => $board->id,
            'name' => $board->name,
            'year_percent' => $yearPercent,
            'session_percent' => $sessionPercent,
            'program_percent' => $programPercent,
            'course_percent' => $coursePercent,
            'overall_percent' => $overallPercent,
            'total_years' => $totalYears,
            'total_sessions' => $totalSessions,
            'total_programs' => $totalPrograms,
            'total_courses' => $totalCourses,
        ];
    })->sortByDesc('overall_percent');

    return view('home.statistics', compact(
        'totalBoards', 'boardsWithData', 'boardPercent',
        'totalYears', 'yearsWithData', 'yearPercent',
        'totalPrograms', 'programsWithData', 'programPercent',
        'totalCourses', 'coursesWithResources', 'coursePercent',
        'boardStats'
    ));
}
}