@extends('layouts.app')

@section('title', 'Checkout - ' . config('app.name'))

@section('content')
<div class="bg-gray-50 dark:bg-gray-900 min-h-[calc(100vh-140px)] py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="mb-8">
            <h1 class="text-3xl font-extrabold text-gray-900 dark:text-white">Checkout</h1>
        </div>

        <form action="{{ url('/checkout') }}" method="POST" class="lg:grid lg:grid-cols-12 lg:gap-x-12 lg:items-start">
            @csrf
            
            <!-- Checkout Form -->
            <div class="lg:col-span-7">
                <div class="bg-white dark:bg-gray-800 shadow-sm border border-gray-200 dark:border-gray-700 rounded-2xl p-6 sm:p-8 mb-8">
                    <h2 class="text-lg font-medium text-gray-900 dark:text-white mb-6">Shipping Information</h2>
                    
                    @if($addresses->count() > 0)
                        <div class="mb-8">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-4">Saved Addresses</label>
                            <div class="grid gap-4 sm:grid-cols-2">
                                @foreach($addresses as $index => $address)
                                <label class="relative flex cursor-pointer rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 p-4 shadow-sm focus:outline-none">
                                    <input type="radio" name="address_id" value="{{ $address->id }}" class="sr-only peer" {{ $index === 0 ? 'checked' : '' }}>
                                    <span class="flex flex-1">
                                        <span class="flex flex-col">
                                            <span class="block text-sm font-medium text-gray-900 dark:text-white">{{ $address->title ?? 'Address '.($index+1) }}</span>
                                            <span class="mt-1 flex items-center text-sm text-gray-500 dark:text-gray-400">{{ $address->address }}, {{ $address->city }}<br>{{ $address->postal_code }}, {{ $address->country }}</span>
                                        </span>
                                    </span>
                                    <svg class="h-5 w-5 text-indigo-600 dark:text-indigo-400 invisible peer-checked:visible" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" />
                                    </svg>
                                    <span class="pointer-events-none absolute -inset-px rounded-xl border-2 border-transparent peer-checked:border-indigo-600 dark:peer-checked:border-indigo-500" aria-hidden="true"></span>
                                </label>
                                @endforeach
                            </div>
                            
                            <div class="mt-4 flex items-center">
                                <input type="radio" name="address_id" value="" id="new_address_radio" class="h-4 w-4 border-gray-300 text-indigo-600 focus:ring-indigo-500">
                                <label for="new_address_radio" class="ml-3 block text-sm font-medium text-gray-700 dark:text-gray-300">Use a new address</label>
                            </div>
                        </div>
                    @endif

                    <div id="new_address_form" class="{{ $addresses->count() > 0 ? 'hidden' : '' }} space-y-5">
                        <div>
                            <label for="new_address" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Street Address</label>
                            <input type="text" id="new_address" name="new_address" class="w-full px-4 py-2 rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-indigo-500 outline-none transition-all">
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                            <div>
                                <label for="city" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">City</label>
                                <input type="text" id="city" name="city" class="w-full px-4 py-2 rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-indigo-500 outline-none transition-all">
                            </div>
                            <div>
                                <label for="postal_code" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Postal Code</label>
                                <input type="text" id="postal_code" name="postal_code" class="w-full px-4 py-2 rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-indigo-500 outline-none transition-all">
                            </div>
                        </div>

                        <div>
                            <label for="country" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Country</label>
                            <select id="country" name="country" class="w-full px-4 py-2 rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-indigo-500 outline-none transition-all">
                                <option value="US">United States</option>
                                <option value="CA">Canada</option>
                                <option value="UK">United Kingdom</option>
                                <option value="AU">Australia</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>
                        
                        <div class="flex items-center mt-4">
                            <input id="save_address" type="checkbox" name="save_address" value="1" class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500 dark:border-gray-600 dark:bg-gray-700">
                            <label for="save_address" class="ml-2 block text-sm text-gray-700 dark:text-gray-300">Save this address for future use</label>
                        </div>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 shadow-sm border border-gray-200 dark:border-gray-700 rounded-2xl p-6 sm:p-8">
                    <h2 class="text-lg font-medium text-gray-900 dark:text-white mb-6">Payment Method</h2>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">Cash on Delivery (COD) is selected by default for this demo.</p>
                    
                    <div class="relative flex items-center justify-between p-4 rounded-xl border-2 border-indigo-600 dark:border-indigo-500 bg-indigo-50 dark:bg-indigo-900/20">
                        <div class="flex items-center">
                            <svg class="h-6 w-6 text-indigo-600 dark:text-indigo-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                            <span class="text-sm font-medium text-indigo-900 dark:text-indigo-300">Cash on Delivery</span>
                        </div>
                        <svg class="h-5 w-5 text-indigo-600 dark:text-indigo-400" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" />
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Order Summary -->
            <div class="mt-10 lg:mt-0 lg:col-span-5">
                <div class="bg-white dark:bg-gray-800 shadow-sm border border-gray-200 dark:border-gray-700 rounded-2xl p-6 sm:p-8 sticky top-24">
                    <h2 class="text-lg font-medium text-gray-900 dark:text-white mb-6 border-b border-gray-200 dark:border-gray-700 pb-4">Order Summary</h2>

                    <div class="flow-root mb-6">
                        <ul role="list" class="-my-4 divide-y divide-gray-200 dark:divide-gray-700">
                            @foreach($cartItems as $item)
                            <li class="flex py-4">
                                <div class="flex-shrink-0 w-16 h-16 rounded-lg overflow-hidden border border-gray-200 dark:border-gray-700 bg-gray-100">
                                    @if($item->product->image)
                                        <img src="{{ asset('storage/'.$item->product->image) }}" class="w-full h-full object-center object-cover">
                                    @endif
                                </div>
                                <div class="ml-4 flex-1 flex flex-col justify-center">
                                    <div class="flex justify-between text-sm font-medium text-gray-900 dark:text-white">
                                        <h3>{{ $item->product->name }}</h3>
                                        <p class="ml-4">${{ number_format($item->product->price * $item->quantity, 2) }}</p>
                                    </div>
                                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Qty {{ $item->quantity }}</p>
                                </div>
                            </li>
                            @endforeach
                        </ul>
                    </div>

                    <dl class="space-y-4 text-sm text-gray-600 dark:text-gray-400 border-t border-gray-200 dark:border-gray-700 pt-6 mb-6">
                        <div class="flex justify-between">
                            <dt>Subtotal</dt>
                            <dd class="font-medium text-gray-900 dark:text-white">${{ number_format($subtotal, 2) }}</dd>
                        </div>
                        <div class="flex justify-between">
                            <dt>Shipping</dt>
                            <dd class="font-medium text-gray-900 dark:text-white">$5.00</dd>
                        </div>
                        <div class="flex justify-between">
                            <dt>Taxes</dt>
                            <dd class="font-medium text-gray-900 dark:text-white">${{ number_format($subtotal * 0.1, 2) }}</dd>
                        </div>
                        <div class="flex justify-between items-center border-t border-gray-200 dark:border-gray-700 pt-4 mt-4">
                            <dt class="text-base font-bold text-gray-900 dark:text-white">Total</dt>
                            <dd class="text-xl font-bold text-indigo-600 dark:text-indigo-400">${{ number_format($subtotal + 5.00 + ($subtotal * 0.1), 2) }}</dd>
                        </div>
                    </dl>

                    <button type="submit" class="w-full bg-indigo-600 border border-transparent rounded-xl shadow-lg shadow-indigo-500/30 py-4 px-4 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all transform hover:-translate-y-0.5 flex justify-center items-center">
                        Place Order
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const radios = document.querySelectorAll('input[name="address_id"]');
        const newAddressForm = document.getElementById('new_address_form');
        const newAddressInputs = newAddressForm.querySelectorAll('input[type="text"], select');

        radios.forEach(radio => {
            radio.addEventListener('change', function() {
                if (this.value === "") {
                    newAddressForm.classList.remove('hidden');
                    newAddressInputs.forEach(input => input.setAttribute('required', 'required'));
                } else {
                    newAddressForm.classList.add('hidden');
                    newAddressInputs.forEach(input => input.removeAttribute('required'));
                }
            });
        });
    });
</script>
@endsection
