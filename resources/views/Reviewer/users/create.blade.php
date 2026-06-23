@extends('layouts.Reviewer')

@section('content')
<div class="container mx-auto py-6">
    <h1 class="text-2xl font-bold mb-4">Add New User</h1>

    {{-- Flash messages --}}
    @if($errors->any())
        <div class="bg-red-200 text-red-800 p-3 rounded mb-4">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('Reviewer.users.store') }}" method="POST" class="bg-white p-6 rounded shadow">
        @csrf
        <div class="mb-4">
            <label>Name:</label>
            <input type="text" name="name" class="w-full border px-3 py-2 rounded" value="{{ old('name') }}" required>
        </div>
        <div class="mb-4">
            <label>Email:</label>
            <input type="email" name="email" class="w-full border px-3 py-2 rounded" value="{{ old('email') }}" required>
        </div>
        <div class="mb-4">
            <label>Password:</label>
            <input type="password" name="password" class="w-full border px-3 py-2 rounded" required>
        </div>
        <div class="mb-4">
            <label>Role:</label>
            <select name="role_id" class="w-full border px-3 py-2 rounded" required>
                @foreach($roles as $role)
                    <option value="{{ $role->id }}">{{ $role->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-4">
            <label>Status:</label>
            <select name="account_status" class="w-full border px-3 py-2 rounded" required>
                <option value="active">Active</option>
                <option value="pending">Pending</option>
                <option value="suspended">Suspended</option>
                <option value="blocked">Blocked</option>
            </select>
        </div>
        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Create User</button>
    </form>
</div>
@endsection
