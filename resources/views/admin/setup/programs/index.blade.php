@extends('layouts.admin')

@section('title', 'Programs')

@section('content')
<div class="p-8 text-black">

    <div class="flex justify-between mb-6">
        <h1 class="text-2xl font-bold">
            {{ $examBoard->name }} → {{ $boardYear->year }} → {{ $boardSession->name }} → Programs
        </h1>

        <a href="{{ route('admin.setup.boards.years.sessions.programs.create', [$examBoard, $boardYear, $boardSession]) }}"
           class="bg-indigo-600 px-5 py-2 rounded-xl">
            + Add Program
        </a>
    </div>

    @if(session('success'))
        <div class="mb-4 bg-green-500 p-3 rounded">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white text-black rounded-xl p-6">

        <table class="w-full">
            <thead>
                <tr class="border-b">
                    <th class="p-2 text-left">Program</th>
                    <th class="p-2 text-left">Level</th>
                    <th class="p-2 text-right">Actions</th>
                </tr>
            </thead>

            <tbody>
                @forelse($programs as $program)
                    <tr class="border-b">
                        <td class="p-2 font-semibold">
                            {{ $program->name }}
                        </td>

                        <td class="p-2">
                            {{ $program->level ?? '-' }}
                        </td>

                        <td class="p-2 text-right space-x-2">

                            <a href="{{ route('admin.setup.boards.years.sessions.programs.courses.index', [$examBoard, $boardYear, $boardSession, $program]) }}"
                               class="text-blue-600">
                                Courses →
                            </a>

                            <a href="{{ route('admin.setup.boards.years.sessions.programs.edit', [$examBoard, $boardYear, $boardSession, $program]) }}"
                               class="text-yellow-600">
                                Edit
                            </a>

                            <form method="POST"
                                  action="{{ route('admin.setup.boards.years.sessions.programs.destroy', [$examBoard, $boardYear, $boardSession, $program]) }}"
                                  class="inline">
                                @csrf
                                @method('DELETE')

                                <button class="text-red-600"
                                        onclick="return confirm('Delete program?')">
                                    Delete
                                </button>
                            </form>

                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="p-4 text-center text-gray-500">
                            No programs yet
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

    </div>

    <div class="mt-6">
        <a href="{{ route('admin.setup.boards.years.sessions.index', [$examBoard, $boardYear]) }}"
           class="text-gray-400">
            ← Back to Sessions
        </a>
    </div>

</div>
@endsection

