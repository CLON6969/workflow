@extends('layouts.app')

@section('content')

@if(session('success'))
    <div class="mb-6 p-4 rounded-2xl bg-green-100 border border-green-300 text-green-800">
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="mb-6 p-4 rounded-2xl bg-red-100 border border-red-300 text-red-800">
        {{ session('error') }}
    </div>
@endif

<div class="max-w-7xl mx-auto px-4 py-8">
    <div class="bg-white shadow-xl rounded-3xl overflow-hidden">

        <div class="px-6 py-6 border-b">
            <h1 class="text-3xl font-bold text-gray-800">Review Queue</h1>
            <p class="text-gray-500">Applications currently in review</p>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full">

                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-5 text-left text-sm text-gray-500">Applicant</th>
                        <th class="px-6 py-5 text-left text-sm text-gray-500">Title</th>
                        <th class="px-6 py-5 text-left text-sm text-gray-500">Category</th>
                        <th class="px-6 py-5 text-left text-sm text-gray-500">Status</th>
                        <th class="px-6 py-5 text-left text-sm text-gray-500">Assigned</th>
                        <th class="px-6 py-5 text-center text-sm text-gray-500">Action</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-200">

                    @forelse($applications as $app)
                        <tr class="hover:bg-gray-50 transition">

                            <td class="px-6 py-5 font-medium text-gray-800">
                                {{ $app->user->name ?? 'N/A' }}
                            </td>

                            <td class="px-6 py-5 font-medium text-gray-900">
                                {{ $app->title }}
                            </td>

                            <td class="px-6 py-5 text-gray-700">
                                {{ ucfirst($app->category) }}
                            </td>

                            <td class="px-6 py-5">
                                <span class="px-4 py-1 text-xs font-semibold rounded-2xl {{ $app->status_badge }}">
                                    {{ $app->status instanceof \App\Enums\ApplicationStatus
                                        ? $app->status->label()
                                        : \App\Enums\ApplicationStatus::from($app->status)->label()
                                    }}
                                </span>
                            </td>

                            <td class="px-6 py-5 text-sm text-gray-500">
                                {{ optional($app->currentReviewer)->name ?? 'Unassigned' }}
                            </td>

                            <td class="px-6 py-5 text-center">
                                <a href="{{ route('Reviewer.applications.show', $app) }}"
                                   class="inline-flex items-center bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-2 rounded-2xl text-sm transition">
                                    Review
                                </a>
                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-16 text-gray-500">
                                No applications currently in review.
                            </td>
                        </tr>
                    @endforelse

                </tbody>

            </table>
        </div>

    </div>
</div>

@endsection