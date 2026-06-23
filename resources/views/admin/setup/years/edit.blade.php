@extends('layouts.admin')

@section('title', 'Edit Year')

@section('content')
<div class="p-8 text-white">

    <h1 class="text-2xl font-bold mb-6">
        Edit Year - {{ $examBoard->name }}
    </h1>

    @if($errors->any())
        <div class="mb-4 bg-red-500 p-3 rounded">
            @foreach($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <form method="POST"
          action="{{ route('admin.setup.boards.years.update', [$examBoard, $boardYear]) }}">

        @csrf
        @method('PUT')

        <div class="mb-4">
            <label>Year</label>
            <input type="number"
                   name="year"
                   value="{{ old('year', $boardYear->year) }}"
                   class="w-full p-2 rounded text-black">
        </div>

        <button class="bg-indigo-600 px-5 py-2 rounded">
            Update
        </button>

    </form>

</div>
@endsection
