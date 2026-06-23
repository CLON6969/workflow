@extends('layouts.Reviewer')

@section('content')
<div class="container mx-auto py-6">
    <h1 class="text-2xl font-bold mb-4">Edit User</h1>

    {{-- ✅ Flash messages --}}
    @if($errors->any())
        <div class="bg-red-200 text-red-800 p-3 rounded mb-4">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if(session('success'))
        <div class="bg-green-200 text-green-800 p-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('Reviewer.users.update', $user->id) }}" method="POST" class="bg-white p-6 rounded shadow">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label class="block font-semibold mb-1">Name:</label>
            <input 
                type="text" 
                name="name" 
                class="w-full border px-3 py-2 rounded" 
                value="{{ old('name', $user->name) }}" 
                required>
        </div>

        <div class="mb-4">
            <label class="block font-semibold mb-1">Email:</label>
            <input 
                type="email" 
                name="email" 
                class="w-full border px-3 py-2 rounded" 
                value="{{ old('email', $user->email) }}" 
                required>
        </div>

        {{-- 🔐 Password with show/hide --}}
        <div class="mb-4 relative">
            <label class="block font-semibold mb-1">
                Password: <small class="text-gray-500">(Leave blank to keep current password)</small>
            </label>
            <div class="relative">
                <input 
                    type="password" 
                    name="password" 
                    id="password" 
                    class="w-full border px-3 py-2 rounded pr-10"
                    placeholder="Enter new password (optional)">
                
                <button 
                    type="button" 
                    id="togglePassword" 
                    class="absolute inset-y-0 right-3 flex items-center text-gray-600"
                    tabindex="-1"
                >
                    <i class="fa-solid fa-eye" id="toggleIcon"></i>
                </button>
            </div>
        </div>

        <div class="mb-4">
            <label class="block font-semibold mb-1">Role:</label>
            <select name="role_id" class="w-full border px-3 py-2 rounded" required>
                @foreach($roles as $role)
                    <option value="{{ $role->id }}" @if($role->id == $user->role_id) selected @endif>
                        {{ $role->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-4">
            <label class="block font-semibold mb-1">Status:</label>
            <select name="account_status" class="w-full border px-3 py-2 rounded" required>
                <option value="active" @if($user->account_status=='active') selected @endif>Active</option>
                <option value="pending" @if($user->account_status=='pending') selected @endif>Pending</option>
                <option value="suspended" @if($user->account_status=='suspended') selected @endif>Suspended</option>
                <option value="blocked" @if($user->account_status=='blocked') selected @endif>Blocked</option>
            </select>
        </div>

        <button type="submit" class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded">
            <i class="fa-solid fa-save mr-2"></i>Update User
        </button>

        <a href="{{ route('Reviewer.users.index') }}" class="ml-2 text-gray-600 hover:underline">
            <i class="fa-solid fa-arrow-left mr-1"></i>Cancel
        </a>
    </form>
</div>

{{-- 👁️ Password Toggle Script --}}
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const passwordField = document.getElementById("password");
        const toggleBtn = document.getElementById("togglePassword");
        const toggleIcon = document.getElementById("toggleIcon");

        toggleBtn.addEventListener("click", function() {
            const isHidden = passwordField.type === "password";
            passwordField.type = isHidden ? "text" : "password";
            toggleIcon.classList.toggle("fa-eye");
            toggleIcon.classList.toggle("fa-eye-slash");
        });
    });
</script>

{{-- ⚙️ Include Font Awesome --}}
<script src="https://kit.fontawesome.com/a2e0e6d6d2.js" crossorigin="anonymous"></script>
@endsection
