<?php

namespace App\Http\Controllers\Uploader;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

use App\Models\Resource;
use App\Models\ExamBoard;
use App\Models\BoardYear;
use App\Models\BoardSession;
use App\Models\BoardProgram;
use App\Models\BoardCourse;

class ResourceController extends Controller
{
    // =====================================================
    // INDEX (LIST ALL RESOURCES)
    // =====================================================
    public function index()
    {
        $resources = Resource::with([
            'examBoard',
            'boardYear',
            'boardSession',
            'boardProgram',
            'boardCourse',
            'uploader'
        ])->latest()->paginate(20);

        return view('Uploader.resources.index', compact('resources'));
    }

    // =====================================================
    // STEP 1: SELECT BOARD
    // =====================================================
  // =====================================================
// STEP 1: SELECT BOARD
// =====================================================
public function create()
{
    $query = ExamBoard::query();

    if ($search = request('search')) {
        $query->where('name', 'like', "%{$search}%");
    }

    $boards = $query->orderBy('name')
                    ->paginate(12)
                    ->appends(request()->only('search'));

    return view('Uploader.resources.create', compact('boards'));
}

// =====================================================
// STEP 2: SELECT YEAR
// =====================================================
public function selectYear(ExamBoard $examBoard)
{
    $query = $examBoard->years();

    if ($search = request('search')) {
        $query->where('year', 'like', "%{$search}%");
    }

    $years = $query->orderByDesc('year')
                   ->paginate(12)
                   ->appends(request()->only('search'));

    return view('Uploader.resources.select-year', compact('examBoard', 'years'));
}

// =====================================================
// STEP 3: SELECT SESSION
// =====================================================
public function selectSession(ExamBoard $examBoard, BoardYear $boardYear)
{
    $query = $boardYear->boardSessions();

    if ($search = request('search')) {
        $query->where('name', 'like', "%{$search}%");
    }

    $sessions = $query->orderBy('name')
                      ->paginate(12)
                      ->appends(request()->only('search'));

    return view('Uploader.resources.select-session', compact(
        'examBoard', 'boardYear', 'sessions'
    ));
}

// =====================================================
// STEP 4: SELECT PROGRAM
// =====================================================
public function selectProgram(ExamBoard $examBoard, BoardYear $boardYear, BoardSession $boardSession)
{
    $query = BoardProgram::where('board_session_id', $boardSession->id);

    if ($search = request('search')) {
        $query->where('name', 'like', "%{$search}%");
    }

    $programs = $query->orderBy('name')
                      ->paginate(15)
                      ->appends(request()->only('search'));

    return view('Uploader.resources.select-program', compact(
        'examBoard', 'boardYear', 'boardSession', 'programs'
    ));
}

// =====================================================
// STEP 5: SELECT COURSE
// =====================================================
public function selectCourse(
    ExamBoard $examBoard,
    BoardYear $boardYear,
    BoardSession $boardSession,
    BoardProgram $boardProgram
) {

    $query = BoardCourse::withCount('resources')
        ->where('board_program_id', $boardProgram->id);

    if ($search = request('search')) {
        $query->where('name', 'like', "%{$search}%");
    }

    $courses = $query->orderBy('name')
                     ->paginate(12)
                     ->appends(request()->only('search'));

    return view('Uploader.resources.select-course', compact(
        'examBoard',
        'boardYear',
        'boardSession',
        'boardProgram',
        'courses'
    ));
}
    // =====================================================
    // STEP 6: FINAL UPLOAD FORM
    // =====================================================
    public function uploadForm(
        ExamBoard $examBoard,
        BoardYear $boardYear,
        BoardSession $boardSession,
        BoardProgram $boardProgram,
        BoardCourse $boardCourse
    ) {
        return view('Uploader.resources.upload', compact(
            'examBoard',
            'boardYear',
            'boardSession',
            'boardProgram',
            'boardCourse'
        ));
    }

    

    // =====================================================
    // STORE RESOURCE (PDF ONLY)
    // =====================================================
   public function store(Request $request)
{
    try {

        // 1. VALIDATION (Laravel already gives reasons)
        $validated = $request->validate([
            'exam_board_id'    => 'required|exists:exam_boards,id',
            'board_year_id'    => 'required|exists:board_years,id',
            'board_session_id' => 'required|exists:board_sessions,id',
            'board_program_id' => 'required|exists:board_programs,id',
            'board_course_id'  => 'required|exists:board_courses,id',

            'title' => 'required|string|max:255',
            'type'  => 'required|in:past_paper,module_note,syllabus,ca_paper,tutorial_sheet,note',

            'file'  => 'required|file|mimes:pdf|max:20480',
        ]);

        // 2. FILE CHECK (extra clarity)
        if (!$request->hasFile('file')) {
            return back()->with('error', 'No file was uploaded. Please select a PDF.');
        }

        $file = $request->file('file');

        if (!$file->isValid()) {
            return back()->with('error', 'Uploaded file is corrupted or incomplete.');
        }

        if ($file->getClientOriginalExtension() !== 'pdf') {
            return back()->with('error', 'Only PDF files are allowed.');
        }

        // 3. SIZE CHECK (custom message)
        if ($file->getSize() > 20480 * 1024) {
            return back()->with('error', 'File is too large. Maximum allowed size is 20MB.');
        }

        // 4. STORE FILE
        $path = $file->store('resources/' . $request->exam_board_id, 'public');

        if (!$path) {
            return back()->with('error', 'File upload failed while saving to server.');
        }

        // 5. SAVE DB
        Resource::create([
            'title' => $request->title,
            'type'  => $request->type,
            'file_path' => $path,
            'mime_type' => 'application/pdf',
            'size'      => $file->getSize(),

            'exam_board_id'    => $request->exam_board_id,
            'board_year_id'    => $request->board_year_id,
            'board_session_id' => $request->board_session_id,
            'board_program_id' => $request->board_program_id,
            'board_course_id'  => $request->board_course_id,

            'uploader_id' => Auth::id(),
            'status'      => 'pending',
        ]);

        return redirect()
            ->route('Uploader.resources.index')
            ->with('success', 'PDF uploaded successfully ✔');

    } catch (\Illuminate\Validation\ValidationException $e) {

        // 6. RETURN EXACT VALIDATION REASONS
        return back()
            ->withErrors($e->errors())
            ->withInput();

    } catch (\Exception $e) {

        // 7. GENERAL ERROR (REAL REASON)
        return back()->with('error', 'Upload failed: ' . $e->getMessage());
    }
}

    // =====================================================
    // SHOW
    // =====================================================
    public function show(Resource $resource)
    {
        $resource->load([
            'examBoard',
            'boardYear',
            'boardSession',
            'boardProgram',
            'boardCourse'
        ]);

       return response()->file(
    storage_path('app/public/' . $resource->file_path)
);
    }

    // =====================================================
    // DELETE
    // =====================================================
    public function destroy(Resource $resource)
    {
        if ($resource->file_path) {
            Storage::disk('public')->delete($resource->file_path);
        }

        $resource->delete();

        return back()->with('success', 'Resource deleted');
    }
}