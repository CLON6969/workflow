@extends('layouts.app')

@section('content')
<div class="bg-white shadow rounded-lg p-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">My Applications</h1>
        <a href="{{ route('Applicant.applications.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
            New Application
        </a>
    </div>

    <table class="w-full">
        <thead>
            <tr class="bg-gray-100">
                <th class="px-4 py-3 text-left">Title</th>
                <th class="px-4 py-3 text-left">Category</th>
                <th class="px-4 py-3 text-left">Status</th>
                <th class="px-4 py-3 text-left">Submitted</th>
                <th class="px-4 py-3">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($applications as $app)
            <tr class="border-t">
                <td class="px-4 py-4">{{ $app->title }}</td>
                <td class="px-4 py-4">{{ ucfirst($app->category) }}</td>
                <td class="px-4 py-4">
                    <span class="px-3 py-1 rounded-full text-sm {{ $app->status_badge }}">
                        {{ $app->status_label }}
                    </span>
                </td>
                <td class="px-4 py-4">{{ $app->created_at->format('d M Y') }}</td>
                <td class="px-4 py-4">
                    @if($app->isDraft())
                        <a href="{{ route('Applicant.applications.edit', $app) }}" class="text-blue-600 hover:underline">Edit</a>
                        <form action="{{ route('Applicant.applications.submit', $app) }}" method="POST" class="inline ml-3">
                            @csrf
                            <button type="submit" class="text-green-600 hover:underline">Submit</button>
                        </form>
                    @else
                        <a href="#" class="text-gray-500">View</a>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection