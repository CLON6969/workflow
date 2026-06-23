{{-- ========================= UPLOAD RESOURCE ========================= --}}
@extends('layouts.Uploader')

@section('title', 'Upload Resource')

@section('content')

<div class="p-8 min-h-screen bg-gradient-to-br from-zinc-950 via-slate-950 to-indigo-950 py-20 text-white">

    <!-- Back Button -->
    <div class="mb-6">
        <a href="{{ route('admin.resources.courses.index', [$examBoard, $boardYear, $boardSession, $boardProgram]) }}" 
           class="inline-flex items-center gap-2 text-cyan-400 hover:text-cyan-300 transition">
            ← Back to Courses
        </a>
    </div>

    <!-- Header -->
    <div class="mb-8 text-center">
        <h1 class="text-3xl font-bold text-gray-300">
            Upload Resource
        </h1>
        <p class="text-gray-400 mt-2">
            {{ $boardProgram->name }} → {{ $boardCourse->name }}
        </p>
    </div>

    <div class="max-w-2xl mx-auto">

        <div class="bg-white/5 backdrop-blur-2xl border border-white/10 rounded-3xl p-8">

            @if(session('success'))
                <div class="bg-emerald-500/20 border border-emerald-500 text-emerald-400 p-4 rounded-2xl mb-6">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="bg-red-500/20 border border-red-500 text-red-400 p-4 rounded-2xl mb-6">
                    {{ session('error') }}
                </div>
            @endif

            @if($errors->any())
                <div class="bg-red-500/20 border border-red-500 text-red-400 p-4 rounded-2xl mb-6">
                    <strong class="block mb-2">Please fix the following errors:</strong>
                    <ul class="list-disc ml-5 space-y-1">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('admin.resources.store') }}" enctype="multipart/form-data">

                @csrf

                <!-- Hidden Fields -->
                <input type="hidden" name="exam_board_id" value="{{ $examBoard->id }}">
                <input type="hidden" name="board_year_id" value="{{ $boardYear->id }}">
                <input type="hidden" name="board_session_id" value="{{ $boardSession->id }}">
                <input type="hidden" name="board_program_id" value="{{ $boardProgram->id }}">
                <input type="hidden" name="board_course_id" value="{{ $boardCourse->id }}">

                <!-- Title -->
                <div class="mb-6">
                    <label class="block text-sm text-gray-400 mb-2">Resource Title</label>
                    <input type="text" name="title" 
                           class="w-full bg-white/10 border border-white/20 rounded-2xl px-5 py-4 text-white placeholder-gray-500 focus:outline-none focus:border-white/40"
                           placeholder="e.g. Mathematics Paper 1 - 2024" required>
                </div>

                <!-- Type -->
                <div class="mb-6">
                    <label class="block text-sm text-gray-400 mb-2">Resource Type</label>
                    <select name="type" 
                            class="w-full bg-white/10 border border-white/20 rounded-2xl px-5 py-4 text-white focus:outline-none focus:border-white/40">
                        <option class="text-black" value="past_paper">Past Paper</option>
                        <option class="text-black" value="module_note">Module Note</option>
                        <option class="text-black" value="syllabus">Syllabus</option>
                        <option class="text-black" value="ca_paper">CA Paper</option>
                        <option class="text-black" value="tutorial_sheet">Tutorial Sheet</option>
                        <option class="text-black" value="note">Note</option>
                    </select>
                </div>

                <!-- File -->
                <div class="mb-8">
                    <label class="block text-sm text-gray-400 mb-2">Upload PDF File</label>
                    <input type="file" name="file" accept="application/pdf"
                           class="w-full bg-white/10 border border-white/20 rounded-2xl px-5 py-4 text-white 
                                  file:mr-4 file:py-2 file:px-6 file:rounded-xl file:border-0 
                                  file:bg-white/10 file:text-white hover:file:bg-white/20">
                </div>

                <button type="submit"
                        class="w-full bg-blue-600 hover:bg-blue-700 transition py-4 rounded-2xl font-semibold text-lg">
                    Upload PDF Resource
                </button>

            </form>

        </div>
    </div>
</div>

@endsection