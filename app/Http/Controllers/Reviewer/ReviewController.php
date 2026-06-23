<?php

namespace App\Http\Controllers\Reviewer;
use App\Http\Controllers\Controller;

use App\Enums\ApplicationStatus;
use App\Http\Requests\ReviewActionRequest;
use App\Models\Application;
use App\Services\ApplicationWorkflowService;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    protected $workflowService;

    public function __construct(ApplicationWorkflowService $workflowService)
    {
        $this->workflowService = $workflowService;
    }

    /**
     * Show reviewer queue
     */
    public function index()
    {
        $this->authorize('viewAny', Application::class);

        $applications = Application::with(['user', 'currentReviewer'])
            ->whereIn('status', ['submitted', 'under_review', 'returned'])
            ->latest()
            ->paginate(15);

        return view('reviewer.queue', compact('applications'));
    }

    /**
     * Show single application detail + logs
     */
    public function show(Application $application)
    {
        $this->authorize('view', $application);

        $application->load(['logs.user', 'user']);

        return view('reviewer.show', compact('application'));
    }

    /**
     * Process review action (approve / reject / return)
     */
    public function review(ReviewActionRequest $request, Application $application)
    {
        $this->authorize('review', $application);

        try {
            $newStatus = $request->getNewStatus();

            $this->workflowService->transition(
                $application,
                $newStatus,
                Auth::user(),
                $request->comment
            );

            $message = match($newStatus) {
                ApplicationStatus::APPROVED => 'Application approved successfully.',
                ApplicationStatus::REJECTED => 'Application rejected.',
                ApplicationStatus::RETURNED => 'Application returned for changes.',
            };

            return redirect()->route('reviewer.queue')
                ->with('success', $message);
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}