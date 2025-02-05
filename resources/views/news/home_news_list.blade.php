<!-- Vlog Section -->
<div class="">
    <div class="mx-auto">
        <div class="text-center mb-8">
            <h2 class="text-3xl sm:text-4xl font-bold text-green-800 mb-3">
                সাম্প্রতিক সংবাদ
            </h2>
            <p class="text-lg text-green-600 max-w-2xl mx-auto">
                আমাদের সংগঠনের সর্বশেষ খবরসমূহ
            </p>
        </div>

        @if ($news->count() > 0)
            <div class="grid lg:grid-cols-4 md:grid-cols-2 grid-cols-1 gap-6">
                @foreach ($news as $newsItem)
                    <!-- Blog Post Card -->
                    <div class="bg-white rounded-xl border border-gray-100 shadow-md overflow-hidden">
                        <!-- Thumbnail (Top Section) -->
                        <img src="{{ $newsItem->thumbnailUrl }}" alt="{{ $newsItem->title }}"
                            class="w-full h-[240px] object-cover rounded-t-xl border-b border-gray-200">


                        <!-- Content (Bottom Section) -->
                        <div class="p-6">
                            <!-- Date -->
                            <div class="flex items-center text-sm text-gray-600 mb-3">
                                <svg class="w-4 h-4 mr-2 text-green-500" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                    </path>
                                </svg>
                                {{ $newsItem->published_at ? banglaFormatter()->date($newsItem->published_at->format('d F, Y')) . ' ('. banglaFormatter()->date($newsItem->published_at->diffForHumans()) .')' : 'N/A' }}
                            </div>

                            <!-- Title -->
                            <h3 class="text-xl font-bold text-green-900 mb-3 hover:text-green-700 transition">
                                {{ $newsItem->title }}
                            </h3>

                            <!-- Description -->
                            <p class="text-base text-gray-700 mb-4 line-clamp-3">
                                {!! Str::limit(strip_tags($newsItem->content), 150) !!}
                            </p>

                            <!-- Read More Link -->
                            <a href="{{ route('news.show', $newsItem->slug) }}"
                                class="inline-flex items-center text-green-600 hover:text-green-800 font-semibold transition">
                                আরো দেখুন
                                <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                                </svg>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- View All News Button -->
            <div class="text-center mt-12">
                @if ($news->count() == 8)
                <a href="{{ route('news.index') }}"
                    class="px-8 py-3 bg-green-600 text-white rounded-full hover:bg-green-700 transition duration-300 inline-flex items-center space-x-2">
                    <span>সকল সংবাদ দেখুন</span>
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 5l7 7-7 7M5 5l7 7-7 7"></path>
                    </svg>
                </a>
                @endif
            </div>
        @else
            <div class="text-center text-gray-600">
                <p>কোনো সংবাদ পাওয়া যায়নি।</p>
            </div>
        @endif
    </div>
</div>
