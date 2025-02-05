@extends('store.layout.layout')
@section('title', theme()->title() . ' - ' . theme()->slogan())
@section('content')

<div class="mb-14">
    <div class="mx-auto">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 items-center">
            <!-- Left Column: Text Content -->
            <div class="w-full text-center lg:text-left">
                <div class="max-w-4xl mx-auto lg:max-w-none">
                    <h1 class="text-3xl sm:text-4xl md:text-5xl font-extrabold text-green-900 leading-tight mb-3">
                        দৌলতপুর প্রবাসী ফাউন্ডেশন
                    </h1>
                    <h3 class="text-lg sm:text-xl md:text-2xl font-semibold text-green-600 mb-6">
                        একটি অরাজনৈতিক, অলাভজনক দাতব্য ফাউন্ডেশন
                    </h3>
                    <p class="text-md sm:text-base md:text-lg text-green-800 leading-relaxed mb-8 max-w-3xl mx-auto lg:mx-0">
                        প্রিয় দৌলতপুর এলাকাবাসী, আমরা দৌলতপুর গ্রামের প্রবাসীরা মিলে গঠন করেছি "দৌলতপুর প্রবাসী ফাউন্ডেশন"। 
                        আমরা এলাকার গরিব, অসহায়, দুস্ত মানুষের পাশাপাশি সামাজিক কাজে নিয়জিত থাকব। এটি একটি অরাজনৈতিক,
                        অলাভজনক দাতব্য ফাউন্ডেশন।
                    </p>
                    <div class="flex flex-wrap justify-center lg:justify-start gap-4 mt-6 mb-6">
                        <a href="{{ route('about_us') }}" 
                           class="bg-green-600 text-white px-6 py-3 rounded-full font-semibold shadow-md hover:bg-green-700 transition duration-300">
                            আমাদের সম্পর্কে জানুন
                        </a>
                    </div>
                </div>
            </div>
            

            <!-- Right Column: Grid of Images -->
            <div class="w-full text-center items-center justify-center">
                <div x-data="imageSlider()" class="relative w-full overflow-hidden">
                    <div class="flex transition-transform duration-500" :style="`transform: translateX(-${currentSlide * 100}%)`">
                        @for($i = 0; $i < 10; $i++)
                            
                            <img src="https://flowbite.com/marketing-ui/demo/images/carousel/ngo-carousel-image-1.jpg" class="w-full rounded-lg shadow-lg" alt="">
                            
                        @endfor
                    </div>
                
                    {{-- Navigation Buttons --}}
                    <div class="absolute inset-y-0 left-0 flex items-center">
                        <button 
                            @click="prevSlide()" 
                            class="bg-green-600/50 text-white p-2 rounded-full ml-2 hover:bg-green-700/75 transition"
                        >
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7M5 5l7 7-7 7"></path>
                            </svg>
                        </button>
                    </div>
                    <div class="absolute inset-y-0 right-0 flex items-center">
                        <button 
                            @click="nextSlide()" 
                            class="bg-green-600/50 text-white p-2 rounded-full mr-2 hover:bg-green-700/75 transition"
                        >
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </button>
                    </div>
                
                    {{-- Dots Indicator --}}
                    <div class="absolute bottom-4 left-1/2 transform -translate-x-1/2 flex space-x-2">
                        @for($i = 0; $i < 4; $i++)
                        <button 
                            @click="currentSlide = {{ $i }}"
                            :class="{'bg-green-600': currentSlide === {{ $i }}, 'bg-green-300': currentSlide !== {{ $i }}}"
                            class="w-3 h-3 rounded-full transition-colors duration-300"
                        ></button>
                        @endfor
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Info --}}
@php
    $cardInfo = [
        ["title" => "শিক্ষা সহায়তা", "icon" => "education.svg", "color" => "text-blue-500", "style" => "filter: invert(20%) sepia(80%) saturate(300%) hue-rotate(200deg);"],
        ["title" => "স্বাবলম্বী প্রক্রিয়া", "icon" => "health.svg", "color" => "text-red-500", "style" => "filter: invert(30%) sepia(70%) saturate(200%) hue-rotate(0deg);"],
        ["title" => "স্বাস্থ্য সহায়তা", "icon" => "sabolombi.svg", "color" => "text-green-500", "style" => "filter: invert(40%) sepia(90%) saturate(400%) hue-rotate(100deg);"],
        ["title" => "বৃক্ষ রোপণ ও সামাজিক উন্নয়ন", "icon" => "tree_plantation.svg", "color" => "text-yellow-500", "style" => "filter: invert(50%) sepia(60%) saturate(300%) hue-rotate(50deg);"],
    ];
@endphp

<div class="max-w-4xl mx-auto text-center mb-14">
    <h2 class="text-3xl md:text-4xl font-bold text-green-800 mb-3">
        আমাদের লক্ষ্য
    </h2>
    <p class="text-lg text-green-600 mb-8">
        যে লক্ষ্যগুলো নিয়ে আমরা একতাবদ্ধ ভাবে কাজ করি
    </p>

    <div class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-4 gap-2 md:gap-3">
        @foreach ($cardInfo as $card)
        <div class="group relative text-center border border-gray-200 bg-white shadow-md rounded-2xl p-4 transition-transform duration-300 hover:scale-105 hover:shadow-xl">
            <div class="mb-6">
                {{-- Dynamic Icon Styling --}}
                <img 
                    src="{{ asset('assets/img/' . $card['icon']) }}" 
                    class="mx-auto {{ $card['color'] }} group-hover:brightness-125 transition-all duration-300" 
                    style="{{ $card['style'] }}" 
                    alt="{{ $card['title'] }}"
                >
            </div>
            <span class="block text-xl font-semibold text-green-900 group-hover:text-green-600 transition-all duration-300">
                {{ $card['title'] }}
            </span>
        </div>
        @endforeach
    </div>
</div>


    @include("news.home_news_list")

    

@stop



<style>


/* Position text in the middle of the page/image */

</style>

@push('scripts')
<script>
    function imageSlider() {
        return {
            currentSlide: 0,
            totalSlides: 4,
            nextSlide() {
                this.currentSlide = (this.currentSlide + 1) % this.totalSlides;
            },
            prevSlide() {
                this.currentSlide = (this.currentSlide - 1 + this.totalSlides) % this.totalSlides;
            }
        }
    }
</script>
@endpush