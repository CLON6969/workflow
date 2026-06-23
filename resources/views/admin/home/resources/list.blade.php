@extends('layouts.Uploader')

@section('title', 'Resources')

@section('content')
<div class="min-h-screen py-20 text-white bg-slate-950">

    <div class="text-center mb-10">
        <h1 class="text-3xl font-bold">Resources</h1>
        <p class="text-indigo-400">
            {{ $examBoard->name }} • {{ $year->year }} • {{ $session->name }} • {{ $program->name }} • {{ $course->name }}
        </p>
    </div>

    <div class="grid md:grid-cols-3 gap-6 max-w-6xl mx-auto px-6">

        @foreach($resources as $resource)
            <div class="p-6 bg-white/5 rounded-xl border border-white/10">

                <h3 class="font-semibold">{{ $resource->title }}</h3>

                <p class="text-sm text-gray-400 mt-2">
                    {{ $resource->type }}
                </p>

                <div class="mt-4 flex justify-between text-sm">
                    <a href="{{ route('resources.download', $resource) }}" class="text-indigo-400">
                        Download
                    </a>

                    <form method="POST" action="{{ route('resources.save', $resource->id) }}">
                        @csrf
                        <button>🔖</button>
                    </form>
                </div>

            </div>
        @endforeach

    </div>

</div>
@endsection