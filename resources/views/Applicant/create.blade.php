@extends('layouts.app')

@section('content')

<div class="max-w-2xl mx-auto px-4 py-10">

    <div class="bg-white shadow-2xl rounded-3xl p-8 lg:p-10">

        <h1 class="text-3xl font-bold text-gray-800 mb-8">
            {{ isset($application) ? 'Edit Application Draft' : 'Create New Application' }}
        </h1>

        <form method="POST"
              action="{{ isset($application)
                        ? route('Applicant.applications.update', $application)
                        : route('Applicant.applications.store') }}"
              enctype="multipart/form-data"
              class="space-y-8">

            @csrf
            @if(isset($application)) @method('PUT') @endif

            {{-- Title --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Title <span class="text-red-500">*</span>
                </label>

                <input type="text"
                       name="title"
                       value="{{ old('title', $application->title ?? '') }}"
                       class="w-full px-5 py-4 border border-gray-300 rounded-2xl focus:ring-2 focus:ring-blue-500"
                       required>
            </div>

            {{-- Category --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Category <span class="text-red-500">*</span>
                </label>

                <select name="category"
                        class="w-full px-5 py-4 border border-gray-300 rounded-2xl focus:ring-2 focus:ring-blue-500"
                        required>

                    <option value="">Select Category</option>

                    @foreach(['leave','expense','procurement','reimbursement','other'] as $cat)
                        <option value="{{ $cat }}"
                            {{ old('category', $application->category ?? '') === $cat ? 'selected' : '' }}>
                            {{ ucfirst($cat) }}
                        </option>
                    @endforeach

                </select>
            </div>

            {{-- Description --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Description <span class="text-red-500">*</span>
                </label>

                <textarea name="description"
                          rows="6"
                          class="w-full px-5 py-4 border border-gray-300 rounded-2xl focus:ring-2 focus:ring-blue-500"
                          required>{{ old('description', $application->description ?? '') }}</textarea>
            </div>

            {{-- Amount + Date --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Amount
                    </label>

                    <input type="number"
                           step="0.01"
                           name="amount"
                           value="{{ old('amount', $application->amount ?? '') }}"
                           class="w-full px-5 py-4 border border-gray-300 rounded-2xl">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Date
                    </label>

                    <input type="date"
                           name="date"
                           value="{{ old('date', $application->date ?? '') }}"
                           class="w-full px-5 py-4 border border-gray-300 rounded-2xl">
                </div>

            </div>

            {{-- Attachment --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Attachment (Optional)
                </label>

                <input type="file"
                       name="attachment"
                       class="w-full px-5 py-4 border border-gray-300 rounded-2xl file:mr-5 file:py-3 file:px-6 file:rounded-xl file:border-0 file:bg-blue-50 file:text-blue-700">
            </div>

            {{-- Buttons --}}
            <div class="flex gap-4 pt-6">

                <button type="submit"
                        class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-semibold py-4 rounded-2xl transition">

                    {{ isset($application) ? 'Update Draft' : 'Save as Draft' }}

                </button>

                <a href="{{ route('Applicant.applications.index') }}"
                   class="flex-1 text-center border border-gray-300 hover:bg-gray-50 font-semibold py-4 rounded-2xl transition">

                    Cancel

                </a>

            </div>

        </form>

    </div>

</div>

@endsection