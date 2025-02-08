@extends('store.layout.layout')
@section('title', $member->name . ' - ' . metaData()->getWebsiteTitle())
@section('content')
    <div class="mx-auto">
        <div class="max-w-4xl mx-auto">
            <div class="relative">
                {{-- Cover Photo --}}
                <div class="h-[220px] bg-cover bg-center rounded-t-2xl shadow-lg transition-all duration-500 ease-in-out hover:shadow-xl relative overflow-hidden" 
                     style="background-image: url('{{ $member->cover_photo }}')">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent"></div>
                </div>

                {{-- Profile Section --}}
                <div class="bg-white shadow-2xl rounded-2xl -mt-16 relative z-10 p-8 transition-all duration-500 ease-in-out hover:shadow-3xl">
                    <div class="flex flex-col items-center">
                        {{-- Profile Image --}}
                        <div class="relative">
                            <img src="{{ $member->image->src() }}" 
                                 alt="{{ $member->name }}" 
                                 class="w-32 h-32 rounded-full border-4 border-white shadow-lg object-cover -mt-20 transition-all duration-500 ease-in-out hover:scale-105">
                        </div>

                        {{-- Member Info --}}
                        <div class="text-center mt-4">
                            <h2 class="text-3xl font-bold text-gray-800">{{ $member->name }}</h2>
                            <p class="text-sm text-gray-600 mt-1">{{ $member->permanent_address }}</p>
                            <p class="text-sm text-gray-500">{{ $member->present_address }}</p>
                        </div>
                    </div>

                    {{-- Member Details --}}
                    <div class="mt-8">
                        <h3 class="text-2xl font-semibold text-gray-800 border-b pb-2 mb-6">সদস্যের পরিচিতি</h3>
                        
                        <div class="grid md:grid-cols-2 gap-6">
                            {{-- Left Column --}}
                            <div class="bg-gradient-to-br from-gray-50 to-gray-100 border border-gray-100 rounded-xl p-6 transition-all duration-500 ease-in-out hover:shadow-lg">
                                <table class="w-full">
                                    <tr class="border-b">
                                        <td class="py-3 text-gray-600 font-medium w-1/3">আইডি</td>
                                        <td class="py-3 font-bold text-gray-800">{{ banglaFormatter()->number($member->organization_id) }}</td>
                                    </tr>
                                    <tr class="border-b">
                                        <td class="py-3 text-gray-600 font-medium">ক্যাটেগরি</td>
                                        <td class="py-3 text-gray-800">{{ $member->category->toBangla() }}</td>
                                    </tr>
                                    <tr class="border-b">
                                        <td class="py-3 text-gray-600 font-medium">পিতার নাম</td>
                                        <td class="py-3 text-gray-800">{{ $member->father_name }}</td>
                                    </tr>
                                    <tr class="border-b">
                                        <td class="py-3 text-gray-600 font-medium">জাতীয়তা</td>
                                        <td class="py-3 text-gray-800">{{ $member->nationality }}</td>
                                    </tr>
                                    <tr>
                                        <td class="py-3 text-gray-600 font-medium">যোগদানের তারিখ</td>
                                        <td class="py-3 text-gray-800">
                                            {{ banglaFormatter()->date($member->created_at->format('d M Y, h:i a')) }} 
                                            ({{ banglaFormatter()->date($member->created_at->diffForHumans()) }})
                                        </td>
                                    </tr>
                                </table>
                            </div>

                            {{-- Right Column --}}
                            <div class="bg-gradient-to-br text-left from-gray-50 to-gray-100 border border-gray-200 rounded-xl p-6 transition-all duration-500 ease-in-out hover:shadow-lg">
                                <table class="w-full">
                                    <tr class="border-b">
                                        <td class="py-3 text-gray-600 font-medium w-1/3">ধর্ম</td>
                                        <td class="py-3 text-gray-800">{{ $member->religion }}</td>
                                    </tr>
                                    <tr class="border-b">
                                        <td class="py-3 text-gray-600 font-medium">বর্তমান ঠিকানা</td>
                                        <td class="py-3 text-gray-800">{{ $member->present_address }}</td>
                                    </tr>
                                    <tr class="border-b">
                                        <td class="py-3 text-gray-600 font-medium">স্থায়ী ঠিকানা</td>
                                        <td class="py-3 text-gray-800">{{ $member->permanent_address }}</td>
                                    </tr>
                                    <tr class="border-b">
                                        <td class="py-3 text-gray-600 font-medium">পেশা</td>
                                        <td class="py-3 text-gray-800">{{ $member->occupation }}</td>
                                    </tr>
                                    <tr>
                                        <td class="py-3 text-gray-600 font-medium">রক্তের গ্রুপ</td>
                                        <td class="py-3 text-gray-800">{{ $member->blood_group }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop