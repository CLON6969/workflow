<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Resource;
use App\Models\ExamBoard;
use App\Models\BoardCourse;
use App\Models\BoardProgram;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AdminAnalyticsController extends Controller
{
    // =========================
    // DASHBOARD
    // =========================
    public function dashboard()
    {
        $totalDownloads = Resource::sum('downloads_count');
        $totalViews = Resource::sum('views_count');
        $totalResources = Resource::count();
        $totalUsers = User::count();
        $totalCourses = BoardCourse::count();

        $conversionRate = $totalViews > 0
            ? round(($totalDownloads / $totalViews) * 100, 2)
            : 0;

        // Trends (30 days)
        $downloadsTrend = Resource::select(
                DB::raw('DATE(updated_at) as date'),
                DB::raw('SUM(downloads_count) as total')
            )
            ->groupBy('date')
            ->orderBy('date')
            ->take(30)
            ->get();

        $viewsTrend = Resource::select(
                DB::raw('DATE(updated_at) as date'),
                DB::raw('SUM(views_count) as total')
            )
            ->groupBy('date')
            ->orderBy('date')
            ->take(30)
            ->get();

        // Rankings
        $topResources = Resource::orderByDesc('downloads_count')->take(10)->get();
        $mostViewed = Resource::orderByDesc('views_count')->take(10)->get();

        $topCourses = BoardCourse::withCount('resources')
            ->withSum('resources', 'downloads_count')
            ->orderByDesc('resources_sum_downloads_count')
            ->take(10)
            ->get();

        $topPrograms = BoardProgram::withCount('resources')
            ->withSum('resources', 'downloads_count')
            ->orderByDesc('resources_sum_downloads_count')
            ->take(10)
            ->get();

        $topBoards = ExamBoard::withCount('resources')
            ->withSum('resources', 'downloads_count')
            ->orderByDesc('resources_sum_downloads_count')
            ->take(10)
            ->get();

        return view('admin.analytics.dashboard', compact(
            'totalDownloads',
            'totalViews',
            'totalResources',
            'totalUsers',
            'totalCourses',
            'conversionRate',
            'downloadsTrend',
            'viewsTrend',
            'topResources',
            'mostViewed',
            'topCourses',
            'topPrograms',
            'topBoards'
        ));
    }

    // =========================
    // RESOURCE EXPLORER (FILTERABLE)
    // =========================
    public function resources(Request $request)
{
    $query = Resource::with(['examBoard', 'boardProgram', 'boardCourse']);

    // ================= FILTERS =================
    if ($request->filled('search')) {
        $query->where('title', 'like', '%' . $request->search . '%');
    }

    if ($request->filled('board_id')) {
        $query->where('exam_board_id', $request->board_id);
    }

    if ($request->filled('program_id')) {
        $query->where('board_program_id', $request->program_id);
    }

    if ($request->filled('course_id')) {
        $query->where('board_course_id', $request->course_id);
    }

    // Date range (based on activity)
    if ($request->filled('from')) {
        $query->whereDate('updated_at', '>=', $request->from);
    }

    if ($request->filled('to')) {
        $query->whereDate('updated_at', '<=', $request->to);
    }

    // ================= SORTING =================
    if ($request->sort === 'downloads') {
        $query->orderByDesc('downloads_count');
    } elseif ($request->sort === 'views') {
        $query->orderByDesc('views_count');
    } else {
        $query->latest();
    }

    // ================= PAGINATION =================
    $resources = $query->paginate(25)->withQueryString();

    // dropdowns
    $boards = ExamBoard::orderBy('name')->get();
    $programs = BoardProgram::orderBy('name')->get();
    $courses = BoardCourse::orderBy('name')->get();

    return view('admin.analytics.resources', compact(
        'resources',
        'boards',
        'programs',
        'courses'
    ));
}
}

