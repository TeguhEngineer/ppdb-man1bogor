<header class="bg-white shadow-sm">
    <div class="flex justify-between items-center px-4 md:px-6 py-2.5 md:py-3">
        <div class="flex items-center">
            <!-- Mobile Menu Button -->
            <button onclick="toggleSidebar(); document.getElementById('overlay').classList.toggle('hidden');"
                class="mr-3 text-gray-600 md:hidden">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>
            {{-- <h1 class="text-lg font-medium text-gray-800">Sistem Informasi</h1> --}}
        </div>

        <div class="flex items-center space-x-1 md:space-x-2 relative" x-data="{ open: false }">

            {{-- Notifications Icon --}}
            <div x-data="{ open: false }" class="relative">
                <button @click="open = !open" class="p-1.5 md:p-2 rounded-full hover:bg-gray-100 relative focus:outline-none">
                    <!-- Bell Icon -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                    </svg>

                    <!-- Red Dot Notification -->
                    <span class="absolute top-0.5 right-0.5 w-2 h-2 bg-red-500 rounded-full animate-ping"></span>
                    <span class="absolute top-0.5 right-0.5 w-2 h-2 bg-red-500 rounded-full"></span>
                </button>

                <!-- Dropdown Menu -->
                <div x-show="open" @click.outside="open = false" x-transition
                    class="absolute right-0 mt-2 w-64 bg-white rounded-lg shadow-lg border border-gray-200 z-50">
                    <div class="py-2">
                        <a href="#" class="flex items-center px-4 py-2 hover:bg-gray-100">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-500 mr-3" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 16h-1v-4h-1m1-4h.01M21 12c0 4.97-4.03 9-9 9s-9-4.03-9-9 4.03-9 9-9 9 4.03 9 9z" />
                            </svg>
                            Sistem berhasil diupdate.
                        </a>
                        <a href="#" class="flex items-center px-4 py-2 hover:bg-gray-100">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-500 mr-3" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                            Data transaksi baru masuk.
                        </a>
                    </div>

                    <!-- Divider -->
                    <div class="border-t border-gray-200"></div>

                    <!-- View All Link -->
                    <div class="py-2">
                        <a href="/notifications"
                            class="block text-center text-sm text-blue-600 font-medium hover:bg-gray-100 px-4 py-2">
                            View All Notifications
                        </a>
                    </div>
                </div>
            </div>

            <!-- User Menu -->
            <div class="relative" x-data="{ open: false }">
                <button @click="open = !open"
                    class="flex items-center space-x-1.5 md:space-x-2 p-1 md:p-1.5 rounded-full border-2 border-indigo-100 hover:bg-indigo-50 focus:outline-none transition-colors">
                    <div class="w-7 h-7 md:w-8 md:h-8 rounded-full bg-gray-200 overflow-hidden flex-shrink-0">
                        <img src="https://i.pravatar.cc/100" alt="User profile" class="w-full h-full object-cover">
                    </div>
                    <span class="text-gray-700 font-medium text-xs md:text-sm pr-1.5 md:pr-2 hidden sm:inline-block">{{ Auth::user()->name }}</span>
                    <svg class="w-3.5 h-3.5 text-gray-500 hidden sm:block mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>

                <!-- Dropdown Menu -->
                <div x-show="open" @click.away="open = false" x-transition
                    class="absolute right-0 mt-2 w-56 bg-white border border-gray-200 rounded-lg shadow-lg z-50 overflow-hidden">
                    <!-- User Info Section -->
                    <div class="px-4 py-2.5 border-b border-gray-200 bg-gray-50">
                        <div class="font-medium text-sm text-gray-900">{{ Auth::user()->name }}</div>
                        <div class="text-xs text-gray-500 truncate">{{ Auth::user()->email }}</div>
                        <div class="text-xs text-gray-400 mt-0.5 capitalize">{{ Auth::user()->role }}</div>
                    </div>

                    <!-- Menu Items with Icons -->
                    <div class="py-1">
                        <a href="{{ route('profile.index') }}"
                            class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                            <i class="fi fi-rs-user text-base leading-none w-5 mr-2"></i>
                            <span>Profile</span>
                        </a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <a href="{{ route('logout') }}"
                                onclick="event.preventDefault();
                                    this.closest('form').submit();"
                                class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                <i class="fi fi-rs-sign-out-alt text-base leading-none w-5 mr-2"></i>
                                <span>Logout</span>
                            </a>
                        </form>
                    </div>
                </div>
            </div>

        </div>

    </div>
</header>
