@extends('layouts.app')

@section('title', 'Log in - ' . config('app.name'))

@section('content')
@php
    $loginType = $loginType ?? 'customer';
    $titleMap = [
        'customer' => 'Welcome back',
        'seller' => 'Seller sign in',
        'admin' => 'Admin sign in',
    ];
    $subtitleMap = [
        'customer' => 'Please enter your details to sign in.',
        'seller' => 'Access your seller dashboard and manage your listings.',
        'admin' => 'Sign in to the admin control room and manage the marketplace.',
    ];
@endphp

<div class="min-h-[calc(100vh-140px)] flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full bg-white dark:bg-gray-800 rounded-2xl shadow-xl shadow-gray-200/50 dark:shadow-none border border-gray-100 dark:border-gray-700 p-8">
        <div class="text-center mb-8">
            <h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">{{ $titleMap[$loginType] }}</h2>
            <p class="text-gray-500 dark:text-gray-400">{{ $subtitleMap[$loginType] }}</p>
        </div>

        <form method="POST" action="{{ route('login.store') }}" class="space-y-6">
            @csrf
            <input type="hidden" name="login_type" value="{{ $loginType }}">

            <!-- Email Address -->
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Email address</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username"
                       class="w-full px-4 py-2 rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition-all">
                @error('email')
                    <p class="mt-1 text-sm text-rose-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Password -->
            <div>
                <div class="flex items-center justify-between mb-1">
                    <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Password</label>
                </div>
                <div class="relative">
                    <input id="password" type="password" name="password" required autocomplete="current-password"
                           class="w-full pr-20 px-4 py-2 rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition-all">
                    <button id="toggle-password" type="button" class="absolute inset-y-0 right-2 flex items-center rounded-lg px-3 text-sm font-semibold text-indigo-600 hover:text-indigo-800 dark:text-indigo-400 dark:hover:text-indigo-200 focus:outline-none">
                        Show
                    </button>
                </div>
                @error('password')
                    <p class="mt-1 text-sm text-rose-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Remember Me -->
            <div class="flex items-center">
                <input id="remember_me" type="checkbox" name="remember" class="w-4 h-4 text-indigo-600 rounded border-gray-300 focus:ring-indigo-500 dark:border-gray-600 dark:bg-gray-700 dark:focus:ring-indigo-600">
                <label for="remember_me" class="ml-2 block text-sm text-gray-700 dark:text-gray-300">Remember me</label>
            </div>

            <x-ui.button type="submit" class="w-full justify-center">Sign in</x-ui.button>
        </form>

        <p class="mt-8 text-center text-sm text-gray-600 dark:text-gray-400">
            Don't have an account?
            <a href="{{ route('register') }}" class="font-medium text-indigo-600 hover:text-indigo-500 dark:text-indigo-400">Sign up</a>
        </p>

        @if($loginType === 'customer')
            <div class="mt-6 rounded-2xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900 p-4 text-sm text-gray-600 dark:text-gray-300">
                <p class="font-medium text-gray-900 dark:text-white mb-2">Need a different portal?</p>
                <div class="space-y-2">
                    <a href="{{ route('seller.login') }}" class="block text-indigo-600 hover:text-indigo-500 dark:text-indigo-400">Seller login</a>
                    <a href="{{ route('admin.login') }}" class="block text-indigo-600 hover:text-indigo-500 dark:text-indigo-400">Admin login</a>
                </div>
            </div>
        @endif
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const passwordInput = document.getElementById('password');
        const toggleButton = document.getElementById('toggle-password');

        if (!passwordInput || !toggleButton) {
            return;
        }

        toggleButton.addEventListener('click', function (event) {
            event.preventDefault();
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            toggleButton.textContent = type === 'password' ? 'Show' : 'Hide';
        });
    });
</script>
@endsection
