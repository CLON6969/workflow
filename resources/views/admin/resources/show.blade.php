@extends('layouts.admin')

@section('title', 'View Resource')

@section('content')
<div class="p-8 text-black">

    <h1 class="text-2xl mb-4">{{ $resource->title }}</h1>

    <p><strong>Board:</strong> {{ $resource->examBoard->name }}</p>
    <p><strong>Year:</strong> {{ $resource->boardYear->year }}</p>
    <p><strong>Session:</strong> {{ $resource->boardSession->session_name }}</p>
    <p><strong>Program:</strong> {{ $resource->boardProgram->name }}</p>
    <p><strong>Course:</strong> {{ $resource->boardCourse->name }}</p>

    <a href="{{ asset('storage/' . $resource->file_path) }}"
       target="_blank"
       class="bg-green-600 px-4 py-2 mt-4 inline-block rounded">
        Open PDF
    </a>

</div>
@endsection