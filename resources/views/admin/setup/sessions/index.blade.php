@extends('layouts.admin')

@section('title', 'Sessions')

@section('content')
<div class="p-8 text-black">

    <div class="flex justify-between mb-6">
        <h1 class="text-2xl font-bold">
            {{ $examBoard->name }} → {{ $boardYear->year }} → Sessions
        </h1>

        <a href="{{ route('admin.setup.boards.years.sessions.create', [$examBoard, $boardYear]) }}"
           class="bg-indigo-600 px-5 py-2 rounded-xl">
            + Add Session
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
                    <th class="p-2 text-left">Session Name</th>
                    <th class="p-2 text-right">Actions</th>
                </tr>
            </thead>

            <tbody>
                @forelse($sessions as $session)
                    <tr class="border-b">
                        <td class="p-2 font-semibold">
                            {{ $session->name }}
                        </td>

                        <td class="p-2 text-right space-x-2">

                            <a href="{{ route('admin.setup.boards.years.sessions.programs.index', [$examBoard, $boardYear, $session]) }}"
                               class="text-blue-600">
                                Programs →
                            </a>

                            <a href="{{ route('admin.setup.boards.years.sessions.edit', [$examBoard, $boardYear, $session]) }}"
                               class="text-yellow-600">
                                Edit
                            </a>

                            <form method="POST"
                                  action="{{ route('admin.setup.boards.years.sessions.destroy', [$examBoard, $boardYear, $session]) }}"
                                  class="inline">
                                @csrf
                                @method('DELETE')

                                <button class="text-red-600"
                                        onclick="return confirm('Delete session?')">
                                    Delete
                                </button>
                            </form>

                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="2" class="p-4 text-center text-gray-500">
                            No sessions yet
                        </td>
                    </tr>
                @endforelse
            </tbody>

        </table>

    </div>

    <div class="mt-6">
        <a href="{{ route('admin.setup.boards.years.index', $examBoard) }}"
           class="text-gray-400">
            ← Back to Years
        </a>
    </div>

</div>
@endsection