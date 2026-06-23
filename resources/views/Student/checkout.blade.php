@extends('layouts.Customer')

@section('title', 'Checkout')

@section('content')
<div class="container max-w-6xl mx-auto py-10 pt-24">

    {{-- Header --}}
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-800">Checkout</h1>
        <p class="text-gray-500">
            Complete your payment to confirm your order
        </p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

        {{-- ================= LEFT: ORDER DETAILS ================= --}}
        <div class="lg:col-span-2 space-y-6">

            {{-- Order Items --}}
            <div class="bg-white rounded-xl shadow border p-6">
                <h2 class="text-lg font-semibold mb-4">Order Items</h2>

                <div class="space-y-4">
                    @foreach($order->items as $item)
                        <div class="flex items-center gap-4 border-b pb-4 last:border-b-0">

                            {{-- Product Image --}}
                            <div class="w-20 h-20 bg-gray-100 rounded-lg flex items-center justify-center overflow-hidden">
                                @if($item->product->media->count())
                                    <img
                                        src="{{ asset('public/storage/' . $item->product->media->first()->file_path) }}"
                                        class="w-full h-full object-contain">
                                @else
                                    <span class="text-xs text-gray-400">No image</span>
                                @endif
                            </div>

                            {{-- Product Info --}}
                            <div class="flex-1">
                                <p class="font-medium text-gray-800">
                                    {{ $item->product->name }}
                                </p>
                                <p class="text-sm text-gray-500">
                                    Quantity: {{ $item->quantity }}
                                </p>
                            </div>

                            {{-- Price --}}
                            <div class="text-right">
                                <p class="font-semibold text-gray-800">
                                    ZMW {{ number_format($item->subtotal, 2) }}
                                </p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Buyer Info --}}
            <div class="bg-white rounded-xl shadow border p-6">
                <h2 class="text-lg font-semibold mb-4">Buyer Information</h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                    <div>
                        <p class="text-gray-500">Full Name</p>
                        <p class="font-medium">{{ auth()->user()->name }}</p>
                    </div>

                    <div>
                        <p class="text-gray-500">Email Address</p>
                        <p class="font-medium">{{ auth()->user()->email }}</p>
                    </div>
                </div>
            </div>

        </div>

        {{-- ================= RIGHT: PAYMENT ================= --}}
        <div class="space-y-6">

            {{-- Order Summary --}}
            <div class="bg-white rounded-xl shadow border p-6">
                <h2 class="text-lg font-semibold mb-4">Order Summary</h2>

                <div class="flex justify-between text-gray-600 mb-2">
                    <span>Subtotal</span>
                    <span>ZMW {{ number_format($order->total_amount, 2) }}</span>
                </div>

                <div class="flex justify-between text-gray-600 mb-2">
                    <span>Service Fee</span>
                    <span>ZMW 0.00</span>
                </div>

                <hr class="my-3">

                <div class="flex justify-between text-lg font-bold text-gray-800">
                    <span>Total</span>
                    <span>ZMW {{ number_format($order->total_amount, 2) }}</span>
                </div>
            </div>

            {{-- Payment Form --}}
            <form method="POST"
                  action="{{ route('Customer.checkout.pay', $order) }}"
                  class="bg-white rounded-xl shadow border p-6 space-y-4">
                @csrf

                <h2 class="text-lg font-semibold">Select Payment Method</h2>

                {{-- MTN --}}
                <label class="flex items-center gap-3 border rounded-lg p-3 cursor-pointer hover:bg-gray-50">
                    <input type="radio" name="method" value="mtn" checked>
                    <div>
                        <p class="font-medium">MTN Mobile Money</p>
                        <p class="text-sm text-gray-500">Fast & secure</p>
                    </div>
                </label>

                {{-- Airtel --}}
                <label class="flex items-center gap-3 border rounded-lg p-3 cursor-pointer hover:bg-gray-50">
                    <input type="radio" name="method" value="airtel">
                    <div>
                        <p class="font-medium">Airtel Money</p>
                        <p class="text-sm text-gray-500">Instant payment</p>
                    </div>
                </label>

                {{-- Zamtel --}}
                <label class="flex items-center gap-3 border rounded-lg p-3 cursor-pointer hover:bg-gray-50">
                    <input type="radio" name="method" value="zamtel">
                    <div>
                        <p class="font-medium">Zamtel Kwacha</p>
                        <p class="text-sm text-gray-500">Mobile wallet</p>
                    </div>
                </label>

                {{-- Card (Future) --}}
                <label class="flex items-center gap-3 border rounded-lg p-3 opacity-60 cursor-not-allowed">
                    <input type="radio" disabled>
                    <div>
                        <p class="font-medium">Card Payment</p>
                        <p class="text-sm text-gray-500">Coming soon</p>
                    </div>
                </label>

                {{-- Pay Button --}}
                <button type="submit"
                        class="w-full bg-green-600 hover:bg-green-700 text-white font-semibold py-3 rounded-lg shadow transition">
                    💳 Pay ZMW {{ number_format($order->total_amount, 2) }}
                </button>

                <p class="text-xs text-gray-500 text-center">
                    Secure checkout • ZumHub protected payments
                </p>
            </form>

        </div>
    </div>
</div>
@endsection
