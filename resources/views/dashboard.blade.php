<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-bold text-gray-800">Dashboard</h2>
    </x-slot>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
        <!-- Total Users Card -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Total Users</p>
                        <p class="text-3xl font-bold text-gray-900 mt-2">{{ \App\Models\User::count() }}</p>
                    </div>
                    <div class="bg-indigo-100 rounded-full p-3">
                        <i class="fi fi-rs-users text-2xl text-indigo-600"></i>
                    </div>
                </div>
                <div class="mt-4 flex items-center text-sm">
                    <span class="text-gray-500">Administrator: {{ \App\Models\User::where('role', 'administrator')->count() }}</span>
                    <span class="mx-2 text-gray-400">|</span>
                    <span class="text-gray-500">Operator: {{ \App\Models\User::where('role', 'operator')->count() }}</span>
                </div>
            </div>
        </div>

        <!-- Total Products Card -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Total Produk</p>
                        <p class="text-3xl font-bold text-gray-900 mt-2">{{ \App\Models\Produk::count() }}</p>
                    </div>
                    <div class="bg-green-100 rounded-full p-3">
                        <i class="fi fi-rs-box text-2xl text-green-600"></i>
                    </div>
                </div>
                <div class="mt-4 flex items-center text-sm">
                    <span class="text-green-600 font-medium">
                        <i class="fi fi-rs-check-circle text-xs"></i> Aktif
                    </span>
                </div>
            </div>
        </div>

        <!-- Total Stock Card -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Total Stok</p>
                        <p class="text-3xl font-bold text-gray-900 mt-2">{{ number_format(\App\Models\Produk::sum('stock')) }}</p>
                    </div>
                    <div class="bg-blue-100 rounded-full p-3">
                        <i class="fi fi-rs-boxes text-2xl text-blue-600"></i>
                    </div>
                </div>
                <div class="mt-4 flex items-center text-sm">
                    <span class="text-gray-500">Unit produk tersedia</span>
                </div>
            </div>
        </div>

        <!-- Total Value Card -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Total Nilai</p>
                        <p class="text-3xl font-bold text-gray-900 mt-2">Rp {{ number_format(\App\Models\Produk::sum(\DB::raw('price * stock')), 0, ',', '.') }}</p>
                    </div>
                    <div class="bg-yellow-100 rounded-full p-3">
                        <i class="fi fi-rs-sack-dollar text-2xl text-yellow-600"></i>
                    </div>
                </div>
                <div class="mt-4 flex items-center text-sm">
                    <span class="text-gray-500">Nilai inventori</span>
                </div>
            </div>
        </div>
    </div>


    <!-- Recent Activity Section -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Recent Products -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-800">Produk Terbaru</h3>
            </div>
            <div class="p-6">
                @php
                    $recentProducts = \App\Models\Produk::latest()->take(5)->get();
                @endphp
                
                @if($recentProducts->count() > 0)
                    <div class="space-y-4">
                        @foreach($recentProducts as $product)
                            <div class="flex items-center justify-between py-2 border-b border-gray-100 last:border-0">
                                <div class="flex items-center space-x-3">
                                    @if($product->image)
                                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-10 h-10 rounded object-cover">
                                    @else
                                        <div class="w-10 h-10 bg-gray-200 rounded flex items-center justify-center">
                                            <i class="fi fi-rs-box text-gray-400"></i>
                                        </div>
                                    @endif
                                    <div>
                                        <p class="font-medium text-gray-900">{{ $product->name }}</p>
                                        <p class="text-sm text-gray-500">Stok: {{ $product->stock }}</p>
                                    </div>
                                </div>
                                <span class="text-sm font-semibold text-indigo-600">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                            </div>
                        @endforeach
                    </div>
                    <a href="{{ route('produk.index') }}" class="block mt-4 text-center text-sm text-indigo-600 hover:text-indigo-800 font-medium">
                        Lihat Semua Produk →
                    </a>
                @else
                    <div class="text-center py-8 text-gray-500">
                        <i class="fi fi-rs-box text-4xl mb-2"></i>
                        <p>Belum ada produk</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- System Info -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-800">Informasi Sistem</h3>
            </div>
            <div class="p-6">
                <div class="space-y-4">
                    <div class="flex items-center justify-between py-3 border-b border-gray-100">
                        <div class="flex items-center space-x-3">
                            <div class="bg-indigo-100 rounded-full p-2">
                                <i class="fi fi-rs-laptop text-indigo-600"></i>
                            </div>
                            <span class="text-gray-700">Laravel Version</span>
                        </div>
                        <span class="font-semibold text-gray-900">{{ app()->version() }}</span>
                    </div>
                    
                    <div class="flex items-center justify-between py-3 border-b border-gray-100">
                        <div class="flex items-center space-x-3">
                            <div class="bg-green-100 rounded-full p-2">
                                <i class="fi fi-rs-code-simple text-green-600"></i>
                            </div>
                            <span class="text-gray-700">PHP Version</span>
                        </div>
                        <span class="font-semibold text-gray-900">{{ phpversion() }}</span>
                    </div>
                    
                    <div class="flex items-center justify-between py-3 border-b border-gray-100">
                        <div class="flex items-center space-x-3">
                            <div class="bg-blue-100 rounded-full p-2">
                                <i class="fi fi-rs-database text-blue-600"></i>
                            </div>
                            <span class="text-gray-700">Database</span>
                        </div>
                        <span class="font-semibold text-gray-900">{{ config('database.default') }}</span>
                    </div>
                    
                    <div class="flex items-center justify-between py-3">
                        <div class="flex items-center space-x-3">
                            <div class="bg-purple-100 rounded-full p-2">
                                <i class="fi fi-rs-shield-check text-purple-600"></i>
                            </div>
                            <span class="text-gray-700">Environment</span>
                        </div>
                        <span class="font-semibold text-gray-900">{{ app()->environment() }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        // Update current time
        function updateTime() {
            const now = new Date();
            const hours = String(now.getHours()).padStart(2, '0');
            const minutes = String(now.getMinutes()).padStart(2, '0');
            const seconds = String(now.getSeconds()).padStart(2, '0');
            document.getElementById('current-time').textContent = `${hours}:${minutes}:${seconds}`;
        }
        
        updateTime();
        setInterval(updateTime, 1000);
    </script>
    @endpush
</x-app-layout>
