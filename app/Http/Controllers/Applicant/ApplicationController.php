<?php

namespace App\Http\Controllers\Applicant;

use App\Http\Controllers\Controller;
use App\Enums\ApplicationStatus;
use App\Http\Requests\StoreApplicationRequest;
use App\Models\Application;
use App\Services\ApplicationWorkflowService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ApplicationController extends Controller
{
    protected ApplicationWorkflowService $workflowService;

    public function __construct(ApplicationWorkflowService $workflowService)
    {
        $this->workflowService = $workflowService;
    }

    public function index()
    {
        $applications = Auth::user()
            ->applications()
            ->latest()
            ->paginate(10);

        return view('Applicant.index', compact('applications'));
    }

    public function create()
    {
        $this->authorize('create', Application::class);

        return view('Applicant.create');
    }

    public function store(StoreApplicationRequest $request)
    {
        $this->authorize('create', Application::class);

        $data = $request->validated();
        $data['user_id'] = Auth::id();
        $data['status'] = ApplicationStatus::DRAFT->value;

        if ($request->hasFile('attachment')) {
            $data['attachment'] = $request->file('attachment')
                ->store('attachments', 'public');
        }

        Application::create($data);

        return redirect()
            ->route('Applicant.applications.index')
            ->with('success', 'Draft created successfully.');
    }

    public function edit(Application $application)
    {
        $this->authorize('update', $application);

        return view('Applicant.edit', compact('application'));
    }

    public function update(StoreApplicationRequest $request, Application $application)
    {
        $this->authorize('update', $application);

        $data = $request->validated();

        if ($request->hasFile('attachment')) {
            if ($application->attachment) {
                Storage::disk('public')->delete($application->attachment);
            }

            $data['attachment'] = $request->file('attachment')
                ->store('attachments', 'public');
        }

        $application->update($data);

        return redirect()
            ->route('Applicant.applications.index')
            ->with('success', 'Draft updated successfully.');
    }

    /**
     * Submit draft → moves to UNDER_REVIEW
     */
    public function submit(Application $application)
    {
        $this->authorize('submit', $application);

        try {
            $this->workflowService->transition(
                $application,
                'submit', // 🔥 IMPORTANT: action string (not enum)
                Auth::user()
            );

            return redirect()
                ->route('Applicant.applications.index')
                ->with('success', 'Application sent for review successfully!');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}