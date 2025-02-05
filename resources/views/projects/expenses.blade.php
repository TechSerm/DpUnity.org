@extends('projects.layout')

@section('title', $project->title . ' - Expenses')

@section('tab-content')
<template x-if="activeTab === 'expenses'">
    <div class="space-y-6">
        {{-- Expenses Summary Cards --}}
        <div class="grid md:grid-cols-3 gap-4">
            <div class="bg-red-50 p-6 rounded-xl shadow-sm text-center">
                <div class="flex items-center justify-center space-x-3 mb-2">
                    <svg class="w-8 h-8 text-red-600" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 17h-2v-2h2v2zm2.07-7.75l-.9.92C13.45 12.9 13 13.5 13 15h-2v-.5c0-1.1.45-2.1 1.17-2.83l1.24-1.26c.37-.36.59-.86.59-1.41 0-1.1-.9-2-2-2s-2 .9-2 2H8c0-2.21 1.79-4 4-4s4 1.79 4 4c0 .88-.36 1.68-.93 2.25z"/>
                    </svg>
                    <h3 class="text-lg font-semibold text-red-800">মোট ব্যয়</h3>
                </div>
                <p class="text-3xl font-bold text-red-900">
                    ৳ {{ number_format($project->expenses->sum('amount'), 2) }}
                </p>
            </div>
            <div class="bg-orange-50 p-6 rounded-xl shadow-sm text-center">
                <div class="flex items-center justify-center space-x-3 mb-2">
                    <svg class="w-8 h-8 text-orange-600" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M11 15h2v-2h-2v2zm0-8h2V5h-2v2zm0 4h2v-2h-2v2zm8-5V3c0-.55-.45-1-1-1H4c-.55 0-1 .45-1 1v8c0 .55.45 1 1 1h14c.55 0 1-.45 1-1V6zm-2 5H5V4h12v4zm3-6h-2v8H3V5H1v10h22V6h-2z"/>
                    </svg>
                    <h3 class="text-lg font-semibold text-orange-800">মোট লেনদেন</h3>
                </div>
                <p class="text-3xl font-bold text-orange-900">
                    {{ $project->expenses->count() }}
                </p>
            </div>
            <div class="bg-purple-50 p-6 rounded-xl shadow-sm text-center">
                <div class="flex items-center justify-center space-x-3 mb-2">
                    <svg class="w-8 h-8 text-purple-600" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm.36 14.83c-2.08 0-3.77-1.69-3.77-3.77h1.89c0 1.03.84 1.87 1.87 1.87s1.87-.84 1.87-1.87-1.03-1.87-2.05-1.87h-.36l.92-.92c.57.57.92 1.37.92 2.24 0 1.76-1.43 3.19-3.19 3.19V16c2.61 0 4.74-2.13 4.74-4.74 0-2.61-2.13-4.74-4.74-4.74S7.26 8.65 7.26 11.26h-1.8c0-3.56 2.89-6.45 6.45-6.45s6.45 2.89 6.45 6.45-2.89 6.45-6.45 6.45z"/>
                    </svg>
                    <h3 class="text-lg font-semibold text-purple-800">গড় ব্যয়</h3>
                </div>
                <p class="text-3xl font-bold text-purple-900">
                    ৳ {{ number_format($project->expenses->avg('amount'), 2) }}
                </p>
            </div>
        </div>

        {{-- Expenses List --}}
        <div class="bg-white rounded-xl shadow-lg p-6">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-bold text-red-900">সকল ব্যয়</h2>
                <div class="flex items-center space-x-2">
                    <span class="text-sm text-gray-600">{{ $expenses->firstItem() }}-{{ $expenses->lastItem() }} of {{ $expenses->total() }}</span>
                </div>
            </div>
            
            <div class="overflow-x-auto">
                <div 
                    x-data="{ 
                        selectedExpenseId: null,
                        isLoading: false,
                        expenseDetailsHtml: null,
                        errorMessage: null,
                        async openExpenseModal(expenseId) {
                            this.selectedExpenseId = expenseId;
                            this.isLoading = true;
                            this.errorMessage = null;
                            
                            try {
                                const response = await fetch(`/projects/{{ $project->id }}/expenses/${expenseId}`, {
                                    headers: {
                                        'X-Requested-With': 'XMLHttpRequest',
                                        'Accept': 'text/html'
                                    }
                                });

                                // Log full response for debugging
                                console.log('Response status:', response.status);
                                console.log('Response headers:', Object.fromEntries(response.headers));

                                if (!response.ok) {
                                    throw new Error('Unable to load expense details');
                                }

                                // Get HTML content
                                this.expenseDetailsHtml = await response.text();
                                
                                // Open modal and insert HTML
                                this.$refs.expenseModal.classList.remove('hidden');
                                this.$refs.expenseModalContent.innerHTML = this.expenseDetailsHtml;
                            } catch (error) {
                                console.error('Error fetching expense details:', error);
                                this.errorMessage = error.message || 'Unable to load expense details';
                                alert(this.errorMessage);
                            } finally {
                                this.isLoading = false;
                            }
                        },
                        closeExpenseModal() {
                            this.selectedExpenseId = null;
                            this.expenseDetailsHtml = null;
                            this.errorMessage = null;
                            this.$refs.expenseModal.classList.add('hidden');
                            this.$refs.expenseModalContent.innerHTML = '';
                        }
                    }"
                    x-init="
                        window.addEventListener('close-expense-modal', () => {
                            closeExpenseModal();
                        });
                    "
                >
                    <table class="w-full text-sm text-left">
                        <thead class="bg-red-50 text-red-800 uppercase">
                            <tr>
                                <th class="px-4 py-3">তারিখ</th>
                                <th class="px-4 py-3">ক্যাটাগরি</th>
                                <th class="px-4 py-3">শিরোনাম</th>
                                <th class="px-4 py-3 text-right">পরিমাণ</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($expenses as $expense)
                                <tr 
                                    @click="openExpenseModal({{ $expense->id }})"
                                    class="cursor-pointer hover:bg-gray-50 transition"
                                >
                                    <td class="px-4 py-4 text-gray-600">
                                        {{ $expense->created_at->format('d M Y') }}
                                    </td>
                                    <td class="px-4 py-4 text-gray-700 font-medium">
                                        {{ $expense->category->name ?? 'N/A' }}
                                    </td>
                                    <td class="px-4 py-4 text-gray-800">
                                        {{ $expense->title ?? 'N/A' }}
                                    </td>
                                    <td class="px-4 py-4 text-right font-bold text-red-800">
                                        ৳ {{ number_format($expense->amount, 2) }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center py-6 text-gray-500">
                                        <div class="flex flex-col items-center space-y-4">
                                            <svg class="w-16 h-16 text-gray-300" fill="currentColor" viewBox="0 0 24 24">
                                                <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8zm-5-6h10v2H7z"/>
                                            </svg>
                                            <p>কোন ব্যয় পাওয়া যায়নি</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                    {{-- Expense Details Modal --}}
                    <div 
                        x-ref="expenseModal"
                        class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden flex items-center justify-center"
                    >
                        <div 
                            @click.away="closeExpenseModal"
                            class="bg-white rounded-xl shadow-2xl w-full max-w-md mx-4 p-6 relative"
                        >
                            {{-- Loading Indicator --}}
                            <div x-show="isLoading" class="absolute inset-0 bg-white bg-opacity-75 flex items-center justify-center">
                                <div class="animate-spin rounded-full h-10 w-10 border-b-2 border-green-600"></div>
                            </div>

                            {{-- Modal Content --}}
                            <div x-ref="expenseModalContent">
                                {{-- Dynamically inserted HTML will go here --}}
                            </div>

                            {{-- Error Message --}}
                            <template x-if="errorMessage">
                                <div class="text-red-600 text-center">
                                    <p x-text="errorMessage"></p>
                                </div>
                            </template>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Pagination --}}
            <div class="mt-6">
                {{ $expenses->links('vendor.pagination.tailwind') }}
            </div>
        </div>
    </div>
</template>
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
    [x-cloak] { display: none !important; }
</style>
@endpush
