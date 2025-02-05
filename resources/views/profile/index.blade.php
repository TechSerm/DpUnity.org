@extends('store.layout.layout')

@section('content')
<div class=" mx-auto">
    <div class="grid md:grid-cols-8 gap-8">
        <!-- Profile Sidebar -->
        <div class="md:col-span-2">
            <div class="bg-white shadow-lg border border-gray-100 rounded-xl p-6 sticky top-24">
                <div class="text-center">
                    <img 
                        src="{{ auth()->user()->image }}" 
                        alt="{{ auth()->user()->name }}" 
                        class="w-32 h-32 rounded-full mx-auto mb-4 object-cover border-4 border-green-200 transition-transform transform hover:scale-105"
                    >
                    <h2 class="text-2xl font-bold text-green-900 mb-2 transition-colors duration-300 hover:text-green-700">
                        {{ auth()->user()->name }}
                    </h2>
                    <p class="text-green-600 mb-4 text-sm md:text-base">
                        {{ auth()->user()->email }}
                    </p>

                    <div class="space-y-3">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button 
                                type="submit" 
                                class="w-full px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition duration-300 transform hover:scale-105"
                            >
                                লগ আউট
                            </button>
                        </form>

                        @if (auth()->user()->isAdmin())
                            <a 
                                href="/admin" 
                                class="w-full block text-center px-4 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600 transition duration-300 transform hover:scale-105"
                            >
                                <i class="fas fa-tachometer-alt mr-2"></i> 
                                অ্যাডমিন প্যানেল
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Profile Content -->
        <div class="md:col-span-6 space-y-6">
            <!-- Financial Summary -->
            <div class="bg-white shadow-md border border-gray-100  rounded-xl p-6">
                <div class="bg-green-50 rounded-lg p-6 text-center">
                    <h3 class="text-xl text-green-900 mb-2 font-semibold">
                        আপনার মোট জমা
                    </h3>
                    <h1 class="text-3xl font-bold text-green-700">
                        {{ banglaFormatter()->number($transactions->sum('amount')) }} টাকা
                    </h1>
                </div>
            </div>

            <!-- Recent Transactions -->
            <div class="bg-white shadow-md border border-gray-100 rounded-xl p-6">
                <h2 class="text-2xl font-semibold text-green-900 mb-6">
                    সাম্প্রতিক জমা
                </h2>

                @if($transactions->count() > 0)
                    <div class="space-y-4">
                        @foreach($transactions as $transaction)
                            <div class="bg-gray-50 rounded-lg p-4 flex justify-between items-center hover:bg-gray-100 transition duration-300">
                                <div>
                                    <h4 class="font-semibold text-green-800">
                                        {{ $transaction->description }}
                                    </h4>
                                    <p class="text-sm text-gray-600">
                                        {{ banglaFormatter()->date($transaction->created_at) }}
                                    </p>
                                </div>
                                <span class="text-lg font-bold {{ $transaction->type == 'credit' ? 'text-green-600' : 'text-red-600' }}">
                                    {{ banglaFormatter()->number($transaction->amount) }} টাকা
                                </span>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center text-gray-500 py-8">
                        কোনো লেনদেন পাওয়া যায়নি
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
