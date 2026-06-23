<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

use App\Models\Resource;

use App\Models\ActivityLog;
use App\Models\User;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function admin()
    {
        return view('admin.dashboard');
    }

    public function user()
    {
        return view('User.dashboard');
    }

    public function Uploader()
    {
        return view('Uploader.dashboard');
    }

    public function jobUserSummary()
    {
        // Resource counts by status
        $approvedResources = Resource::where('status', 'approved')->count();
        $pendingResources  = Resource::where('status', 'pending')->count();
        $rejectedResources = Resource::where('status', 'rejected')->count();

        // Download & view stats
        $totalDownloads    = Resource::sum('downloads_count');
        $totalViews        = Resource::sum('views_count');
        $downloadsToday    = ActivityLog::where('type', 'download')
                                ->whereDate('created_at', today())
                                ->count();

        // User counts by role (using role name instead of hard-coded IDs)
        $studentsCount     = User::whereHas('role', fn($q) => $q->where('name', 'student'))->count();
        $lecturersCount    = User::whereHas('role', fn($q) => $q->where('name', 'lecturer'))->count();
        $totalUsers        = User::count();

        // Latest 5 uploaded resources with uploader info
        $latestResources = Resource::with('uploader')
            ->latest()
            ->take(5)
            ->get();

        // Resource upload trends: count per month for last 6 months
        $resourceTrends = Resource::selectRaw('DATE_FORMAT(created_at, "%Y-%m") as month, COUNT(*) as count')
            ->where('created_at', '>=', Carbon::now()->subMonths(6))
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        $resourceTrendLabels = $resourceTrends->pluck('month')->map(function ($m) {
            return Carbon::createFromFormat('Y-m', $m)->format('M Y');
        })->toArray();

        $resourceTrendCounts = $resourceTrends->pluck('count')->toArray();

        // Latest 50 users with their roles
        $users = User::with('role')->latest()->take(50)->get();

        return view('admin.job_user_summary.index', compact(
            'approvedResources',
            'pendingResources',
            'rejectedResources',
            'totalDownloads',
            'totalViews',
            'downloadsToday',
            'studentsCount',
            'lecturersCount',
            'totalUsers',
            'latestResources',
            'resourceTrendLabels',
            'resourceTrendCounts',
            'users'
        ));
    }

    public function Student()
    {
        $user = Auth::user();

        return view('Student.dashboard');
    }
}