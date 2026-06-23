@extends('layouts.admin')

@section('content')
<div class="p-6 bg-gray-50 min-h-screen">

    <h1 class="text-2xl font-semibold text-gray-800 mb-6">Product Reviews</h1>

    {{-- ✅ Success alert --}}
    @if(session('success'))
        <div class="mb-4 bg-green-100 border border-green-300 text-green-800 rounded-md p-3">
            {{ session('success') }}
        </div>
    @endif

    {{-- 📋 Review table --}}
    <div class="overflow-x-auto bg-white shadow rounded-lg">
        <table class="min-w-full text-sm text-gray-700">
            <thead class="bg-gray-100 text-gray-600 uppercase text-xs">
                <tr>
                    <th class="px-4 py-3 text-left">User</th>
                    <th class="px-4 py-3 text-left">Product</th>
                    <th class="px-4 py-3 text-left">Rating</th>
                    <th class="px-4 py-3 text-left">Review</th>
                    <th class="px-4 py-3 text-left">Created At</th>
                    <th class="px-4 py-3 text-right">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($reviews as $review)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="px-4 py-3">{{ $review->user->name ?? 'N/A' }}</td>
                        <td class="px-4 py-3">{{ $review->product->name ?? '—' }}</td>
                        <td class="px-4 py-3">{{ $review->rating }}/5</td>
                        <td class="px-4 py-3 truncate max-w-xs">{{ Str::limit($review->content, 80) }}</td>
                        <td class="px-4 py-3">{{ $review->created_at->format('d M Y H:i') }}</td>
                        <td class="px-4 py-3 text-right">
                            <form method="POST" action="{{ route('admin.reviews.destroy', $review->id) }}" class="inline">
                                @csrf
                                @method('DELETE')
                                <button onclick="return confirm('Delete this review?')" class="text-red-600 hover:text-red-800">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center py-6 text-gray-500">No reviews found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    <div class="mt-4">
        {{ $reviews->links() }}
    </div>

</div>
@endsection
