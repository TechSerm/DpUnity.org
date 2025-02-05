<nav class="fixed top-0 left-0 right-0 z-50 bg-white/90 backdrop-blur-md shadow-sm border-b border-gray-100">
  <div class="container mx-auto px-4 py-3 flex items-center justify-between">
      <!-- Logo and Navigation Links Container -->
      <div class="flex items-center space-x-6">
          <!-- Logo Section -->
          <a href="{{ route('home') }}" class="flex items-center group">
              <img 
                  src="{{ theme()->logo() }}" 
                  alt="Logo" 
                  class="h-12 w-[140px] transition-transform duration-300 group-hover:scale-105"
              >
          </a>

          <!-- Navigation Links -->
          <div class="hidden md:flex items-center space-x-6">
              <a href="{{ route('home') }}" class="text-md font-medium text-gray-600 hover:text-indigo-600 transition-colors duration-300 flex items-center group relative">
                  <svg class="w-5 h-5 mr-2 text-gray-400 group-hover:text-indigo-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                  </svg>
                  Home
                  <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-indigo-600 transition-all duration-300 group-hover:w-full"></span>
              </a>
              <a href="#" class="text-md font-medium text-gray-600 hover:text-indigo-600 transition-colors duration-300 flex items-center group relative">
                  <svg class="w-5 h-5 mr-2 text-gray-400 group-hover:text-indigo-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                  </svg>
                  About
                  <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-indigo-600 transition-all duration-300 group-hover:w-full"></span>
              </a>
          </div>
      </div>

      <!-- Mobile Menu Toggle and User Actions -->
      <div class="flex items-center space-x-4">
          <!-- Mobile Menu Toggle -->
          <button id="mobile-menu-toggle" class="md:hidden text-gray-600 hover:text-indigo-600 transition-colors duration-300">
              <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
              </svg>
          </button>

          <!-- User Actions -->
          <div class="relative group">
              @auth
                  <button class="flex items-center space-x-2 hover:bg-gray-50 p-2 rounded-lg transition-colors duration-300">
                      <img 
                          src="{{ auth()->user()->image }}" 
                          alt="{{ auth()->user()->name }}" 
                          class="h-8 w-8 rounded-full object-cover border-2 border-indigo-100 group-hover:border-indigo-300 transition-all"
                      >
                      <span class="hidden md:block text-sm font-medium text-gray-700 group-hover:text-indigo-600">
                          {{ auth()->user()->name }}
                      </span>
                      <svg class="w-4 h-4 text-gray-500 group-hover:text-indigo-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                      </svg>
                  </button>
                  <!-- Dropdown Menu -->
                  <div class="absolute right-0 mt-2 w-48 bg-white border border-gray-200 rounded-lg shadow-lg opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 origin-top-right">
                      <a href="" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">Profile</a>
                      <a href="{{ route('logout') }}" class="block px-4 py-2 text-sm text-red-600 hover:bg-red-50">Logout</a>
                  </div>
              @else
                  <a href="{{ route('login') }}" class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors duration-300 flex items-center space-x-2 shadow-md hover:shadow-lg">
                      <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
                      </svg>
                      <span>Login</span>
                  </a>
              @endauth
          </div>
      </div>

      <!-- Mobile Dropdown Menu -->
      <div id="mobile-menu" class="fixed top-16 left-0 right-0 bg-white shadow-lg md:hidden hidden">
          <div class="px-4 py-4 space-y-4">
              <a href="{{ route('home') }}" class="block text-md font-medium text-gray-600 hover:text-indigo-600 transition-colors duration-300 flex items-center space-x-2">
                  <svg class="w-5 h-5 text-gray-400 group-hover:text-indigo-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                  </svg>
                  <span>Home</span>
              </a>
              <a href="#" class="block text-md font-medium text-gray-600 hover:text-indigo-600 transition-colors duration-300 flex items-center space-x-2">
                  <svg class="w-5 h-5 text-gray-400 group-hover:text-indigo-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                  </svg>
                  <span>About</span>
              </a>
          </div>
      </div>
  </div>
</nav>

@push('scripts')
<script>
    document.getElementById('mobile-menu-toggle').addEventListener('click', function() {
        const mobileMenu = document.getElementById('mobile-menu');
        mobileMenu.classList.toggle('hidden');
    });

    // Close mobile menu when clicking outside
    document.addEventListener('click', function(event) {
        const mobileMenu = document.getElementById('mobile-menu');
        const mobileMenuToggle = document.getElementById('mobile-menu-toggle');
        
        if (!mobileMenu.contains(event.target) && 
            !mobileMenuToggle.contains(event.target) && 
            !mobileMenu.classList.contains('hidden')) {
            mobileMenu.classList.add('hidden');
        }
    });
</script>
@endpush