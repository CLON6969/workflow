<?php

namespace App\Http\Controllers\Applicant;
use App\Http\Controllers\Controller;

use App\Enums\ApplicationStatus;
use App\Http\Requests\StoreApplicationRequest;
use App\Models\Application;
use App\Services\ApplicationWorkflowService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ApplicationController extends Controller
{
    protected $workflowService;

    public function __construct(ApplicationWorkflowService $workflowService)
    {
        $this->workflowService = $workflowService;
    }

    /**
     * Display applicant's applications
     */
    public function index()
    {
        $applications = Auth::user()->applications()
            ->latest()
            ->paginate(10);

        return view('applicant.index', compact('applications'));
    }

    /**
     * Show create form
     */
    public function create()
    {
        $this->authorize('create', Application::class);
        return view('applicant.create');
    }

    /**
     * Store new draft
     */
    public function store(StoreApplicationRequest $request)
    {
        $this->authorize('create', Application::class);

        $data = $request->validated();
        $data['user_id'] = Auth::id();
        $data['status'] = ApplicationStatus::DRAFT->value;

        if ($request->hasFile('attachment')) {
            $data['attachment'] = $request->file('attachment')->store('attachments', 'public');
        }

        $application = Application::create($data);

        return redirect()->route('applicant.applications.index')
            ->with('success', 'Application draft created successfully.');
    }

    /**
     * Show edit form (only drafts)
     */
    public function edit(Application $application)
    {
        $this->authorize('update', $application);
        return view('applicant.edit', compact('application'));
    }

    /**
     * Update draft
     */
    public function update(StoreApplicationRequest $request, Application $application)
    {
        $this->authorize('update', $application);

        $data = $request->validated();

        if ($request->hasFile('attachment')) {
            if ($application->attachment) {
                Storage::disk('public')->delete($application->attachment);
            }
            $data['attachment'] = $request->file('attachment')->store('attachments', 'public');
        }

        $application->update($data);

        return redirect()->route('applicant.applications.index')
            ->with('success', 'Application updated successfully.');
    }

    /**
     * Submit draft for review
     */
    public function submit(Application $application)
    {
        $this->authorize('submit', $application);

        try {
            $this->workflowService->transition(
                $application, 
                ApplicationStatus::SUBMITTED, 
                Auth::user()
            );

            return redirect()->route('applicant.applications.index')
                ->with('success', 'Application submitted successfully.');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}