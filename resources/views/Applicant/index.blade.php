@extends('layouts.app')

@section('content')

@if(session('success'))
    <div id="success-alert"
         class="mb-4 p-4 rounded-lg bg-green-100 border border-green-300 text-green-800">
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div id="error-alert"
         class="mb-4 p-4 rounded-lg bg-red-100 border border-red-300 text-red-800">
        {{ session('error') }}
    </div>
@endif

@if($errors->any())
    <div id="validation-alert"
         class="mb-4 p-4 rounded-lg bg-red-100 border border-red-300 text-red-800">
        <ul class="list-disc list-inside">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="bg-white shadow rounded-lg p-6">

    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">My Applications</h1>

        <a href="{{ route('Applicant.applications.create') }}"
           class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
            New Application
        </a>
    </div>

    <table class="w-full">

        <thead>
            <tr class="bg-gray-100">
                <th class="px-4 py-3 text-left">Title</th>
                <th class="px-4 py-3 text-left">Category</th>
                <th class="px-4 py-3 text-left">Status</th>
                <th class="px-4 py-3 text-left">Submitted</th>
                <th class="px-4 py-3">Actions</th>
            </tr>
        </thead>

        <tbody>

            @foreach($applications as $app)
                <tr class="border-t">

                    <td class="px-4 py-4 font-medium">
                        {{ $app->title }}
                    </td>

                    <td class="px-4 py-4">
                        {{ ucfirst($app->category) }}
                    </td>

                    <td class="px-4 py-4">
                        <span class="px-3 py-1 rounded-full text-sm {{ $app->status_badge }}">
                            {{ $app->status_label }}
                        </span>
                    </td>

                    <td class="px-4 py-4">
                        {{ $app->created_at->format('d M Y') }}
                    </td>

                    <td class="px-4 py-4">

                        {{-- =========================
                            DRAFT
                        ========================= --}}
                        @if($app->status === \App\Enums\ApplicationStatus::DRAFT)

                            <a href="{{ route('Applicant.applications.edit', $app) }}"
                               class="text-blue-600 hover:underline">
                                Edit
                            </a>

                            <form action="{{ route('Applicant.applications.submit', $app) }}"
                                  method="POST"
                                  class="inline ml-3">
                                @csrf

                                <button type="submit"
                                        class="text-green-600 hover:underline">
                                    Submit
                                </button>
                            </form>

                        {{-- =========================
                            RETURNED FOR CHANGES
                        ========================= --}}
                        @elseif($app->status === \App\Enums\ApplicationStatus::RETURNED_FOR_CHANGES)

                            <a href="{{ route('Applicant.applications.edit', $app) }}"
                               class="text-orange-600 hover:underline">
                                Edit
                            </a>

                            <form action="{{ route('Applicant.applications.submit', $app) }}"
                                  method="POST"
                                  class="inline ml-3">
                                @csrf

                                <button type="submit"
                                        class="text-green-600 hover:underline">
                                    Resubmit
                                </button>
                            </form>

                        {{-- =========================
                            ALL OTHER STATUSES
                        ========================= --}}
                        @else

                            <span class="text-gray-500">
                                In Review
                            </span>

                        @endif

                    </td>

                </tr>
            @endforeach

        </tbody>

    </table>

</div>

<script>
document.addEventListener('DOMContentLoaded', function () {

    ['success-alert', 'error-alert', 'validation-alert'].forEach(id => {
        const el = document.getElementById(id);

        if (el) {
            setTimeout(() => {
                el.style.opacity = '0';
                setTimeout(() => el.remove(), 500);
            }, 4000);
        }
    });

});
</script>

@endsection