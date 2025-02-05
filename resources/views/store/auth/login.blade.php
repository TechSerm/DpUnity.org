@extends('store.layout.layout')

@section('content')
<div class="min-h-screenflex flex-col justify-center sm:px-6 lg:px-8">
    <div class="sm:mx-auto sm:w-full sm:max-w-md">
        <div class="text-center">
            
            <h2 class="mt-6 text-center text-3xl font-extrabold text-green-900">
                আপনার অ্যাকাউন্টে লগ ইন করুন
            </h2>
        </div>

        <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
            <div class="bg-white py-8 px-4 shadow-lg sm:rounded-lg sm:px-10 border border-gray-100">
                <form class="space-y-6" action="{{ route('login') }}" method="POST">
                    @csrf
                    
                    <!-- Email Input -->
                    <div>
                        <label for="email" class="block text-mb font-medium text-green-700">
                            ইমেল ঠিকানা
                        </label>
                        <div class="mt-1">
                            <input 
                                id="email" 
                                name="email" 
                                type="email" 
                                autocomplete="email" 
                                required 
                                class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-green-500 focus:border-green-500 sm:text-sm"
                                placeholder="আপনার ইমেল লিখুন"
                            >
                        </div>
                        @error('email')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Password Input -->
                    <div>
                        <label for="password" class="block text-mb font-medium text-green-700">
                            পাসওয়ার্ড
                        </label>
                        <div class="mt-1">
                            <input 
                                id="password" 
                                name="password" 
                                type="password" 
                                autocomplete="current-password" 
                                required 
                                class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-green-500 focus:border-green-500 sm:text-sm"
                                placeholder="আপনার পাসওয়ার্ড লিখুন"
                            >
                        </div>
                        @error('password')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Remember Me -->
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <input 
                                id="remember_me" 
                                name="remember" 
                                type="checkbox" 
                                class="h-4 w-4 text-green-600 focus:ring-green-500 border-gray-300 rounded"
                            >
                            <label for="remember_me" class="ml-2 block text-mb text-gray-900">
                                আমাকে মনে রাখুন
                            </label>
                        </div>

                        @if (Route::has('password.request'))
                            <div class="text-mb">
                                <a href="{{ route('password.request') }}" class="font-medium text-green-600 hover:text-green-500">
                                    পাসওয়ার্ড ভুলে গেছেন?
                                </a>
                            </div>
                        @endif
                    </div>

                    <!-- Submit Button -->
                    <div>
                        <button 
                            type="submit" 
                            class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-mb font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition duration-300"
                        >
                            লগ ইন
                        </button>
                    </div>
                </form>

                <!-- Social Login or Registration -->
                <div class="mt-6">
                    <div class="relative">
                        <div class="absolute inset-0 flex items-center">
                            <div class="w-full border-t border-gray-300"></div>
                        </div>
                        <div class="relative flex justify-center text-md">
                            <span class="px-2 bg-white text-gray-500">
                                অথবা
                            </span>
                        </div>
                    </div>

                    <div class="mt-6">
                        @if (Route::has('register'))
                            <p class="mt-2 text-center text-md text-gray-600">
                                নতুন ব্যবহারকারী? 
                                <a href="{{ route('register') }}" class="font-medium text-green-600 hover:text-green-500">
                                    নিবন্ধন করুন
                                </a>
                            </p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
