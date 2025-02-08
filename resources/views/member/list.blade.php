@extends('store.layout.layout')
@section('title', 'সদস্য গণের তালিকা' . ' - ' . metaData()->getWebsiteTitle())
@section('content')
    <div class="mx-auto">
        <h2 class="text-3xl md:text-4xl text-center font-bold text-green-800 mb-8">
            {{ $category->toBangla() }}দের তালিকা
        </h2>
        <div class="mx-auto">
            <div class="">
                <div class="">
                    <div class="grid grid-cols-1 sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                        @foreach ($members as $member)
                            <div class="bg-white group 
                                transform transition duration-500 hover:-translate-y-2 
                                hover:shadow-2xl rounded-2xl overflow-hidden 
                                border border-gray-100 shadow-md hover:border-blue-200 
                                relative">
                                <div class="relative">
                                    <img src="{{ $member->cover_photo }}" 
                                         alt="Cover" 
                                         class="w-full h-48 object-cover 
                                                transition duration-500 
                                                group-hover:scale-110 
                                                group-hover:brightness-75">
                                    <div class="absolute -bottom-12 left-1/2 transform -translate-x-1/2 
                                                border-4 border-white rounded-full 
                                                shadow-lg transition duration-500 
                                                group-hover:scale-110">
                                        <img src="{{ $member->image->src() }}"
                                             class="w-28 h-28 rounded-full object-cover" 
                                             alt="User">
                                    </div>
                                </div>
                                <div class="pt-16 pb-6 px-6 text-center">
                                    <h5 class="text-2xl font-bold text-gray-800 
                                               mb-2 transition duration-300 
                                               group-hover:text-blue-600">
                                        {{ $member->name }}
                                    </h5>
                                    <div class="space-y-1 mb-4">
                                        <p class="text-sm text-gray-600 
                                                   opacity-80 
                                                   group-hover:opacity-100">
                                            {{ $member->permanent_address }}
                                        </p>
                                        <p class="text-sm text-gray-500 
                                                   opacity-70 
                                                   group-hover:opacity-90">
                                            {{ $member->present_address }}
                                        </p>
                                    </div>
                                    <a href="{{route('members.profile', ['member' => $member->organization_id])}}" 
                                       class="inline-block 
                                              bg-gradient-to-r from-blue-500 to-teal-400 
                                              text-white 
                                              px-6 py-2 
                                              rounded-full 
                                              text-sm 
                                              font-semibold 
                                              transform 
                                              transition 
                                              duration-300 
                                              hover:scale-105 
                                              hover:shadow-lg 
                                              focus:outline-none 
                                              focus:ring-2 
                                              focus:ring-blue-400 
                                              focus:ring-opacity-50">
                                        <i class="fa fa-eye mr-2"></i>বিস্তারিত দেখুন
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
