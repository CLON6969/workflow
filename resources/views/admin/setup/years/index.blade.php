@extends('layouts.admin')

@section('title', 'Board Years')

@section('content')
<div class="p-8 text-black">

    <div class="flex justify-between mb-6">
        <h1 class="text-2xl font-bold">
            {{ $examBoard->name }} - Years
        </h1>

        <a href="{{ route('admin.setup.boards.years.create', $examBoard) }}"
           class="bg-indigo-600 px-5 py-2 rounded-xl">
            + Add Year
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
                    <th class="text-left p-2">Year</th>
                    <th class="text-right p-2">Actions</th>
                </tr>
            </thead>

            <tbody>
                @forelse($years as $year)
                    <tr class="border-b">
                        <td class="p-2 font-semibold">
                            {{ $year->year }}
                        </td>

                        <td class="p-2 text-right space-x-2">

                            <a href="{{ route('admin.setup.boards.years.sessions.index', [$examBoard, $year]) }}"
                               class="text-blue-600">
                                Sessions →
                            </a>

                            <a href="{{ route('admin.setup.boards.years.edit', [$examBoard, $year]) }}"
                               class="text-yellow-600">
                                Edit
                            </a>

                            <form method="POST"
                                  action="{{ route('admin.setup.boards.years.destroy', [$examBoard, $year]) }}"
                                  class="inline">
                                @csrf
                                @method('DELETE')

                                <button class="text-red-600"
                                        onclick="return confirm('Delete year?')">
                                    Delete
                                </button>
                            </form>

                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="2" class="p-4 text-center text-gray-500">
                            No years yet
                        </td>
                    </tr>
                @endforelse
            </tbody>

        </table>

    </div>

    <div class="mt-6">
        <a href="{{ route('admin.setup.boards.index') }}" class="text-gray-400">
            ← Back to Boards
        </a>
    </div>

</div>
@endsection