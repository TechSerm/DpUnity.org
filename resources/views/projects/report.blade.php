@extends('projects.layout')

@section('title', $project->title . ' - Reports')

@section('tab-content')
    <template x-if="activeTab === 'reports'">
        <div class="space-y-8">
            {{-- Financial Overview --}}
            <div class="bg-white rounded-xl shadow-sm border border-gray-50 p-6">
                <h2 class="text-2xl font-bold text-green-900 mb-6">আর্থিক সংক্ষিপ্ত বিবরণ</h2>
                @php
                    $totalDonations = $project->donations->sum('amount');
                    $totalExpenses = $project->expenses->sum('amount');
                    $targetAmount = $project->target_amount ?? 1;
                    $projectProgress =
                        $targetAmount > 0
                            ? banglaFormatter()->number(($totalExpenses / $targetAmount) * 100)
                            : banglaFormatter()->number(0);
                @endphp
                <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6">
                    <!-- Total Donations Card -->
                    <div
                        class="bg-gradient-to-br from-green-50 to-green-100 border border-green-100 p-6 rounded-xl shadow-sm flex items-center gap-6 hover:shadow-xl transition-shadow duration-300">
                        <div class="bg-green-200 p-4 rounded-full flex-shrink-0">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-green-700" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div>
                            <p class="font-bold text-green-900 text-2xl mb-2">
                                ৳ {{ banglaFormatter()->number($project->donations->sum('amount')) }}
                            </p>
                            <h3 class="text-sm text-green-700 font-semibold">মোট জমা</h3>
                        </div>
                    </div>

                    <!-- Total Expenses Card -->
                    <div
                        class="bg-gradient-to-br from-red-50 to-red-100 border border-red-100 p-6 rounded-xl shadow-sm flex items-center gap-6 hover:shadow-xl transition-shadow duration-300">
                        <div class="bg-red-200 p-4 rounded-full flex-shrink-0">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-red-700" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                        </div>
                        <div>
                            <p class="font-bold text-red-900 text-2xl mb-2">
                                ৳ {{ banglaFormatter()->number($project->expenses->sum('amount')) }}
                            </p>
                            <h3 class="text-sm text-red-700 font-semibold">মোট ব্যয়</h3>
                        </div>
                    </div>

                    <!-- Current Balance Card -->
                    <div
                        class="bg-gradient-to-br from-blue-50 to-blue-100 border border-blue-100 p-6 rounded-xl shadow-sm flex items-center gap-6 hover:shadow-xl transition-shadow duration-300">
                        <div class="bg-blue-200 p-4 rounded-full flex-shrink-0">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-blue-700" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
                            </svg>
                        </div>
                        <div>
                            <p class="font-bold text-blue-900 text-2xl mb-2">
                                ৳
                                {{ banglaFormatter()->number($project->donations->sum('amount') - $project->expenses->sum('amount')) }}
                            </p>
                            <h3 class="text-sm text-blue-700 font-semibold">বর্তমান ব্যালেন্স</h3>
                        </div>
                    </div>
                </div>

            </div>
            @php
                $totalExpenses = $expenses->sum('amount');
                $categoryExpenses = $expenses
                    ->groupBy('category.name')
                    ->map(function ($categoryExpenses, $categoryName) use ($totalExpenses) {
                        // Get the first category instance to retrieve its color
                        $category = $categoryExpenses->first()->category;
                        $categoryTotal = $categoryExpenses->sum('amount');

                        return [
                            'total' => $categoryTotal,
                            'percent' => $totalExpenses > 0 ? ($categoryTotal / $totalExpenses) * 100 : 0,
                            'count' => $categoryExpenses->count(),
                            'name' => $category->name,
                            'color' => $category->color ?? 'rgba(201, 203, 207, 0.6)',
                            'border_color' => $category->color
                                ? str_replace('0.6)', '1)', $category->color)
                                : 'rgba(201, 203, 207, 1)',
                        ];
                    })
                    ->sortByDesc('total');
            @endphp
            


            @php
                use App\Enums\CategoryEnum;

                // Calculate project-specific category-wise totals
                $totalDonations = $project->donations->sum('amount');
                $categoryDonations = [];

                // Define category-specific colors and icons
                $categoryStyles = [
                    CategoryEnum::SODDOSHO => [
                        'bg' => 'bg-blue-50',
                        'text' => 'text-blue-600',
                        'icon' =>
                            '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a8 8 0 00-8 8h16a8 8 0 00-8-8z" />',
                    ],
                    CategoryEnum::DATA_SODDOSHO => [
                        'bg' => 'bg-green-50',
                        'text' => 'text-green-600',
                        'icon' =>
                            '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />',
                    ],
                    CategoryEnum::SHOHOJODDHA => [
                        'bg' => 'bg-purple-50',
                        'text' => 'text-purple-600',
                        'icon' =>
                            '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 18.657A8 8 0 016.343 7.343S7 9 9 10c0-2 .5-5 2.986-7C14 2 16.09 3.777 17.656 5.343A7.975 7.975 0 0120 13a7.975 7.975 0 01-2.343 5.657z" />',
                    ],
                    CategoryEnum::SHUVOKANKKHI => [
                        'bg' => 'bg-red-50',
                        'text' => 'text-red-600',
                        'icon' =>
                            '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />',
                    ],
                    'no_member' => [
                        'bg' => 'bg-gray-50',
                        'text' => 'text-gray-600',
                        'icon' =>
                            '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0m0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />',
                    ],
                ];

                foreach (CategoryEnum::getValues() as $category) {
                    $categoryTotal = $project
                        ->donations()
                        ->whereHas('member', function ($query) use ($category) {
                            $query->where('category', $category);
                        })
                        ->sum('amount');

                    $categoryCount = $project
                        ->donations()
                        ->whereHas('member', function ($query) use ($category) {
                            $query->where('category', $category);
                        })
                        ->count();

                    $categoryDonations[$category] = [
                        'total' => $categoryTotal,
                        'bangla_name' => CategoryEnum::fromValue($category)->toBangla(),
                        'count' => $categoryCount,
                        'percent' =>
                            $totalDonations > 0
                                ? banglaFormatter()->number(($categoryTotal / $totalDonations) * 100)
                                : banglaFormatter()->number(0),
                        'style' => $categoryStyles[$category],
                    ];
                }

                // Add donations without a member
                $noMemberTotal = $project->donations()->whereDoesntHave('member')->sum('amount');

                $noMemberCount = $project->donations()->whereDoesntHave('member')->count();

                if ($noMemberTotal > 0) {
                    $categoryDonations['no_member'] = [
                        'total' => $noMemberTotal,
                        'bangla_name' => 'অন্যান্য',
                        'count' => $noMemberCount,
                        'percent' =>
                            $totalDonations > 0
                                ? banglaFormatter()->number(($noMemberTotal / $totalDonations) * 100)
                                : banglaFormatter()->number(0),
                        'style' => $categoryStyles['no_member'],
                    ];
                }
            @endphp

            {{-- Expenses Analysis --}}
            <div class="grid shadow-sm border border-gray-50 rounded-lg md:grid-cols-2 p-6 gap-6">
                {{-- Expenses Chart --}}
                <div class="bg-white rounded-xl flex flex-col items-center">
                    <h3 class="text-xl font-bold text-red-900 mb-4">ব্যয় বিশ্লেষণ</h3>
                    <div class="w-full max-w-xs aspect-square">
                        <canvas id="expensesChart" class="w-full h-full"></canvas>
                    </div>
                </div>

                {{-- Expenses Cards --}}
                <div class="bg-white rounded-xl">
                    <h3 class="text-xl font-bold text-red-900 mb-4">ব্যয় বিশ্লেষণ (ক্যাটাগরি অনুযায়ী)</h3>
                    <div class="grid grid-cols-1 md:grid-cols-1 lg:grid-cols-2 gap-4">
                        @foreach ($categoryExpenses as $category)
                            <div
                                class="bg-red-50 border border-red-100 p-5 rounded-xl flex items-center justify-between shadow-sm hover:shadow-lg transition-transform transform hover:scale-105">
                                {{-- Left Section: Color Indicator and Name --}}
                                <div class="flex items-center space-x-4">
                                    <div class="flex items-center justify-center w-6 h-6 rounded-full"
                                        style="background-color: {{ $category['color'] }};">
                                    </div>
                                    <div>
                                        <h4 class="text-red-900 font-bold text-base">{{ $category['name'] }}</h4>
                                        
                                    </div>
                                </div>
                                {{-- Right Section: Expense Details --}}
                                <div class="text-right">
                                    <p class="text-lg font-extrabold text-red-900">
                                        ৳ {{ banglaFormatter()->number($category['total']) }}
                                    </p>
                                    <span
                                        class="text-sm text-gray-500">{{ banglaFormatter()->number($category['percent']) }}%</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            
            {{-- Donations by Member Category --}}
            <div class="bg-white rounded-xl shadow-sm border border-gray-50 p-6 mt-6">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-2xl font-bold text-green-900 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 mr-3 text-green-600" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                        সদস্য শ্রেণি অনুসারে দান
                    </h2>
                    <span class="text-sm text-gray-500">মোট {{ banglaFormatter()->number(array_sum(array_column($categoryDonations, 'count'))) }} 
                        জন জমা দিয়েছে</span>
                </div>

                <div class="grid md:grid-cols-2 gap-6">
                    {{-- Donations by Category Chart --}}
                    <div class="flex flex-col items-center">
                        <h3 class="text-xl font-bold text-green-900 mb-4">দান বিশ্লেষণ</h3>
                        <div class="w-full max-w-xs aspect-square">
                            <canvas id="donationCategoryChart" class="w-full h-full"></canvas>
                        </div>
                    </div>

                    {{-- Donations Category Table --}}
                    <div class="">
                        <h3 class="text-xl font-bold text-green-900 mb-4">দান বিশ্লেষণ (তালিকা)</h3>
                        <div class="grid lg:grid-cols-2 md:grid-cols-1 gap-4">
                            @foreach ($categoryDonations as $category => $data)
                                <div
                                    class="{{ $data['style']['bg'] }} p-4 rounded-lg grid grid-cols-2 items-center hover:shadow-md transition-all group">
                                    <div class="flex items-center space-x-3">
                                        <svg xmlns="http://www.w3.org/2000/svg"
                                            class="h-10 w-10 {{ $data['style']['text'] }}" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            {!! $data['style']['icon'] !!}
                                        </svg>
                                        <div>
                                            <h4 class="text-md {{ $data['style']['text'] }} font-semibold">
                                                {{ $data['bangla_name'] }}</h4>
                                            <span class="text-sm text-gray-500">জমা দিয়েছে: {{ banglaFormatter()->number($data['count']) }}</span>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <p class="font-bold {{ $data['style']['text'] }} text-lg">
                                            ৳ {{ banglaFormatter()->number($data['total']) }}
                                        </p>
                                        <span class="text-xs text-gray-500">{{ $data['percent'] }}%</span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            {{-- Donation and Expense Insights --}}
            <div class="p-5 rounded-xl shadow-sm">
                <h3 class="text-lg font-semibold text-blue-800 mb-3 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                    </svg>
                    দান এবং ব্যয় বিশ্লেষণ
                </h3>

                <div class="bg-white p-4 rounded-lg shadow-sm">
                    {{-- Monthly Trends --}}
                    <div class="grid md:grid-cols-2 gap-4">
                        {{-- Donation Trends --}}
                        <div>
                            <h4 class="text-sm text-green-600 mb-2 flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                                </svg>
                                মাসিক দান প্রবণতা
                            </h4>
                            <div class="space-y-2">
                                @php
                                    $donations = $project->donations;
                                    $donationsByMonth = $donations->groupBy(function ($donation) {
                                        return $donation->created_at->format('Y-m');
                                    });

                                    $monthlyDonationTrends = [];
                                    foreach ($donationsByMonth as $month => $monthDonations) {
                                        $monthlyDonationTrends[] = [
                                            'month' => $month,
                                            'total_amount' => $monthDonations->sum('amount'),
                                            'donation_count' => $monthDonations->count(),
                                        ];
                                    }

                                    // Sort trends by month
                                    usort($monthlyDonationTrends, function ($a, $b) {
                                        return strtotime($a['month']) - strtotime($b['month']);
                                    });
                                @endphp
                                @foreach (array_slice($monthlyDonationTrends, -3) as $trend)
                                    <div class="bg-green-50 p-2 rounded-lg">
                                        <div class="flex justify-between text-xs">
                                            <span
                                                class="text-gray-600">{{ \Carbon\Carbon::parse($trend['month'])->format('M Y') }}</span>
                                            <span class="font-bold text-green-800">
                                                ৳ {{ banglaFormatter()->number($trend['total_amount']) }}
                                            </span>
                                        </div>
                                        <div class="text-xs text-green-600">
                                            {{ $trend['donation_count'] }} দান
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        {{-- Expense Trends --}}
                        <div>
                            <h4 class="text-sm text-red-600 mb-2 flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                                মাসিক ব্যয় প্রবণতা
                            </h4>
                            <div class="space-y-2">
                                @php
                                    $expenses = $project->expenses;
                                    $expensesByMonth = $expenses->groupBy(function ($expense) {
                                        return $expense->created_at->format('Y-m');
                                    });

                                    $monthlyExpenseTrends = [];
                                    foreach ($expensesByMonth as $month => $monthExpenses) {
                                        $monthlyExpenseTrends[] = [
                                            'month' => $month,
                                            'total_amount' => $monthExpenses->sum('amount'),
                                            'expense_count' => $monthExpenses->count(),
                                        ];
                                    }

                                    // Sort trends by month
                                    usort($monthlyExpenseTrends, function ($a, $b) {
                                        return strtotime($a['month']) - strtotime($b['month']);
                                    });
                                @endphp
                                @foreach (array_slice($monthlyExpenseTrends, -3) as $trend)
                                    <div class="bg-red-50 p-2 rounded-lg">
                                        <div class="flex justify-between text-xs">
                                            <span
                                                class="text-gray-600">{{ \Carbon\Carbon::parse($trend['month'])->format('M Y') }}</span>
                                            <span class="font-bold text-red-800">
                                                ৳ {{ banglaFormatter()->number($trend['total_amount']) }}
                                            </span>
                                        </div>
                                        <div class="text-xs text-red-600">
                                            {{ $trend['expense_count'] }} ব্যয়
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </template>
@stop

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('alpine:init', () => {
            // Expenses Chart
            const expensesCtx = document.getElementById('expensesChart').getContext('2d');

            // Prepare chart data
            const categoryData = {
                labels: @json($categoryExpenses->pluck('name')),
                datasets: [{
                    label: 'ব্যয় বিভাজন',
                    data: @json($categoryExpenses->pluck('total')),
                    backgroundColor: @json($categoryExpenses->pluck('color')),
                    borderColor: @json($categoryExpenses->pluck('border_color')),
                    borderWidth: 1
                }]
            };

            new Chart(expensesCtx, {
                type: 'doughnut',
                data: categoryData,
                options: {
                    responsive: true,
                    maintainAspectRatio: true,
                    layout: {
                        padding: 10
                    },
                    plugins: {
                        legend: {
                            display: true
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    let label = context.label || '';
                                    let value = context.parsed;
                                    let total = context.dataset.data.reduce((a, b) => a + b, 0);
                                    let percentage = ((value / total) * 100).toFixed(0);
                                    return `${label}: ৳ ${value.toFixed(0)} (${percentage}%)`;
                                }
                            }
                        }
                    }
                }
            });

            // Donations by Category Chart
            const donationCategoryCtx = document.getElementById('donationCategoryChart').getContext('2d');

            const donationCategoryData = {
                labels: @json(array_column($categoryDonations, 'bangla_name')),
                datasets: [{
                    label: 'দান বিশ্লেষণ',
                    data: @json(array_column($categoryDonations, 'total')),
                    backgroundColor: [
                        'rgba(54, 162, 235, 0.6)',
                        'rgba(75, 192, 192, 0.6)',
                        'rgba(153, 102, 255, 0.6)',
                        'rgba(255, 99, 132, 0.6)',
                        'rgba(201, 203, 207, 0.6)'
                    ],
                    borderColor: [
                        'rgba(54, 162, 235, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 99, 132, 1)',
                        'rgba(201, 203, 207, 1)'
                    ],
                    borderWidth: 1
                }]
            };

            new Chart(donationCategoryCtx, {
                type: 'pie',
                data: donationCategoryData,
                options: {
                    responsive: true,
                    plugins: {
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    let label = context.label || '';
                                    let value = context.parsed;
                                    let total = context.dataset.data.reduce((a, b) => a + b, 0);
                                    let percentage = ((value / total) * 100).toFixed(0);
                                    return `${label}: ৳ ${value.toFixed(0)} (${percentage}%)`;
                                }
                            }
                        }
                    }
                }
            });
        });
    </script>
@endpush

@push('styles')
    <style>
        /* Additional custom styles if needed */
    </style>
@endpush
