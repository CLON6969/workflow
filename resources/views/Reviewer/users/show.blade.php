@extends('layouts.Reviewer')


@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">User Details: {{ $user->name }}</h1>

    {{-- Success / Error Messages --}}
    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif
    @if($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            <ul class="list-disc pl-5">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Basic Info --}}
    <div class="bg-white p-4 rounded shadow mb-4">
        <p><strong>Name:</strong> {{ $user->name }}</p>
        <p><strong>Email:</strong> {{ $user->email }}</p>
        <p><strong>Role:</strong> {{ $user->role->name ?? 'N/A' }}</p>
        <p><strong>Status:</strong> {{ ucfirst($user->account_status) }}</p>
        <p><strong>Phone:</strong> {{ $user->phone ?? 'N/A' }}</p>
        <p><strong>City:</strong> {{ $user->city ?? 'N/A' }}</p>
    </div>

    {{-- Sub Accounts --}}
    <div class="bg-white p-4 rounded shadow mb-4">
        <h2 class="font-bold mb-2">Sub Accounts</h2>
        @if($user->subAccounts->count())
            <ul class="list-disc pl-5">
                @foreach($user->subAccounts as $sub)
                    <li>{{ $sub->name }} ({{ $sub->email }})</li>
                @endforeach
            </ul>
        @else
            <p>No sub-accounts.</p>
        @endif
    </div>

    {{-- Products --}}
    <div class="bg-white p-4 rounded shadow mb-4">
        <h2 class="font-bold mb-2">Products</h2>
        @if($user->products->count())
            <ul class="list-disc pl-5">
                @foreach($user->products as $product)
                    <li>{{ $product->name }} - {{ $product->price ?? 'N/A' }}</li>
                @endforeach
            </ul>
        @else
            <p>No products.</p>
        @endif
    </div>



    {{-- Reviews --}}
    <div class="bg-white p-4 rounded shadow mb-4">
        <h2 class="font-bold mb-2">Reviews</h2>
        @if($user->reviews->count())
            <ul class="list-disc pl-5">
                @foreach($user->reviews as $review)
                    <li>{{ $review->product->name ?? 'Product Deleted' }}: {{ $review->rating }}/5 - "{{ $review->comment }}"</li>
                @endforeach
            </ul>
        @else
            <p>No reviews.</p>
        @endif
    </div>

    {{-- Messages --}}
    <div class="bg-white p-4 rounded shadow mb-4">
        <h2 class="font-bold mb-2">Messages</h2>
        @if($user->messages->count())
            <ul class="list-disc pl-5">
                @foreach($user->messages as $msg)
                    <li>To: {{ $msg->receiver->name ?? 'Deleted User' }} - "{{ $msg->content }}"</li>
                @endforeach
            </ul>
        @else
            <p>No messages.</p>
        @endif
    </div>

    <a href="{{ route('Reviewer.users.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded">Back to Users</a>
</div>
@endsection
