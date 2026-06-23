<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('applications', function (Blueprint $table) {
            $table->id();
            
            // Applicant
            $table->foreignId('user_id')
                  ->constrained('users')
                  ->onDelete('cascade');

            // Application Details
            $table->string('title');
            $table->enum('category', [
                'leave', 
                'expense', 
                'procurement', 
                'reimbursement', 
                'other'
            ]);
            $table->text('description');
            $table->decimal('amount', 15, 2)->nullable();
            $table->date('date')->nullable();

            // Attachment
            $table->string('attachment')->nullable();

            // Workflow
            $table->enum('status', [
                'draft',
                'submitted',
                'under_review',
                'approved',
                'rejected',
                'returned'
            ])->default('draft');

            $table->foreignId('current_reviewer_id')
                  ->nullable()
                  ->constrained('users')
                  ->onDelete('set null');

            $table->timestamps();

            // Indexes
            $table->index(['user_id', 'status']);
            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('applications');
    }
};