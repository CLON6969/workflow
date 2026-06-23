<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\ExamBoard;
use App\Models\BoardYear;
use App\Models\BoardSession;
use App\Models\BoardProgram;
use App\Models\BoardCourse;

class AcademicSetupController extends Controller
{
    // ============================================================
    // DASHBOARD
    // ============================================================
    public function index()
    {
        $boards = ExamBoard::withCount(['boardYears'])->latest()->get();
        return view('admin.setup.index', compact('boards'));
    }

    // ============================================================
    // BOARDS (FULL CRUD)
    // ============================================================
    public function boards()
    {
        $boards = ExamBoard::latest()->get();
        return view('admin.setup.boards.index', compact('boards'));
    }

    public function createBoard()
    {
        return view('admin.setup.boards.create');
    }

    public function storeBoard(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:exam_boards,name'
        ]);

        ExamBoard::create($request->only('name'));

        return redirect()->route('admin.setup.boards.index')->with('success', 'Board created');
    }

    public function editBoard(ExamBoard $examBoard)
    {
        return view('admin.setup.boards.edit', compact('examBoard'));
    }

    public function updateBoard(Request $request, ExamBoard $examBoard)
    {
        $request->validate([
            'name' => 'required|unique:exam_boards,name,' . $examBoard->id
        ]);

        $examBoard->update($request->only('name'));

        return redirect()->route('admin.setup.boards.index')->with('success', 'Board updated');
    }

    public function deleteBoard(ExamBoard $examBoard)
    {
        $examBoard->delete();
        return back()->with('success', 'Board deleted');
    }

    // ============================================================
    // YEARS (FULL CRUD)
    // ============================================================
    public function years(ExamBoard $examBoard)
    {
        $years = BoardYear::where('exam_board_id', $examBoard->id)->get();
        return view('admin.setup.years.index', compact('examBoard', 'years'));
    }

    public function createYear(ExamBoard $examBoard)
    {
        return view('admin.setup.years.create', compact('examBoard'));
    }

    public function storeYear(Request $request, ExamBoard $examBoard)
    {
        $request->validate(['year' => 'required|integer|min:2000']);

        BoardYear::create([
            'exam_board_id' => $examBoard->id,
            'year' => $request->year,
        ]);

        return redirect()->route('admin.setup.boards.years.index', $examBoard)
            ->with('success', 'Year created');
    }

    public function editYear(ExamBoard $examBoard, BoardYear $boardYear)
    {
        return view('admin.setup.years.edit', compact('examBoard', 'boardYear'));
    }

    public function updateYear(Request $request, ExamBoard $examBoard, BoardYear $boardYear)
    {
        $request->validate(['year' => 'required|integer|min:2000']);

        $boardYear->update(['year' => $request->year]);

        return redirect()->route('admin.setup.boards.years.index', $examBoard)
            ->with('success', 'Year updated');
    }

    public function deleteYear(ExamBoard $examBoard, BoardYear $boardYear)
    {
        $boardYear->delete();

        return back()->with('success', 'Year deleted');
    }

    // ============================================================
    // SESSIONS (FULL CRUD)
    // ============================================================
    public function sessions(ExamBoard $examBoard, BoardYear $boardYear)
    {
        $sessions = BoardSession::where('board_year_id', $boardYear->id)->get();

        return view('admin.setup.sessions.index', compact('examBoard', 'boardYear', 'sessions'));
    }

    public function createSession(ExamBoard $examBoard, BoardYear $boardYear)
    {
        return view('admin.setup.sessions.create', compact('examBoard', 'boardYear'));
    }

    public function storeSession(Request $request, ExamBoard $examBoard, BoardYear $boardYear)
    {
        $request->validate(['name' => 'required']);

        BoardSession::create([
            'exam_board_id' => $examBoard->id,
            'board_year_id' => $boardYear->id,
            'name' => $request->name,
        ]);

        return redirect()->route('admin.setup.boards.years.sessions.index', [$examBoard, $boardYear])
            ->with('success', 'Session created');
    }

    public function editSession(ExamBoard $examBoard, BoardYear $boardYear, BoardSession $boardSession)
    {
        return view('admin.setup.sessions.edit', compact('examBoard', 'boardYear', 'boardSession'));
    }

    public function updateSession(Request $request, ExamBoard $examBoard, BoardYear $boardYear, BoardSession $boardSession)
    {
        $request->validate(['name' => 'required']);

        $boardSession->update(['name' => $request->name]);

        return redirect()->route('admin.setup.boards.years.sessions.index', [$examBoard, $boardYear])
            ->with('success', 'Session updated');
    }

    public function deleteSession(ExamBoard $examBoard, BoardYear $boardYear, BoardSession $boardSession)
    {
        $boardSession->delete();
        return back()->with('success', 'Session deleted');
    }

    // ============================================================
    // PROGRAMS (FULL CRUD)
    // ============================================================
    public function programs(ExamBoard $examBoard, BoardYear $boardYear, BoardSession $boardSession)
    {
        $programs = BoardProgram::where('board_session_id', $boardSession->id)->get();

        return view('admin.setup.programs.index', compact('examBoard', 'boardYear', 'boardSession', 'programs'));
    }

public function createProgram(ExamBoard $examBoard, BoardYear $boardYear, BoardSession $boardSession)
{
    return view('admin.setup.programs.create', compact('examBoard', 'boardYear', 'boardSession'));
}

public function storeProgram(Request $request, ExamBoard $examBoard, BoardYear $boardYear, BoardSession $boardSession)
{
    $request->validate([
        'name'  => 'required|string|max:255',
        'level' => 'nullable|string|max:100',
    ]);

    // Prevent duplicate in the same session
    $exists = BoardProgram::where('board_session_id', $boardSession->id)
                ->where('name', $request->name)
                ->exists();

    if ($exists) {
        return back()->with('error', 'This program already exists in this session/year.');
    }

    BoardProgram::create([
        'exam_board_id'   => $examBoard->id,
        'board_year_id'   => $boardYear->id,
        'board_session_id'=> $boardSession->id,
        'name'            => $request->name,
        'level'           => $request->level,
    ]);

    return redirect()
        ->route('admin.setup.boards.years.sessions.programs.index', 
            [$examBoard, $boardYear, $boardSession])
        ->with('success', 'Program created successfully.');
}

    public function editProgram(ExamBoard $examBoard, BoardYear $boardYear, BoardSession $boardSession, BoardProgram $boardProgram)
    {
        return view('admin.setup.programs.edit', compact('examBoard', 'boardYear', 'boardSession', 'boardProgram'));
    }

    public function updateProgram(Request $request, ExamBoard $examBoard, BoardYear $boardYear, BoardSession $boardSession, BoardProgram $boardProgram)
    {
        $request->validate(['name' => 'required']);

        $boardProgram->update(['name' => $request->name]);

        return redirect()->route('admin.setup.boards.years.sessions.programs.index',
            [$examBoard, $boardYear, $boardSession])
            ->with('success', 'Program updated');
    }

    public function deleteProgram(ExamBoard $examBoard, BoardYear $boardYear, BoardSession $boardSession, BoardProgram $boardProgram)
    {
        $boardProgram->delete();
        return back()->with('success', 'Program deleted');
    }

    // ============================================================
    // COURSES (FULL CRUD)
    // ============================================================
    public function courses(ExamBoard $examBoard, BoardYear $boardYear, BoardSession $boardSession, BoardProgram $boardProgram)
    {
        $courses = BoardCourse::where('board_program_id', $boardProgram->id)->get();

        return view('admin.setup.courses.index', compact(
            'examBoard',
            'boardYear',
            'boardSession',
            'boardProgram',
            'courses'
        ));
    }

    public function storeCourse(Request $request, ExamBoard $examBoard, BoardYear $boardYear, BoardSession $boardSession, BoardProgram $boardProgram)
    {
        $request->validate(['name' => 'required']);

        BoardCourse::create([
            'exam_board_id' => $examBoard->id,
            'board_year_id' => $boardYear->id,
            'board_session_id' => $boardSession->id,
            'board_program_id' => $boardProgram->id,
            'name' => $request->name,
        ]);

        return back()->with('success', 'Course created');
    }

    public function editCourse(ExamBoard $examBoard, BoardYear $boardYear, BoardSession $boardSession, BoardProgram $boardProgram, BoardCourse $boardCourse)
    {
        return view('admin.setup.courses.edit', compact(
            'examBoard','boardYear','boardSession','boardProgram','boardCourse'
        ));
    }

    public function updateCourse(Request $request, ExamBoard $examBoard, BoardYear $boardYear, BoardSession $boardSession, BoardProgram $boardProgram, BoardCourse $boardCourse)
    {
        $request->validate(['name' => 'required']);

        $boardCourse->update(['name' => $request->name]);

        return back()->with('success', 'Course updated');
    }

    public function deleteCourse(ExamBoard $examBoard, BoardYear $boardYear, BoardSession $boardSession, BoardProgram $boardProgram, BoardCourse $boardCourse)
    {
        $boardCourse->delete();
        return back()->with('success', 'Course deleted');
    }
}