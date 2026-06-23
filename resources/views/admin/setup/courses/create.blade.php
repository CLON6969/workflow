@extends('layouts.admin')

@section('title', 'Create Course')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-950 to-indigo-950 flex items-center justify-center p-6 text-white">

    <div class="w-full max-w-md bg-white/10 backdrop-blur-xl border border-white/10 rounded-3xl p-8">

        <h1 class="text-2xl font-bold mb-6 text-center">
            Add Course
        </h1>

        @if($errors->any())
            <div class="mb-4 bg-red-500/80 p-4 rounded-xl">
                @foreach($errors->all() as $error)
                    <p class="text-sm">{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <form method="POST"
              action="{{ route('admin.setup.boards.programs.courses.store', [$examBoard, $boardProgram]) }}"
              class="space-y-6">

            @csrf

            <div>
                <label class="text-slate-300">Course Name</label>
                <input type="text" name="name"
                       class="w-full mt-2 px-4 py-3 rounded-xl bg-black/40 border border-white/10">
            </div>

            <button class="w-full bg-indigo-600 py-3 rounded-xl hover:bg-indigo-700 transition">
                Save Course
            </button>

        </form>

        <div class="text-center mt-6">
            <a href="{{ route('admin.setup.boards.programs.courses.index', [$examBoard, $boardProgram]) }}"
               class="text-slate-400 hover:text-white">
                ← Back
            </a>
        </div>

    </div>

</div>
@endsection