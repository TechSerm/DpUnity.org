<nav x-data="{ mobileMenuOpen: false, profileDropdownOpen: false }" class="fixed top-0 left-0 right-0 z-50 bg-white backdrop-blur-md shadow-sm border-b border-gray-100">
    <!-- Top Bar with Logo and Auth Buttons -->
    <div class="container mx-auto flex items-center justify-between py-3 p-4">
        <div class="flex items-center space-x-6">
            <!-- Logo Section -->
            <a href="/" class="flex items-center">
                <img src="{{ metaData()->getLogo() }}" alt="Logo" class="h-10 w-auto transition-transform duration-300 hover:scale-105">
            </a>

            <!-- Desktop Navigation Links -->
            <div class="hidden md:block w-full overflow-x-auto">
                <div class="flex space-x-6 min-w-max">
                    @php
                        $currentPath = request()->path();
                        $navItems = [
                            ['title' => 'হোম', 'url' => '/', 'icon' => 'fas fa-home'],
                            ['title' => 'আমাদের সম্পর্কে', 'url' => '/about_us', 'icon' => 'fas fa-info-circle'],
                            ['title' => 'সদস্য', 'url' => '/members', 'icon' => 'fas fa-users'],
                            ['title' => 'সংবাদ', 'url' => '/news', 'icon' => 'fas fa-newspaper'],
                            ['title' => 'প্রকল্প', 'url' => '/projects', 'icon' => 'fas fa-project-diagram'],
                        ];
                    @endphp

                    @foreach ($navItems as $item)
                        @php
                            $isActive = 
                                ($currentPath === '' && $item['url'] === '/') || 
                                $currentPath === trim($item['url'], '/') || 
                                (isset($item['activePattern']) && preg_match($item['activePattern'], $currentPath));
                        @endphp
                        <a 
                            href="{{ $item['url'] }}" 
                            class="flex-shrink-0 flex items-center space-x-1 whitespace-nowrap font-bold group relative pb-1 
                            {{ $isActive ? 'text-green-700' : 'text-gray-800 hover:text-green-600' }}"
                        >
                            <i class="{{ $item['icon'] }} {{ $isActive ? 'text-green-700' : 'text-green-600' }} mr-1"></i>
                            <span>{{ $item['title'] }}</span>
   
                        </a>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Desktop Auth Buttons -->
        <div class="hidden md:flex items-center space-x-4">
            @auth
                <div class="relative" x-data="{ open: false }">
                    <!-- Profile Dropdown Toggle -->
                    <button @click="open = !open" class="flex items-center space-x-2 p-2 rounded-lg hover:bg-gray-50 focus:outline-none font-bold">
                        <img src="{{ auth()->user()->image ?? 'default-avatar.png' }}" alt="Profile" class="h-8 w-8 rounded-full">
                        <span class="text-sm font-medium text-gray-800">{{ auth()->user()->name ?? 'Profile' }}</span>
                        <svg class="w-4 h-4 transform transition-transform" :class="{ 'rotate-180': open }" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </button>

                    <!-- Profile Dropdown -->
                    <div x-show="open" x-transition @click.away="open = false" class="absolute right-0 mt-2 w-48 bg-white border border-gray-200 rounded-lg shadow-lg">
                        <a href="/profile" class="block px-4 py-2 text-sm text-gray-800 hover:bg-gray-50 font-bold">Profile</a>
                        <a href="/logout" class="block px-4 py-2 text-sm text-red-600 hover:bg-red-50 font-bold">Logout</a>
                    </div>
                </div>
            @else
                <div class="flex items-center space-x-1">
                    <a href="/login" class="px-4 py-2 bg-green-600 text-white rounded-full hover:bg-green-700 transition-colors font-bold">Login</a>
                    <a href="/register" class="px-4 py-2 border border-gray-200 text-green-600 rounded-full hover:bg-green-50 transition-colors font-bold">Register</a>
                </div>
            @endauth
        </div>

        <!-- Mobile Menu Toggle -->
        <button @click="mobileMenuOpen = !mobileMenuOpen" class="md:hidden text-gray-800 focus:outline-none font-bold">
            <svg x-show="!mobileMenuOpen" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
            <svg x-show="mobileMenuOpen" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    </div>

    <!-- Mobile Menu -->
    <div x-show="mobileMenuOpen" x-transition class="md:hidden bg-white shadow-lg border-t border-gray-100">
        <div class="px-4 py-4 space-y-4">
            <!-- Mobile Navigation Links -->
            @foreach ($navItems as $item)
                <a href="{{ $item['url'] }}" class="block text-gray-800 hover:bg-green-50 py-2 flex items-center space-x-3 font-bold">
                    <i class="{{ $item['icon'] }} text-green-600"></i>
                    <span>{{ $item['title'] }}</span>
                </a>
            @endforeach

            <!-- Mobile Auth Buttons -->
            <div class="pt-4 border-t border-gray-200">
                @auth
                    <div class="flex items-center space-x-4">
                        <img src="{{ auth()->user()->image ?? 'default-avatar.png' }}" alt="Profile" class="h-10 w-10 rounded-full">
                        <div>
                            <p class="text-gray-800 font-medium">{{ auth()->user()->name ?? 'Profile' }}</p>
                            <div class="flex space-x-4 mt-2">
                                <a href="/profile" class="text-sm text-green-600 hover:underline font-bold">Profile</a>
                                <a href="/logout" class="text-sm text-red-600 hover:underline font-bold">Logout</a>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="flex flex-col space-y-4">
                        <a href="/login" class="w-full text-center px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors font-bold">Login</a>
                        <a href="/register" class="w-full text-center px-4 py-2 border border-green-600 text-green-600 rounded-lg hover:bg-green-50 transition-colors font-bold">Register</a>
                    </div>
                @endauth
            </div>
        </div>
    </div>
</nav>