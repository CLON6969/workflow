@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto bg-white shadow rounded-lg p-8">
    <h1 class="text-2xl font-bold mb-6">{{ isset($application) ? 'Edit' : 'New' }} Application</h1>

    <form method="POST" action="{{ isset($application) ? route('Applicant.applications.update', $application) : route('Applicant.applications.store') }}" 
          enctype="multipart/form-data">
        @csrf
        @if(isset($application)) @method('PUT') @endif

        <div class="space-y-6">
            <div>
                <label class="block font-medium">Title</label>
                <input type="text" name="title" value="{{ old('title', $application->title ?? '') }}" 
                       class="w-full border rounded px-4 py-2" required>
            </div>

            <div>
                <label class="block font-medium">Category</label>
                <select name="category" class="w-full border rounded px-4 py-2" required>
                    <option value="">Select Category</option>
                    <option value="leave" {{ old('category', $application->category ?? '') == 'leave' ? 'selected' : '' }}>Leave</option>
                    <option value="expense" {{ old('category', $application->category ?? '') == 'expense' ? 'selected' : '' }}>Expense</option>
                    <option value="procurement" {{ old('category', $application->category ?? '') == 'procurement' ? 'selected' : '' }}>Procurement</option>
                    <option value="reimbursement" {{ old('category', $application->category ?? '') == 'reimbursement' ? 'selected' : '' }}>Reimbursement</option>
                    <option value="other" {{ old('category', $application->category ?? '') == 'other' ? 'selected' : '' }}>Other</option>
                </select>
            </div>

            <div>
                <label class="block font-medium">Description</label>
                <textarea name="description" rows="5" class="w-full border rounded px-4 py-2" required>{{ old('description', $application->description ?? '') }}</textarea>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block font-medium">Amount</label>
                    <input type="number" step="0.01" name="amount" value="{{ old('amount', $application->amount ?? '') }}" class="w-full border rounded px-4 py-2">
                </div>
                <div>
                    <label class="block font-medium">Date</label>
                    <input type="date" name="date" value="{{ old('date', $application->date ?? '') }}" class="w-full border rounded px-4 py-2">
                </div>
            </div>

            <div>
                <label class="block font-medium">Attachment (Optional)</label>
                <input type="file" name="attachment" class="w-full border rounded px-4 py-2">
            </div>

            <button type="submit" class="bg-blue-600 text-white px-6 py-3 rounded hover:bg-blue-700">
                {{ isset($application) ? 'Update Draft' : 'Save Draft' }}
            </button>
        </div>
    </form>
</div>
@endsection