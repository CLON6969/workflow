@extends('layouts.admin')

@section('title', 'Add Program')

@section('content')
<div class="p-8 text-white">

    <h1 class="text-2xl font-bold mb-6">
        Add Program → {{ $boardSession->name }}
    </h1>

    @if($errors->any())
        <div class="mb-4 bg-red-500 p-3 rounded">
            @foreach($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <form method="POST"
          action="{{ route('admin.setup.boards.years.sessions.programs.store', [$examBoard, $boardYear, $boardSession]) }}">
        @csrf

        <div class="mb-4">
            <label>Program Name</label>
            <input type="text" name="name"
                   class="w-full p-2 rounded text-black"
                   required>
        </div>

        <div class="mb-4">
            <label>Level (optional)</label>
            <input type="text" name="level"
                   class="w-full p-2 rounded text-black">
        </div>

        <button class="bg-indigo-600 px-5 py-2 rounded">
            Save
        </button>
    </form>

</div>
@endsection