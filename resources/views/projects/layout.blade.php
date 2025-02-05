@extends('store.layout.layout')

@section('content')
<div 
    x-data="projectTabs()"
    x-init="initActiveTab()"
    class=" mx-auto"
>
    {{-- Breadcrumb --}}
    <nav class="flex mb-8" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-3">
            <li class="inline-flex items-center">
                <a href="{{ route('projects.index') }}" class="inline-flex items-center text-sm text-green-700 hover:text-green-900">
                    <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path>
                    </svg>
                    প্রকল্প সমূহ
                </a>
            </li>
            <li>
                <div class="flex items-center">
                    <svg class="w-6 h-6 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                    </svg>
                    <span class="ml-1 text-sm font-medium text-green-500">{{ $project->title }}</span>
                </div>
            </li>
        </ol>
    </nav>

    <div class="text-center mb-12">
        <h1 class="text-4xl font-extrabold text-green-900 mb-4">
            {{ $project->title }}
        </h1>
        <p class="text-xl text-green-700 max-w-2xl mx-auto">
            {{ banglaFormatter()->date($project->start_date->format('d M Y')) }} - {{ banglaFormatter()->date($project->end_date->format('d M Y')) }}
        </p>
    </div>

    {{-- Project Header --}}
    <div class="bg-white border border-gray-100 rounded-xl shadow-lg mb-8">
        

        {{-- Tab Navigation with Horizontal Scroll --}}
        <div class="border-b border-gray-100 shadow-sm overflow-x-auto mb-3">
            <nav class="flex  scrollbar-hide" style="overflow-x: auto; -webkit-overflow-scrolling: touch;">
                <a 
                    href="{{ route('projects.show', $project) }}"
                    :class="activeTab === 'overview' ? 'border-green-500 text-green-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                    class="whitespace-nowrap py-4 px-4 border-b-2 font-medium text-md flex items-center space-x-2 flex-shrink-0"
                >
                    <i class="fa fa-info-circle"></i>
                    <span>প্রকল্পের বিবরণ</span>
                </a>
                <a 
                    href="{{ route('projects.donations', $project) }}"
                    :class="activeTab === 'donations' ? 'border-green-500 text-green-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                    class="whitespace-nowrap py-4 px-4 border-b-2 font-medium text-md flex items-center space-x-2 flex-shrink-0"
                >
                    <i class="fa fa-hand-holding-usd"></i>
                    <span>জমা</span>
                </a>
                <a 
                    href="{{ route('projects.expenses', $project) }}"
                    :class="activeTab === 'expenses' ? 'border-green-500 text-green-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                    class="whitespace-nowrap py-4 px-4 border-b-2 font-medium text-md flex items-center space-x-2 flex-shrink-0"
                >
                    <i class="fa fa-file-invoice-dollar"></i>
                    <span>ব্যয়</span>
                </a>
                <a 
                    href="{{ route('projects.reports', $project) }}"
                    :class="activeTab === 'reports' ? 'border-green-500 text-green-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                    class="whitespace-nowrap py-4 px-4 border-b-2 font-medium text-md flex items-center space-x-2 flex-shrink-0"
                >
                    <i class="fa fa-chart-line"></i>
                    <span>রিপোর্ট</span>
                </a>
                
                
            </nav>
        </div>

        {{-- Dynamic Content Yield --}}
        <div class="p-6">
            @yield('tab-content')
        </div>
        
    </div>
</div>
@endsection

@push('scripts')
<script>
    function projectTabs() {
        return {
            activeTab: 'overview',
            
            initActiveTab() {
                const currentPath = window.location.pathname;
                const routes = {
                    'overview': "{{ route('projects.show', $project) }}",
                    'donations': "{{ route('projects.donations', $project) }}",
                    'expenses': "{{ route('projects.expenses', $project) }}",
                    'reports': "{{ route('projects.reports', $project) }}"
                };

                // Determine active tab based on current URL
                for (const [tab, route] of Object.entries(routes)) {
                    const cleanRoute = route.replace(window.location.origin, '').replace(/\/$/, '');
                    const cleanPath = currentPath.replace(/\/$/, '');

                    if (cleanPath === cleanRoute) {
                        this.activeTab = tab;
                        break;
                    }
                }

                // Log for debugging
                console.log('Current Path:', currentPath);
                console.log('Active Tab:', this.activeTab);
            }
        };
    }

    // Ensure Alpine is initialized after DOM is ready
    document.addEventListener('alpine:init', () => {
        Alpine.data('projectTabs', projectTabs);
    });
</script>
@endpush

<style>
    /* Hide scrollbar for Chrome, Safari and Opera */
    .scrollbar-hide::-webkit-scrollbar {
        display: none;
    }

    /* Hide scrollbar for IE, Edge and Firefox */
    .scrollbar-hide {
        -ms-overflow-style: none;  /* IE and Edge */
        scrollbar-width: none;  /* Firefox */
    }
</style>
