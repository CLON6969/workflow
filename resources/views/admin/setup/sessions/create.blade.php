@extends('layouts.admin')

@section('title', 'Add Session')

@section('content')
<div class="p-8 text-white">

    <h1 class="text-2xl font-bold mb-6">
        Add Session → {{ $examBoard->name }} ({{ $boardYear->year }})
    </h1>

    @if($errors->any())
        <div class="mb-4 bg-red-500 p-3 rounded">
            @foreach($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <form method="POST"
          action="{{ route('admin.setup.boards.years.sessions.store', [$examBoard, $boardYear]) }}">
        @csrf

        <div class="mb-4">
            <label>Session Name</label>
            <input type="text" name="name"
                   class="w-full p-2 rounded text-black"
                   placeholder="e.g. January, June, November"
                   required>
        </div>

        <button class="bg-indigo-600 px-5 py-2 rounded">
            Save
        </button>
    </form>

</div>
@endsection
