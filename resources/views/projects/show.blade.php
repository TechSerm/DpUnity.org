@extends('projects.layout')
@section('title', theme()->title() . ' - ' . theme()->slogan())
@section('tab-content')

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

@stop