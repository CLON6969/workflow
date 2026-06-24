@extends('layouts.app')

@section('content')

<div class="max-w-4xl mx-auto px-4 py-8">

    <div class="bg-white shadow-xl rounded-3xl p-8 lg:p-10">

        {{-- Header --}}
        <div class="flex flex-col sm:flex-row justify-between items-start gap-4 mb-8">
            <div>
                <h1 class="text-3xl font-bold text-gray-800">
                    {{ $application->title }}
                </h1>

                <p class="text-gray-600 mt-2">
                    Submitted by <strong>{{ $application->user->name ?? 'Unknown' }}</strong>
                </p>
            </div>

            <span class="px-5 py-2.5 text-sm font-semibold rounded-3xl {{ $application->status_badge }}">
                {{ $application->status->label() }}
            </span>
        </div>

        {{-- Details --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-10">

            <div class="bg-gray-50 rounded-2xl p-6">
                <span class="uppercase text-xs tracking-widest text-gray-500">Category</span>
                <p class="text-lg font-medium mt-1">
                    {{ $application->category }}
                </p>
            </div>

            @if($application->amount)
                <div class="bg-gray-50 rounded-2xl p-6">
                    <span class="uppercase text-xs tracking-widest text-gray-500">Amount</span>
                    <p class="text-lg font-medium mt-1">
                        ${{ number_format($application->amount, 2) }}
                    </p>
                </div>
            @endif

        </div>

        {{-- Description --}}
        <div class="mb-10">
            <h3 class="font-semibold text-lg mb-3">Description</h3>

            <div class="bg-gray-50 p-6 rounded-2xl border border-gray-100">
                {{ $application->description }}
            </div>
        </div>

        {{-- Attachment --}}
        @if($application->attachment)
            <div class="mb-10">
                <h3 class="font-semibold text-lg mb-3">Attachment</h3>

                <a href="{{ \Storage::url($application->attachment) }}"
                   target="_blank"
                   class="inline-flex items-center gap-3 bg-blue-50 hover:bg-blue-100 px-6 py-4 rounded-2xl text-blue-700 transition">

                    <i class="fas fa-download"></i>
                    Download Attachment
                </a>
            </div>
        @endif

        {{-- Review Actions --}}
        @if(!$application->status->isFinal())

            <div class="border border-gray-200 rounded-3xl p-8 bg-gray-50">

                <h3 class="font-semibold text-xl mb-6">
                    Take Action
                </h3>

                <form action="{{ route('Reviewer.applications.review', $application) }}" method="POST">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">

                        <button type="submit" name="action" value="approve"
                                class="bg-green-600 hover:bg-green-700 text-white py-4 rounded-2xl font-medium">
                            Approve
                        </button>

                        <button type="submit" name="action" value="return"
                                class="bg-orange-600 hover:bg-orange-700 text-white py-4 rounded-2xl font-medium">
                            Return for Changes
                        </button>

                        <button type="submit" name="action" value="reject"
                                class="bg-red-600 hover:bg-red-700 text-white py-4 rounded-2xl font-medium">
                            Reject
                        </button>

                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-3">
                            Comment <span class="text-red-500">*</span>
                        </label>

                        <textarea name="comment"
                                  rows="5"
                                  class="w-full border border-gray-300 rounded-2xl px-5 py-4"
                                  placeholder="Write your comments here..."></textarea>
                    </div>

                </form>

            </div>

        @endif

        {{-- Audit Trail --}}
        <div class="mt-12">

            <h3 class="font-semibold text-xl mb-5">
                Audit Trail
            </h3>

            <div class="space-y-6">

                @forelse($application->logs as $log)

                    <div class="border-l-4 border-gray-300 pl-6 py-3">

                        <div class="flex justify-between">
                            <span class="font-medium">
                                {{ $log->user->name ?? 'System' }}
                            </span>

                            <span class="text-xs text-gray-500">
                                {{ $log->created_at->format('d M Y • H:i') }}
                            </span>
                        </div>

                        <p class="text-sm mt-1">

                            {{ \App\Enums\ApplicationStatus::from($log->old_status)->label() }}
                            →
                            <strong>
                                {{ \App\Enums\ApplicationStatus::from($log->new_status)->label() }}
                            </strong>

                        </p>

                        @if($log->comment)
                            <p class="mt-2 text-gray-600 italic">
                                "{{ $log->comment }}"
                            </p>
                        @endif

                    </div>

                @empty
                    <p class="text-gray-500 italic py-8">
                        No activity recorded yet.
                    </p>
                @endforelse

            </div>

        </div>

    </div>

</div>

@endsection