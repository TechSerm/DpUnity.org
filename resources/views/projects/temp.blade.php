@extends('store.layout.layout')
@section('title', theme()->title() . ' - ' . theme()->slogan())
@section('content')

<div 
    x-data="{ activeTab: 'overview' }" 
    x-init="$watch('activeTab', value => console.log(value))"
    class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12"
>
    {{-- Breadcrumb --}}
    <nav class="flex mb-8" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-3">
            <li class="inline-flex items-center">
                <a href="{{ route('projects.index') }}" class="inline-flex items-center text-sm text-green-700 hover:text-green-900">
                    <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path>
                    </svg>
                    প্রকল্প সমূহ
                </a>
            </li>
            <li>
                <div class="flex items-center">
                    <svg class="w-6 h-6 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                    </svg>
                    <span class="ml-1 text-sm font-medium text-green-500">{{ $project->title }}</span>
                </div>
            </li>
        </ol>
    </nav>

    {{-- Project Header --}}
    <div class="bg-white rounded-xl shadow-lg p-6 mb-8">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 space-y-4 md:space-y-0">
            <div>
                <h1 class="text-3xl font-bold text-green-900 mb-2">{{ $project->title }}</h1>
                
                @php
                    $status = now()->between($project->start_date, $project->end_date) 
                        ? 'চলমান' 
                        : (now() > $project->end_date ? 'সমাপ্ত' : 'আসন্ন');
                    
                    $statusColors = [
                        'চলমান' => 'bg-green-500 text-white',
                        'সমাপ্ত' => 'bg-red-500 text-white',
                        'আসন্ন' => 'bg-blue-500 text-white'
                    ];
                @endphp
                
                <span class="px-3 py-1 rounded-full text-sm font-semibold {{ $statusColors[$status] }}">
                    {{ $status }}
                </span>
            </div>
            
            <div class="flex space-x-2">
                <a href="{{ route('projects.donations', $project) }}" 
                   class="bg-green-50 text-green-600 px-4 py-2 rounded-full hover:bg-green-100 transition">
                    জমা
                </a>
                <a href="{{ route('projects.expenses', $project) }}" 
                   class="bg-red-50 text-red-600 px-4 py-2 rounded-full hover:bg-red-100 transition">
                    ব্যয়
                </a>
            </div>
        </div>

        {{-- Tabs Navigation --}}
        <div class="border-b border-gray-200 mb-6">
            <nav class="-mb-px flex space-x-8">
                <button 
                    @click="activeTab = 'overview'"
                    :class="activeTab === 'overview' ? 'border-green-500 text-green-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                    class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm"
                >
                    প্রকল্পের বিবরণ
                </button>
                <button 
                    @click="activeTab = 'donations'"
                    :class="activeTab === 'donations' ? 'border-green-500 text-green-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                    class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm"
                >
                    জমা
                </button>
                <button 
                    @click="activeTab = 'expenses'"
                    :class="activeTab === 'expenses' ? 'border-green-500 text-green-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                    class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm"
                >
                    ব্যয়
                </button>
                <button 
                    @click="activeTab = 'reports'"
                    :class="activeTab === 'reports' ? 'border-green-500 text-green-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                    class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm"
                >
                    রিপোর্ট
                </button>
            </nav>
        </div>

        {{-- Tab Content --}}
        <template x-if="activeTab === 'overview'">
            <div class="grid md:grid-cols-2 gap-6">
                <div>
                    <h3 class="text-xl font-semibold text-green-800 mb-4">প্রকল্পের বিবরণ</h3>
                    <div class="prose text-gray-700 max-w-none">
                        {!! $project->description !!}
                    </div>
                </div>
                
                <div>
                    <div class="grid grid-cols-2 gap-4 mb-6">
                        <div class="bg-green-50 p-4 rounded-lg text-center">
                            <span class="block text-sm text-green-600 mb-1">শুরুর তারিখ</span>
                            <span class="font-bold text-green-800">
                                {{ $project->start_date->format('d M Y') }}
                            </span>
                        </div>
                        <div class="bg-red-50 p-4 rounded-lg text-center">
                            <span class="block text-sm text-red-600 mb-1">শেষ তারিখ</span>
                            <span class="font-bold text-red-800">
                                {{ $project->end_date->format('d M Y') }}
                            </span>
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-2 gap-4">
                        <div class="bg-blue-50 p-4 rounded-lg text-center">
                            <span class="block text-sm text-blue-600 mb-1">মোট দিন</span>
                            <span class="font-bold text-blue-800">
                                {{ $project->start_date->diffInDays($project->end_date) }} দিন
                            </span>
                        </div>
                        <div class="bg-purple-50 p-4 rounded-lg text-center">
                            <span class="block text-sm text-purple-600 mb-1">অবশিষ্ট দিন</span>
                            <span class="font-bold text-purple-800">
                                @if(now() < $project->end_date)
                                    {{ now()->diffInDays($project->end_date) }} দিন
                                @else
                                    সমাপ্ত
                                @endif
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </template>

        {{-- Donations Tab --}}
        <template x-if="activeTab === 'donations'">
            <div class="space-y-4">
                <h3 class="text-xl font-semibold text-green-800 mb-4">সাম্প্রতিক জমা</h3>
                <div class="grid md:grid-cols-2 gap-4">
                    <div class="bg-green-50 p-4 rounded-lg text-center">
                        <span class="block text-sm text-green-600 mb-1">মোট জমা</span>
                        <span class="font-bold text-green-800 text-xl">
                            ৳ {{ number_format($project->donations->sum('amount'), 2) }}
                        </span>
                    </div>
                    <div class="bg-blue-50 p-4 rounded-lg text-center">
                        <span class="block text-sm text-blue-600 mb-1">মোট দাতা</span>
                        <span class="font-bold text-blue-800 text-xl">
                            {{ $project->donations->count() }}
                        </span>
                    </div>
                </div>
                
                <div class="space-y-4">
                    @forelse($project->donations()->latest()->take(10)->get() as $donation)
                        <div class="flex justify-between items-center bg-white p-3 rounded-lg shadow-sm">
                            <div>
                                <span class="font-semibold text-green-900">
                                    {{ $donation->donor_name ?? 'Anonymous' }}
                                </span>
                                <small class="block text-green-600">
                                    {{ $donation->created_at->diffForHumans() }}
                                </small>
                            </div>
                            <span class="text-green-700 font-bold">
                                ৳ {{ number_format($donation->amount, 2) }}
                            </span>
                        </div>
                    @empty
                        <p class="text-center text-gray-500">কোন জমা নেই</p>
                    @endforelse
                </div>
            </div>
        </template>

        {{-- Expenses Tab --}}
        <template x-if="activeTab === 'expenses'">
            <div class="space-y-4">
                <h3 class="text-xl font-semibold text-red-800 mb-4">সাম্প্রতিক ব্যয়</h3>
                <div class="grid md:grid-cols-2 gap-4">
                    <div class="bg-red-50 p-4 rounded-lg text-center">
                        <span class="block text-sm text-red-600 mb-1">মোট ব্যয়</span>
                        <span class="font-bold text-red-800 text-xl">
                            ৳ {{ number_format($project->expenses->sum('amount'), 2) }}
                        </span>
                    </div>
                    <div class="bg-purple-50 p-4 rounded-lg text-center">
                        <span class="block text-sm text-purple-600 mb-1">ব্যয় ক্যাটাগরি</span>
                        <span class="font-bold text-purple-800 text-xl">
                            {{ $project->expenses->groupBy('category_id')->count() }}
                        </span>
                    </div>
                </div>
                
                <div class="space-y-4">
                    @forelse($project->expenses()->latest()->take(10)->get() as $expense)
                        <div class="flex justify-between items-center bg-white p-3 rounded-lg shadow-sm">
                            <div>
                                <span class="font-semibold text-red-900">
                                    {{ $expense->category->name }}
                                </span>
                                <small class="block text-red-600">
                                    {{ $expense->created_at->diffForHumans() }}
                                </small>
                            </div>
                            <span class="text-red-700 font-bold">
                                ৳ {{ number_format($expense->amount, 2) }}
                            </span>
                        </div>
                    @empty
                        <p class="text-center text-gray-500">কোন ব্যয় নেই</p>
                    @endforelse
                </div>
            </div>
        </template>

        {{-- Reports Tab --}}
        <template x-if="activeTab === 'reports'">
            <div class="space-y-4">
                <h3 class="text-xl font-semibold text-blue-800 mb-4">ব্যয় বিভাজন</h3>
                <div class="h-96">
                    <canvas id="expenseCategoryChart"></canvas>
                </div>
            </div>
        </template>
    </div>
</div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        @php
        $expenseCategories = $project->expenses()
            ->with('category')
            ->get()
            ->groupBy('category.name')
            ->map(function($expenses) {
                return $expenses->sum('amount');
            });
        @endphp

        const ctx = document.getElementById('expenseCategoryChart').getContext('2d');
        new Chart(ctx, {
            type: 'pie',
            data: {
                labels: @json($expenseCategories->keys()),
                datasets: [{
                    data: @json($expenseCategories->values()),
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.7)',
                        'rgba(54, 162, 235, 0.7)',
                        'rgba(255, 206, 86, 0.7)',
                        'rgba(75, 192, 192, 0.7)',
                        'rgba(153, 102, 255, 0.7)',
                    ]
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                    },
                    title: {
                        display: false
                    }
                }
            }
        });
    });
</script>
@endpush