@extends('store.layout.layout')

@section('content')
<div class="min-h-screen flex flex-col justify-center sm:px-6 lg:px-8">
    <div class="sm:mx-auto sm:w-full sm:max-w-md">
        <div class="text-center">
            <h2 class="mt-6 text-center text-3xl font-extrabold text-green-900">
                নতুন অ্যাকাউন্ট তৈরি করুন
            </h2>
        </div>

        <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
            <div class="bg-white py-8 px-4 shadow-lg sm:rounded-lg sm:px-10 border border-gray-100">
                <form class="space-y-6" action="{{ route('register') }}" method="POST">
                    @csrf
                    
                    <!-- Name Input -->
                    <div>
                        <label for="name" class="block text-mb font-medium text-green-700">
                            পুরো নাম
                        </label>
                        <div class="mt-1">
                            <input 
                                id="name" 
                                name="name" 
                                type="text" 
                                autocomplete="name" 
                                required 
                                class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-green-500 focus:border-green-500 sm:text-sm"
                                placeholder="আপনার পুরো নাম লিখুন"
                                value="{{ old('name') }}"
                            >
                        </div>
                        @error('name')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Phone Input -->
                    <div>
                        <label for="phone" class="block text-mb font-medium text-green-700">
                            মোবাইল নম্বর
                        </label>
                        <div class="mt-1">
                            <input 
                                id="phone" 
                                name="phone" 
                                type="tel" 
                                autocomplete="tel" 
                                required 
                                class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-green-500 focus:border-green-500 sm:text-sm"
                                placeholder="আপনার মোবাইল নম্বর লিখুন"
                                value="{{ old('phone') }}"
                            >
                        </div>
                        @error('phone')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

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
                                value="{{ old('email') }}"
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
                                autocomplete="new-password" 
                                required 
                                class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-green-500 focus:border-green-500 sm:text-sm"
                                placeholder="পাসওয়ার্ড তৈরি করুন"
                            >
                        </div>
                        @error('password')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Confirm Password Input -->
                    <div>
                        <label for="password_confirmation" class="block text-mb font-medium text-green-700">
                            পাসওয়ার্ড নিশ্চিত করুন
                        </label>
                        <div class="mt-1">
                            <input 
                                id="password_confirmation" 
                                name="password_confirmation" 
                                type="password" 
                                autocomplete="new-password" 
                                required 
                                class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-green-500 focus:border-green-500 sm:text-sm"
                                placeholder="পাসওয়ার্ড আবার লিখুন"
                            >
                        </div>
                    </div>

                    <!-- Terms and Conditions -->
                    <div class="flex items-center">
                        <input 
                            id="terms" 
                            name="terms" 
                            type="checkbox" 
                            required
                            class="h-4 w-4 text-green-600 focus:ring-green-500 border-gray-300 rounded"
                        >
                    </div>

                    <!-- Submit Button -->
                    <div>
                        <button 
                            type="submit" 
                            class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-mb font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition duration-300"
                        >
                            নিবন্ধন করুন
                        </button>
                    </div>
                </form>

                <!-- Login Link -->
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
                        @if (Route::has('login'))
                            <p class="mt-2 text-center text-md text-gray-600">
                                ইতিমধ্যে একাউন্ট আছে? 
                                <a href="{{ route('login') }}" class="font-medium text-green-600 hover:text-green-500">
                                    লগ ইন করুন
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
