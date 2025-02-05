@extends('projects.layout')

@section('title', $project->title . ' - Donations')

@section('tab-content')

    <div class="space-y-6">
        {{-- Donations Summary Cards --}}
        <div class="grid md:grid-cols-3 gap-4">
            <div class="bg-green-50 p-6 rounded-xl shadow-sm text-center">
                <div class="flex items-center justify-center space-x-3 mb-2">
                    <svg class="w-8 h-8 text-green-600" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1.41 16.09v.58c0 .58-.47 1.05-1.05 1.05h-.8c-.58 0-1.05-.47-1.05-1.05v-.6c-1.33-.28-2.51-1.17-2.66-2.64-.05-.55.4-1.05.96-1.05h.89c.44 0 .8.33.87.76.1.6.7 1.05 1.4 1.05h1.68c.88 0 1.6-.72 1.6-1.6 0-.84-.54-1.6-1.36-1.77l-2.6-.65c-1.74-.44-3.01-2.05-3.01-3.89 0-2.23 1.79-4.04 4-4.33V5.36c0-.58.47-1.05 1.05-1.05h.8c.58 0 1.05.47 1.05 1.05v.58c1.33.28 2.38 1.33 2.53 2.64.05.55-.4 1.05-.96 1.05h-.89c-.44 0-.8-.33-.87-.76-.1-.6-.7-1.05-1.4-1.05h-1.68c-.88 0-1.6.72-1.6 1.6 0 .84.54 1.6 1.36 1.77l2.6.65c1.74.44 3.01 2.05 3.01 3.89 0 2.23-1.79 4.04-4 4.33z"/>
                    </svg>
                    <h3 class="text-lg font-semibold text-green-800">মোট জমা</h3>
                </div>
                <p class="text-3xl font-bold text-green-900">
                    ৳ {{ $project->donations->sum('amount') }}
                </p>
            </div>
            <div class="bg-blue-50 p-6 rounded-xl shadow-sm text-center">
                <div class="flex items-center justify-center space-x-3 mb-2">
                    <svg class="w-8 h-8 text-blue-600" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M16 11c1.66 0 2.99-1.34 2.99-3S17.66 5 16 5c-1.66 0-3 1.34-3 3s1.34 3 3 3zm-8 0c1.66 0 2.99-1.34 2.99-3S9.66 5 8 5C6.34 5 5 6.34 5 8s1.34 3 3 3zm0 2c-2.33 0-7 1.17-7 3.5V19h14v-2.5c0-2.33-4.67-3.5-7-3.5zm8 0c-.29 0-.62.02-.97.05 1.16.84 1.97 1.97 1.97 3.45V19h6v-2.5c0-2.33-4.67-3.5-7-3.5z"/>
                    </svg>
                    <h3 class="text-lg font-semibold text-blue-800">মোট দাতা</h3>
                </div>
                <p class="text-3xl font-bold text-blue-900">
                    {{ $project->donations->count() }}
                </p>
            </div>
            <div class="bg-purple-50 p-6 rounded-xl shadow-sm text-center">
                <div class="flex items-center justify-center space-x-3 mb-2">
                    <svg class="w-8 h-8 text-purple-600" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M11 15h2v-2h-2v2zm0-8h2V5h-2v2zm0 4h2v-2h-2v2zm8-5V3c0-.55-.45-1-1-1H4c-.55 0-1 .45-1 1v8c0 .55.45 1 1 1h14c.55 0 1-.45 1-1V6zm-2 5H5V4h12v4zm3-6h-2v8H3V5H1v10h22V6h-2z"/>
                    </svg>
                    <h3 class="text-lg font-semibold text-purple-800">গড় দান</h3>
                </div>
                <p class="text-3xl font-bold text-purple-900">
                    ৳ {{ number_format($project->donations->avg('amount'), 2) }}
                </p>
            </div>
        </div>

        {{-- Category-wise Donation Summary --}}
        @php
        use App\Enums\CategoryEnum;

        // Define category-specific colors and icons
        $categoryStyles = [
            CategoryEnum::SODDOSHO => [
                'bg' => 'bg-blue-50',
                'text' => 'text-blue-600',
                'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a8 8 0 00-8 8h16a8 8 0 00-8-8z" />',
            ],
            CategoryEnum::DATA_SODDOSHO => [
                'bg' => 'bg-green-50',
                'text' => 'text-green-600',
                'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />',
            ],
            CategoryEnum::SHOHOJODDHA => [
                'bg' => 'bg-purple-50',
                'text' => 'text-purple-600',
                'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 18.657A8 8 0 016.343 7.343S7 9 9 10c0-2 .5-5 2.986-7C14 2 16.09 3.777 17.656 5.343A7.975 7.975 0 0120 13a7.975 7.975 0 01-2.343 5.657z" />',
            ],
            CategoryEnum::SHUVOKANKKHI => [
                'bg' => 'bg-red-50',
                'text' => 'text-red-600',
                'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />',
            ],
            'no_member' => [
                'bg' => 'bg-gray-50',
                'text' => 'text-gray-600',
                'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z" />',
                'bangla_name' => 'অন্যান্য'
            ]
        ];

        // Calculate project-specific category-wise totals
        $totalDonations = $project->donations->sum('amount');
        $categoryDonations = [];

        // Calculate donations for each member category
        foreach (CategoryEnum::getValues() as $category) {
            $categoryTotal = $project->donations()
                ->whereHas('member', function($query) use ($category) {
                    $query->where('category', $category);
                })
                ->sum('amount');
            
            $categoryCount = $project->donations()
                ->whereHas('member', function($query) use ($category) {
                    $query->where('category', $category);
                })
                ->count();

            $categoryDonations[$category] = [
                'total' => $categoryTotal,
                'bangla_name' => CategoryEnum::fromValue($category)->toBangla(),
                'count' => $categoryCount,
                'percent' => $totalDonations > 0 
                    ? number_format(($categoryTotal / $totalDonations) * 100, 2) 
                    : 0,
                'style' => $categoryStyles[$category]
            ];
        }

        // Calculate donations without a member
        $noMemberTotal = $project->donations()
            ->whereDoesntHave('member')
            ->sum('amount');

        $noMemberCount = $project->donations()
            ->whereDoesntHave('member')
            ->count();

        if ($noMemberTotal > 0) {
            $categoryDonations['no_member'] = [
                'total' => $noMemberTotal,
                'bangla_name' => $categoryStyles['no_member']['bangla_name'],
                'count' => $noMemberCount,
                'percent' => $totalDonations > 0 
                    ? number_format(($noMemberTotal / $totalDonations) * 100, 2) 
                    : 0,
                'style' => $categoryStyles['no_member']
            ];
        }
        @endphp

        <div class="bg-white rounded-xl p-6 mt-6">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-2xl font-bold text-green-900 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 mr-3 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                    সদস্য শ্রেণি অনুসারে দান
                </h2>
            </div>

            <div class="grid md:grid-cols-5 gap-4">
                @foreach($categoryDonations as $category => $data)
                    <div class="{{ $data['style']['bg'] }} p-4 rounded-lg text-center hover:shadow-md transition-all group">
                        <div class="flex items-center justify-center mb-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 mr-2 {{ $data['style']['text'] }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                {!! $data['style']['icon'] !!}
                            </svg>
                            <h3 class="text-sm {{ $data['style']['text'] }}">{{ $data['bangla_name'] }}</h3>
                        </div>
                        <p class="font-bold {{ $data['style']['text'] }} text-xl">
                            ৳ {{ number_format($data['total'], 2) }}
                        </p>
                        <div class="flex justify-between mt-2 text-xs text-gray-600">
                            <span>দাতা: {{ $data['count'] }}</span>
                            <span>{{ $data['percent'] }}%</span>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- Donations List --}}
        <div class="bg-white rounded-xl shadow-lg p-6">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-bold text-green-900">সকল দান</h2>
                <div class="flex items-center space-x-2">
                    <span class="text-sm text-gray-600">{{ $donations->firstItem() }}-{{ $donations->lastItem() }} of {{ $donations->total() }}</span>
                </div>
            </div>
            
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left">
                    <thead class="bg-green-50 text-green-800 uppercase">
                        <tr>
                            <th class="px-4 py-3">তারিখ</th>
                            <th class="px-4 py-3">মোবাইল নম্বর</th>
                            <th class="px-4 py-3 text-right">পরিমাণ</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($donations as $donation)
                            <tr class="hover:bg-green-50 transition">
                                <td class="px-4 py-4 text-gray-600">
                                    {{ $donation->created_at->format('d M Y') }}
                                </td>
                                <td class="px-4 py-4 text-gray-700">
                                    {{ $donation->mobile_number_mask ?? 'N/A' }}
                                </td>
                                <td class="px-4 py-4 text-right font-bold text-green-800">
                                    ৳ {{ number_format($donation->amount, 2) }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center py-6 text-gray-500">
                                    <div class="flex flex-col items-center space-y-4">
                                        <svg class="w-16 h-16 text-gray-300" fill="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8zm-5-6h10v2H7z"/>
                                        </svg>
                                        <p>কোন দান পাওয়া যায়নি</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            <div class="mt-6">
                {{ $donations->links('vendor.pagination.tailwind') }}
            </div>
        </div>
    </div>

@stop

@push('styles')
<style>
    .pagination {
        display: flex;
        justify-content: center;
        align-items: center;
        margin-top: 1rem;
    }
    .pagination .page-item {
        margin: 0 0.25rem;
    }
</style>
@endpush
