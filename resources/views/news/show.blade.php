@extends('store.layout.layout')
@section('title', metaData()->getWebsiteTitle() . ' - ' . metaData()->getSlogan())
@section('content')
<div class="w-full">
    <div class="max-w-full mx-auto grid grid-cols-1 lg:grid-cols-8 gap-8">
        <!-- Main News Article (Left Column) -->
        <div class="lg:col-span-6 bg-white rounded-xl shadow-md border border-gray-100 overflow-hidden">
            <!-- Thumbnail -->
            <div class="w-full h-64 md:h-80 lg:h-96 xl:h-[500px] overflow-hidden">
                <img 
                    src="{{ $news->thumbnailUrl }}" 
                    alt="{{ $news->title }}" 
                    class="w-full h-full object-cover transform transition duration-500 hover:scale-110"
                >
            </div>

            <!-- News Header -->
            <header class="p-8">
                <h1 class="text-3xl md:text-4xl font-bold text-green-900 mb-4">
                    {{ $news->title }}
                </h1>

                <!-- Metadata -->
                <div class="flex flex-wrap font-bold items-center text-gray-600 space-x-4 mb-4">
                    <!-- Publication Date -->
                    <div class="flex   items-center mb-2 md:mb-0">
                        <svg class="w-5 h-5 mr-2 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        <span>
                            {{ banglaFormatter()->date($news->published_at->format('d F, Y')) }} 
                            ({{ banglaFormatter()->date($news->published_at->diffForHumans()) }})
                        </span>
                    </div>

                    <!-- Views -->
                    <div class="flex items-center mb-2 md:mb-0">
                        <svg class="w-5 h-5 mr-2 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                        </svg>
                        <span>{{ banglaFormatter()->number($news->views) }} জন দেখেছে</span>
                    </div>
                </div>

                <!-- Featured Badge -->
                @if($news->is_featured)
                    <div class="inline-block bg-green-100 text-green-800 px-3 py-1 rounded-full text-sm mb-4">
                        Featured Article
                    </div>
                @endif
            </header>

            <!-- News Content -->
            <div class="px-8 pb-8 prose prose-green max-w-none text-gray-800 leading-relaxed">
                {!! $news->content !!}
            </div>

            <!-- Navigation -->
            <div class="border-t border-green-100 pt-6 px-8 pb-8">
                <a href="{{ route('news.index') }}" class="text-green-700 hover:text-green-900 transition flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16l-4-4m0 0l4-4m-4 4h18"></path>
                    </svg>
                    সকল সংবাদ
                </a>
            </div>
        </div>

        <!-- Recent News (Right Column) -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-xl border border-gray-50 shadow-md p-6">
                <h2 class="text-2xl font-bold text-gray-900 mb-6">সামঞ্জস্য সংবাদ সমূহ</h2>
                <div class="space-y-6">
                    @foreach($recentNews as $recent)
                        <a href="{{ route('news.show', $recent->slug) }}" class="block group">
                            <div class="flex items-center space-x-4">
                                <!-- Thumbnail -->
                                <div class="flex-shrink-0 w-20 h-20 overflow-hidden rounded-lg">
                                    <img 
                                        src="{{ $recent->thumbnailUrl }}" 
                                        alt="{{ $recent->title }}" 
                                        class="w-full h-full object-cover transform transition duration-500 group-hover:scale-110"
                                    >
                                </div>
                                <!-- Title and Date -->
                                <div>
                                    <h3 class="text-lg font-semibold text-green-900 group-hover:text-green-700 transition">
                                        {{ $recent->title }}
                                    </h3>
                                    <p class="text-sm text-gray-500">
                                        {{ banglaFormatter()->date($recent->published_at->format('d F, Y')) }}
                                    </p>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection