@extends('store.layout.layout')
@section('title', 'সদস্য গণের তালিকা' . ' - ' . metaData()->getWebsiteTitle())
@section('content')
    <div class="mx-auto">
        <div class="text-center">
            <h2 class="text-3xl md:text-4xl font-bold text-green-800 mb-8">
                সদস্য কাটাগরি
            </h2>
        </div>
        <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- Foundation Management Members -->
            <div class="bg-gradient-to-br from-green-50 to-green-100 border border-green-100 rounded-xl shadow-md hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="text-xl font-bold text-green-900">পরিচালনা সদস্য</h2>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0" />
                        </svg>
                    </div>
                    <p class="text-sm text-green-700 mb-4">ফাউন্ডেশন, পরিচালনা ও রক্ষণাবেক্ষণ সদস্য</p>
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-2">
                            <i class="fas fa-users text-green-600"></i>
                            <span class="text-green-800 font-semibold">
                                {{ banglaFormatter()->number($totalSoddosho) }} জন
                            </span>
                        </div>
                        <a 
                            href="{{ route('members.category', ['category' => 'soddosho']) }}" 
                            class="px-4 py-2 bg-green-500 text-white rounded-md hover:bg-green-600 transition duration-300 flex items-center space-x-2"
                        >
                            <i class="fas fa-eye"></i>
                            <span>দেখুন</span>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Co-Fighters/Volunteers -->
            <div class="bg-gradient-to-br from-blue-50 to-blue-100 border border-blue-100 rounded-xl shadow-md hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="text-xl font-bold text-blue-900">সহযোদ্ধা</h2>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <p class="text-sm text-blue-700 mb-4">ভলান্টিয়ারের দায়িত্ব পালন করবে</p>
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-2">
                            <i class="fas fa-users text-blue-600"></i>
                            <span class="text-blue-800 font-semibold">
                                {{ banglaFormatter()->number($totalShohojoddha) }} জন
                            </span>
                        </div>
                        <a 
                            href="{{ route('members.category', ['category' => 'shohojoddha']) }}" 
                            class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 transition duration-300 flex items-center space-x-2"
                        >
                            <i class="fas fa-eye"></i>
                            <span>দেখুন</span>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Donor Members -->
            <div class="bg-gradient-to-br from-purple-50 to-purple-100 border border-purple-100 rounded-xl shadow-md hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="text-xl font-bold text-purple-900">দাতা সদস্য</h2>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </div>
                    <p class="text-sm text-purple-700 mb-4">বাৎসরিক অথবা আজীবন মেয়াদে দাতা</p>
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-2">
                            <i class="fas fa-users text-purple-600"></i>
                            <span class="text-purple-800 font-semibold">
                                {{ banglaFormatter()->number($totalDataSoddosho) }} জন
                            </span>
                        </div>
                        <a 
                            href="{{ route('members.category', ['category' => 'data_soddosho']) }}" 
                            class="px-4 py-2 bg-purple-500 text-white rounded-md hover:bg-purple-600 transition duration-300 flex items-center space-x-2"
                        >
                            <i class="fas fa-eye"></i>
                            <span>দেখুন</span>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Well-wishers -->
            <div class="bg-gradient-to-br from-indigo-50 to-indigo-100 border border-indigo-100 rounded-xl shadow-md hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="text-xl font-bold text-indigo-900">শুভাকাঙ্ক্ষী</h2>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <p class="text-sm text-indigo-700 mb-4">প্রবাসী ও সিনিয়র ব্যক্তিবর্গ</p>
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-2">
                            <i class="fas fa-users text-indigo-600"></i>
                            <span class="text-indigo-800 font-semibold">
                                {{ banglaFormatter()->number($totalShuvokankkhi) }} জন
                            </span>
                        </div>
                        <a 
                            href="{{ route('members.category', ['category' => 'shuvokankkhi']) }}" 
                            class="px-4 py-2 bg-indigo-500 text-white rounded-md hover:bg-indigo-600 transition duration-300 flex items-center space-x-2"
                        >
                            <i class="fas fa-eye"></i>
                            <span>দেখুন</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
