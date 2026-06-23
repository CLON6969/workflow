@extends('layouts.admin')

@section('title', 'Courses')

@section('content')
<div class="p-8 text-black">

    <div class="flex justify-between mb-6">
        <h1 class="text-2xl font-bold">
            {{ $examBoard->name }} → {{ $boardYear->year }} → {{ $boardSession->name }} → {{ $boardProgram->name }} → Courses
        </h1>
    </div>

    {{-- SUCCESS --}}
    @if(session('success'))
        <div class="mb-4 bg-green-500 p-3 rounded">
            {{ session('success') }}
        </div>
    @endif

    {{-- ADD COURSE --}}
    <div class="bg-white text-black p-6 rounded-xl mb-6">
        <h2 class="font-bold mb-4">Add Course</h2>

        <form method="POST"
              action="{{ route('admin.setup.boards.years.sessions.programs.courses.store', [$examBoard, $boardYear, $boardSession, $boardProgram]) }}">
            @csrf

            <div class="flex gap-3">
                <input type="text" name="name"
                       class="w-full p-2 border rounded"
                       placeholder="Course name (e.g. Mathematics)"
                       required>

                <button class="bg-indigo-600 text-white px-4 rounded">
                    Add
                </button>
            </div>
        </form>
    </div>

    {{-- COURSES LIST --}}
    <div class="bg-white text-black rounded-xl p-6">

        <table class="w-full">
            <thead>
                <tr class="border-b">
                    <th class="p-2 text-left">Course Name</th>
                    <th class="p-2 text-right">Actions</th>
                </tr>
            </thead>

            <tbody>
                @forelse($courses as $course)
                    <tr class="border-b">
                        <td class="p-2 font-semibold">
                            {{ $course->name }}
                        </td>

                        <td class="p-2 text-right space-x-2">

                            <a href="{{ route('admin.setup.boards.years.sessions.programs.courses.edit', [$examBoard, $boardYear, $boardSession, $boardProgram, $course]) }}"
                               class="text-yellow-600">
                                Edit
                            </a>

                            <form method="POST"
                                  action="{{ route('admin.setup.boards.years.sessions.programs.courses.destroy', [$examBoard, $boardYear, $boardSession, $boardProgram, $course]) }}"
                                  class="inline">
                                @csrf
                                @method('DELETE')

                                <button class="text-red-600"
                                        onclick="return confirm('Delete course?')">
                                    Delete
                                </button>
                            </form>

                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="2" class="p-4 text-center text-gray-500">
                            No courses yet
                        </td>
                    </tr>
                @endforelse
            </tbody>

        </table>

    </div>

    {{-- BACK --}}
    <div class="mt-6">
        <a href="{{ route('admin.setup.boards.years.sessions.programs.index', [$examBoard, $boardYear, $boardSession]) }}"
           class="text-gray-400">
            ← Back to Programs
        </a>
    </div>

</div>
@endsection

