<?php

namespace App\Http\Controllers\Reviewer;

use App\Http\Controllers\Controller;
use App\Models\Resource;


use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $Reviewer = Auth::user();

        // Quick role check (you can replace with middleware later if preferred)
        if (!$Reviewer->role || !in_array(strtolower($Reviewer->role->name), ['Reviewer', 'superReviewer', 'moderator'])) {
            abort(403, 'You do not have access to the Reviewer dashboard.');
        }




        // Optional: recent activity or pending items for quick Reviewer overview
        $recentPending = Resource::where('status', 'pending')
            ->with(['uploader', 'examBoard'])
            ->latest()
            ->take(5)
            ->get();

        $topDownloaded = Resource::approved()
            ->orderByDesc('downloads_count')
            ->take(5)
            ->get();

        return view('Reviewer.dashboard', compact(
            'Reviewer',
            'stats',
            'recentPending',
            'topDownloaded'
        ));
    }
}