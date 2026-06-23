@extends('layouts.select')

@section('title', 'Resources')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-950 to-indigo-950 py-20 text-white">

    <div class="text-center mb-12">
        <h1 class="text-4xl font-bold">Past Papers</h1>
        <p class="text-indigo-400 mt-2">
            {{ $examBoard->name }} • {{ $year->year }} • {{ $session->name }}
        </p>
    </div>

    <div class="max-w-7xl mx-auto grid md:grid-cols-3 lg:grid-cols-4 gap-6 px-6">

        @foreach($resources as $resource)
        <div class="group relative p-6 rounded-3xl bg-white/5 backdrop-blur-xl border border-white/10
                    hover:border-sky-400 transition hover:scale-105">

            <!-- Glow -->
            <div class="absolute inset-0 bg-sky-400 opacity-0 group-hover:opacity-20 blur-xl transition"></div>

            <div class="relative z-10">
                <h3 class="font-semibold group-hover:text-sky-300">
                    {{ $resource->title }}
                </h3>

                <p class="text-sm text-gray-400 mt-2">
                    {{ $course->name }}
                </p>

                <div class="flex justify-between mt-4 text-sm">

                    <a href="{{ route('resources.download', $resource) }}"
                       class="text-indigo-400 hover:text-sky-300">
                        Download
                    </a>

                    <form action="{{ route('resources.save', $resource->id) }}" method="POST">
                        @csrf
                        <button class="hover:text-sky-300">
                            🔖
                        </button>
                    </form>

                </div>
            </div>

        </div>
        @endforeach

    </div>

</div>
@endsection

