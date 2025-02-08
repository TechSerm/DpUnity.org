@extends('store.layout.layout')
@section('title', 'আমাদের সম্পর্কে - ' . metaData()->getWebsiteTitle())
@section('content')
    @php
        $aboutUsData = metaData()->getAboutUs();
        $activeTab = isset($aboutUsData[0]) ? $aboutUsData[0]['title'] : '';
    @endphp
    <div class="mx-auto">
        <div class="text-center">
            <h2 class="text-3xl md:text-4xl font-bold text-green-800 mb-8">
                আমাদের সম্পর্কে
            </h2>
        </div>
        <div class="bg-white shadow-md border border-gray-100 rounded-lg overflow-hidden">
            {{-- Tabs Navigation --}}
            <div class="lg:flex" x-data="{ activeTab: '{{ $activeTab }}' }">
                {{-- Vertical Tabs for Desktop --}}
                <div class="hidden lg:block lg:w-1/6 lg:border-r lg:border-gray-200">
                    <nav class="lg:flex lg:flex-col">

                        @foreach ($aboutUsData as $value)
                            <a href="#" @click.prevent="activeTab = '{{ $value['title'] }}'"
                                :class="{ 'bg-indigo-50 text-indigo-700': activeTab === '{{ $value['title'] }}', 'text-gray-600 hover:bg-gray-50': activeTab !== '{{ $value['title'] }}' }"
                                class="block py-3 px-4 text-sm font-medium">
                                {{ $value['title'] }}
                            </a>
                        @endforeach
                    </nav>
                </div>

                <div class="block lg:hidden border-b border-gray-200 overflow-x-auto">
                    <nav class="-mb-px flex whitespace-nowrap">
                        {{-- Mobile Tabs --}}
                        @foreach ($aboutUsData as $value)
                            <a href="#" @click.prevent="activeTab = '{{ $value['title'] }}'"
                                :class="{ 'border-indigo-500 text-indigo-600': activeTab === '{{ $value['title'] }}', 'border-transparent text-gray-500': activeTab !== '{{ $value['title'] }}' }"
                                class="flex-shrink-0 w-1/4 min-w-[100px] py-4 text-center border-b-2 font-medium text-sm">
                                {{ $value['title'] }}
                            </a>
                        @endforeach
                    </nav>
                </div>

                <div class="lg:w-3/4 p-6">
                    @foreach ($aboutUsData as $value)
                        <div x-show="activeTab === '{{ $value['title'] }}'" class="space-y-4">
                            {!! $value['content'] !!}
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection
