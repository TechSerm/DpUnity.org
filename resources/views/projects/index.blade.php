@extends('store.layout.layout')
@section('title', metaData()->getWebsiteTitle() . ' - ' . metaData()->getSlogan())
@section('content')

    <div class="text-center mb-12">
        <h1 class="text-4xl font-extrabold text-green-900 mb-4">
            প্রকল্পের তালিকা
        </h1>
        <p class="text-xl text-green-700 max-w-2xl mx-auto">
            আমাদের সামাজিক উন্নয়ন এবং মানবিক সেবার প্রকল্পগুলো
        </p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
        @forelse($projects as $project)
            <div class="bg-white rounded-xl border border-gray-200 shadow-lg overflow-hidden transition-all duration-300 hover:shadow-xl group">
                <div class="p-6">
                    <div class="flex justify-between items-start mb-4">
                        <h3 class="text-2xl font-bold text-green-800 group-hover:text-green-900 transition">
                            {{ $project->title }}
                        </h3>

                        @php
                            $status = now()->between($project->start_date, $project->end_date)
                                ? 'চলমান'
                                : (now() > $project->end_date
                                    ? 'সমাপ্ত'
                                    : 'আসন্ন');

                            $statusColors = [
                                'চলমান' => 'bg-green-500 text-white',
                                'সমাপ্ত' => 'bg-red-500 text-white',
                                'আসন্ন' => 'bg-blue-500 text-white',
                            ];
                        @endphp

                        <span class="px-3 py-1 rounded-full text-sm font-semibold {{ $statusColors[$status] }}">
                            {{ $status }}
                        </span>
                    </div>

                    <div class="grid grid-cols-2 gap-4 mb-6">
                        <div class="bg-green-50 p-4 rounded-lg text-center">
                            <span class="block text-sm text-green-600 mb-1">শুরু</span>
                            <span class="font-bold text-green-800">
                                {{ $project->start_date->format('d M Y') }}
                            </span>
                        </div>
                        <div class="bg-red-50 p-4 rounded-lg text-center">
                            <span class="block text-sm text-red-600 mb-1">শেষ</span>
                            <span class="font-bold text-red-800">
                                {{ $project->end_date->format('d M Y') }}
                            </span>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4 mb-6">
                        <div class="bg-blue-50 p-4 rounded-lg text-center">
                            <span class="block text-sm text-blue-600 mb-1">মোট জমা</span>
                            <span class="font-bold text-blue-800">
                                ৳ {{ number_format($project->donations->sum('amount'), 2) }}
                            </span>
                        </div>
                        <div class="bg-purple-50 p-4 rounded-lg text-center">
                            <span class="block text-sm text-purple-600 mb-1">মোট ব্যয়</span>
                            <span class="font-bold text-purple-800">
                                ৳ {{ number_format($project->expenses->sum('amount'), 2) }}
                            </span>
                        </div>
                    </div>

                    <div class="flex space-x-4">
                        <a href="{{ route('projects.show', $project) }}"
                            class="flex-grow bg-green-600 text-white px-6 py-3 rounded-full text-center font-semibold hover:bg-green-700 transition">
                            বিস্তারিত
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full text-center py-12">
                <p class="text-2xl text-gray-500">কোনো প্রকল্প পাওয়া যায়নি</p>
            </div>
        @endforelse
    </div>

    <div class="mt-12 flex justify-center">
        {{ $projects->links('vendor.pagination.tailwind') }}
    </div>


    @push('styles')
        <style>
            .line-clamp-3 {
                display: -webkit-box;
                -webkit-line-clamp: 3;
                -webkit-box-orient: vertical;
                overflow: hidden;
            }
        </style>
    @endpush

@stop
