@extends('layouts.admin')

@section('content')
<div class="p-8">
    <h1 class="text-3xl font-bold mb-8">Academic Setup</h1>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        @foreach($boards as $board)
            <div class="bg-white p-6 rounded-3xl shadow hover:shadow-xl transition">
                <h2 class="text-xl font-semibold">{{ $board->name }}</h2>

                <div class="mt-4 text-sm text-gray-500">
                    Years: {{ $board->years_count }} <br>
                    Programs: {{ $board->programs_count }}
                </div>

                <a href="{{ route('setup.boards.years', $board) }}"
                   class="inline-block mt-4 text-indigo-600 font-medium">
                   Manage →
                </a>
            </div>
        @endforeach
    </div>
</div>
@endsection