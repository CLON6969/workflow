<?php

namespace Tests\Unit;

use App\Enums\ApplicationStatus;
use App\Models\Application;
use App\Models\Role;
use App\Models\User;
use App\Services\ApplicationWorkflowService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ApplicationWorkflowServiceTest extends TestCase
{
    use RefreshDatabase;

    protected ApplicationWorkflowService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = app(ApplicationWorkflowService::class);
    }

    /** @test */
    public function applicant_can_submit_draft()
    {
        $applicant = User::factory()->create(['role_id' => Role::where('name', 'Applicant')->first()->id]);
        $application = Application::factory()->create([
            'user_id' => $applicant->id,
            'status' => ApplicationStatus::DRAFT
        ]);

        $result = $this->service->transition($application, ApplicationStatus::SUBMITTED, $applicant);

        $this->assertEquals('submitted', $result->status);
        $this->assertDatabaseHas('application_logs', [
            'application_id' => $application->id,
            'new_status' => 'submitted'
        ]);
    }

    /** @test */
    public function reviewer_can_approve_application()
    {
        $reviewer = User::factory()->create(['role_id' => Role::where('name', 'Reviewer')->first()->id]);
        $application = Application::factory()->create(['status' => ApplicationStatus::UNDER_REVIEW]);

        $result = $this->service->transition($application, ApplicationStatus::APPROVED, $reviewer, "Looks good!");

        $this->assertEquals('approved', $result->status);
    }

    /** @test */
    public function rejects_illegal_transition()
    {
        $this->expectException(\Exception::class);
        
        $applicant = User::factory()->create(['role_id' => Role::where('name', 'Applicant')->first()->id]);
        $application = Application::factory()->create(['status' => ApplicationStatus::APPROVED]);

        $this->service->transition($application, ApplicationStatus::SUBMITTED, $applicant);
    }

    /** @test */
    public function reject_requires_comment()
    {
        $this->expectException(\Exception::class);
        
        $reviewer = User::factory()->create(['role_id' => Role::where('name', 'Reviewer')->first()->id]);
        $application = Application::factory()->create(['status' => ApplicationStatus::UNDER_REVIEW]);

        $this->service->transition($application, ApplicationStatus::REJECTED, $reviewer);
    }
}