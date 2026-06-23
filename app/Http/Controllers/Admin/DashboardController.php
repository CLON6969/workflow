<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Resource;
use App\Models\ActivityLog;
use App\Models\User;

use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $admin = Auth::user();

        // Quick role check (you can replace with middleware later if preferred)
        if (!$admin->role || !in_array(strtolower($admin->role->name), ['admin', 'superadmin', 'moderator'])) {
            abort(403, 'You do not have access to the admin dashboard.');
        }

        // Admin sees global/system-wide stats (not filtered by user)
        $stats = [
            'total_resources'     => Resource::count(),
            'approved_resources'  => Resource::where('status', 'approved')->count(),
            'pending_resources'   => Resource::where('status', 'pending')->count(),
            'rejected_resources'  => Resource::where('status', 'rejected')->count(),
            'total_downloads'     => Resource::sum('downloads_count'),
            'total_views'         => Resource::sum('views_count'),
            'total_users'         => User::count(),
            'active_users_now'    => ActivityLog::where('created_at', '>=', now()->subMinutes(30))
                                        ->distinct('ip_address')
                                        ->count('ip_address'),
            'visits_today'        => ActivityLog::where('type', 'view')
                                        ->whereDate('created_at', today())
                                        ->count(),
            'downloads_today'     => ActivityLog::where('type', 'download')
                                        ->whereDate('created_at', today())
                                        ->count(),
        ];

        // Optional: recent activity or pending items for quick admin overview
        $recentPending = Resource::where('status', 'pending')
            ->with(['uploader', 'examBoard'])
            ->latest()
            ->take(5)
            ->get();

        $topDownloaded = Resource::approved()
            ->orderByDesc('downloads_count')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'admin',
            'stats',
            'recentPending',
            'topDownloaded'
        ));
    }
}