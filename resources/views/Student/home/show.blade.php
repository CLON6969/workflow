@extends('layouts.home')

@section('title', $resource->title)

@section('content')

{{-- Flash Messages --}}
@if(session('success'))
    <div class="fixed top-5 right-5 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg z-50">
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="fixed top-5 right-5 bg-red-500 text-white px-6 py-3 rounded-lg shadow-lg z-50">
        {{ session('error') }}
    </div>
@endif

<div class="container py-8 pt-20">
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-10">

        {{-- Left Side: Resource Info & Preview --}}
        <div>
            <div class="bg-white rounded-3xl shadow-xl overflow-hidden">
                {{-- PDF Preview Area --}}
                <div class="h-96 bg-gradient-to-br from-gray-900 to-black flex items-center justify-center relative">
                    <div class="text-center">
                        <div class="text-8xl mb-6 text-white/80">📄</div>
                        <p class="text-white text-xl font-medium">PDF Document</p>
                        <p class="text-white/60 text-sm mt-2">{{ $resource->title }}</p>
                    </div>

                    {{-- Type Badge --}}
                    <div class="absolute top-6 left-6 bg-white/90 text-gray-800 text-xs font-bold px-4 py-2 rounded-full shadow">
                        {{ ucfirst(str_replace('_', ' ', $resource->type)) }}
                    </div>

                    {{-- Practical Badge --}}
                    @if($resource->is_practical)
                        <div class="absolute top-6 right-6 bg-orange-500 text-white text-xs font-bold px-4 py-2 rounded-full shadow">
                            PRACTICAL
                        </div>
                    @endif
                </div>

                {{-- Download Button --}}
                <div class="p-6 border-t">
                    <a href="{{ route('resources.download', $resource) }}" 
                       class="block w-full bg-indigo-600 hover:bg-indigo-700 text-white text-center font-semibold py-4 rounded-2xl transition shadow-lg">
                        📥 Download PDF
                    </a>
                </div>
            </div>

            {{-- Resource Metadata --}}
            <div class="mt-8 bg-white rounded-3xl p-8 shadow">
                <h2 class="text-2xl font-bold mb-6">{{ $resource->title }}</h2>
                
                <div class="grid grid-cols-2 gap-6 text-sm">
                    <div>
                        <p class="text-gray-500">Examination Board</p>
                        <p class="font-semibold">{{ $resource->examBoard->name ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <p class="text-gray-500">Year / Session</p>
                        <p class="font-semibold">
                            {{ $resource->year ?? '—' }} 
                            @if($resource->exam_session) • {{ $resource->exam_session }} @endif
                        </p>
                    </div>
                    <div>
                        <p class="text-gray-500">Paper Number</p>
                        <p class="font-semibold">{{ $resource->paper_number ?? '—' }}</p>
                    </div>
                    <div>
                        <p class="text-gray-500">Downloads</p>
                        <p class="font-semibold text-emerald-600">{{ number_format($resource->downloads_count) }}</p>
                    </div>
                </div>

                @if($resource->module)
                    <div class="mt-8 pt-8 border-t">
                        <p class="text-gray-500 text-sm">Module</p>
                        <p class="font-medium">{{ $resource->module->name }}</p>
                        @if($resource->module->code)
                            <p class="text-xs text-gray-500">{{ $resource->module->code }}</p>
                        @endif
                    </div>
                @endif
            </div>
        </div>

        {{-- Right Side: Actions & Details --}}
        <div class="space-y-8">

            {{-- Save / Bookmark --}}
            <div class="bg-white rounded-3xl p-8 shadow">
                @auth
                    <form action="{{ route('resources.save', $resource->id) }}" method="POST">
                        @csrf
                        <button type="submit" 
                                class="w-full flex items-center justify-center gap-3 bg-gray-900 hover:bg-black text-white font-semibold py-4 rounded-2xl transition">
                            <span class="text-xl">{{ $isSaved ? '❤️' : '♡' }}</span>
                            {{ $isSaved ? 'Saved to Bookmarks' : 'Save to Bookmarks' }}
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}" 
                       class="block text-center w-full bg-gray-900 text-white font-semibold py-4 rounded-2xl">
                        Login to Save Resource
                    </a>
                @endauth
            </div>

            {{-- Resource Info Box --}}
            <div class="bg-white rounded-3xl p-8 shadow">
                <h3 class="font-semibold text-lg mb-4">Resource Information</h3>
                <div class="space-y-4 text-sm">
                    <div class="flex justify-between">
                        <span class="text-gray-500">Type</span>
                        <span class="font-medium">{{ ucfirst(str_replace('_', ' ', $resource->type)) }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-500">Uploaded By</span>
                        <span class="font-medium">{{ $resource->uploader->name ?? 'Unknown' }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-500">Views</span>
                        <span class="font-medium">{{ number_format($resource->views_count) }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-500">File Size</span>
                        <span class="font-medium">{{ number_format($resource->size / 1024 / 1024, 2) }} MB</span>
                    </div>
                </div>
            </div>

            {{-- Contact Uploader (Optional) --}}
            @auth
            <div class="bg-white rounded-3xl p-8 shadow">
                <h3 class="font-semibold text-lg mb-4">Contact Uploader</h3>
                <form action="{{ route('resources.contact', $resource) }}" method="POST">
                    @csrf
                    <textarea name="message" rows="4" 
                              class="w-full border border-gray-300 rounded-2xl p-4 focus:ring-2 focus:ring-indigo-500"
                              placeholder="Ask a question about this resource..."></textarea>
                    <button type="submit"
                            class="mt-4 w-full bg-indigo-600 hover:bg-indigo-700 text-white py-3 rounded-2xl font-medium">
                        Send Message
                    </button>
                </form>
            </div>
            @endauth

        </div>
    </div>

    {{-- Related Resources --}}
    @if($related->count())
        <div class="mt-16">
            <h2 class="text-2xl font-bold mb-8">Related Resources</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($related as $item)
                    <a href="{{ route('resources.show', $item) }}" 
                       class="bg-white border border-gray-200 rounded-3xl p-6 hover:shadow-xl transition">
                        <div class="text-4xl mb-4">📄</div>
                        <h4 class="font-semibold line-clamp-2 mb-2">{{ $item->title }}</h4>
                        <p class="text-xs text-gray-500">{{ $item->examBoard->name ?? '' }} • {{ $item->year ?? '' }}</p>
                    </a>
                @endforeach
            </div>
        </div>
    @endif
</div>

@endsection
