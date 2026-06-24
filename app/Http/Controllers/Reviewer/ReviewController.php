<?php

namespace App\Http\Controllers\Reviewer;

use App\Http\Controllers\Controller;
use App\Http\Requests\ReviewActionRequest;
use App\Models\Application;
use App\Services\ApplicationWorkflowService;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function __construct(
        protected ApplicationWorkflowService $workflowService
    ) {}

    /**
     * Review queue
     */
    public function index()
    {
        $applications = Application::with('user')
            ->whereIn('status', [
                'submitted',
                'under_review',
            ])
            ->latest()
            ->paginate(15);

        return view('reviewer.queue', compact('applications'));
    }

    /**
     * Show single application for review
     */
    public function show(Application $application)
    {
        $this->authorize('view', $application);

        $application->load(['user', 'logs.user']);

        return view('reviewer.show', compact('application'));
    }

    /**
     * Perform review action (approve/reject/return)
     */
    public function review(ReviewActionRequest $request, Application $application)
    {
        $this->authorize('review', $application);

        $application = $this->workflowService->transition(
            application: $application,
            action: $request->input('action'),
            user: Auth::user(),
            comment: $request->input('comment')
        );

        return redirect()
            ->route('Reviewer.applications.show', $application)
            ->with('success', 'Action completed successfully.');
    }
}