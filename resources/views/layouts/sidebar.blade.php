<!-- Logo -->
<div class="flex items-center justify-between px-6 py-5">
    <div class="text-emerald-700 text-2xl font-bold flex items-center">
        <img src="{{ asset('logo.png') }}" alt="Logo" class="w-10 h-10 object-contain">
        <span class="ml-2 text-lg">PPDB MAN 1 BOGOR</span>
    </div>
    <button onclick="toggleSidebar()" class="md:hidden text-gray-600">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
        </svg>
    </button>
</div>

<nav class="mt-4 space-y-2">
    <!-- Dashboard -->
    <div class="flex items-center mr-4">
        @if (request()->is('dashboard*'))
            <div class="w-[5px] h-12 bg-emerald-700 rounded-r-md"></div>
        @endif

        <a href="/dashboard"
            class="flex items-center flex-1 px-4 py-3 {{ request()->is('dashboard*') ? 'bg-emerald-100 text-emerald-800' : 'text-gray-500 hover:bg-gray-50' }} rounded-lg ml-3">
            <i class="fi fi-rs-home text-lg leading-none relative top-0.5"></i>
            <span class="ml-3 font-medium">Dashboard</span>
        </a>
    </div>

    @if (Auth::user()->role === 'peserta')
        <!-- Menu Peserta -->
        <div class="flex items-center mr-4">
            @if (request()->is('biodata*'))
                <div class="w-[5px] h-12 bg-emerald-700 rounded-r-md"></div>
            @endif
            <a href="{{ route('biodata.create') }}"
                class="flex items-center flex-1 px-4 py-3 {{ request()->is('biodata*') ? 'bg-emerald-100 text-emerald-800' : 'text-gray-500 hover:bg-gray-50' }} rounded-lg ml-3">
                <i class="fi fi-rs-document text-lg leading-none relative top-0.5"></i>
                <span class="ml-3 font-medium">Isi Biodata</span>
            </a>
        </div>
        <div class="flex items-center mr-4">
            @if (request()->is('berkas*'))
                <div class="w-[5px] h-12 bg-emerald-700 rounded-r-md"></div>
            @endif
            <a href="{{ route('berkas.create') }}"
                class="flex items-center flex-1 px-4 py-3 {{ request()->is('berkas*') ? 'bg-emerald-100 text-emerald-800' : 'text-gray-500 hover:bg-gray-50' }} rounded-lg ml-3">
                <i class="fi fi-rs-folder-upload text-lg leading-none relative top-0.5"></i>
                <span class="ml-3 font-medium">Upload Berkas</span>
            </a>
        </div>
        <div class="flex items-center mr-4">
            @if (request()->is('pengumuman*'))
                <div class="w-[5px] h-12 bg-emerald-700 rounded-r-md"></div>
            @endif
            <a href="{{ route('pengumuman.index') }}"
                class="flex items-center flex-1 px-4 py-3 {{ request()->is('pengumuman*') ? 'bg-emerald-100 text-emerald-800' : 'text-gray-500 hover:bg-gray-50' }} rounded-lg ml-3">
                <i class="fi fi-rs-megaphone text-lg leading-none relative top-0.5"></i>
                <span class="ml-3 font-medium">Pengumuman</span>
            </a>
        </div>
    @elseif (Auth::user()->role === 'admin')
        <!-- Menu Admin -->
        <div class="flex items-center mr-4">
            @if (request()->is('admin/verifikasi*'))
                <div class="w-[5px] h-12 bg-emerald-700 rounded-r-md"></div>
            @endif
            <a href="{{ route('admin.verifikasi.index') }}"
                class="flex items-center flex-1 px-4 py-3 {{ request()->is('admin/verifikasi*') ? 'bg-emerald-100 text-emerald-800' : 'text-gray-500 hover:bg-gray-50' }} rounded-lg ml-3">
                <i class="fi fi-rs-users text-lg leading-none relative top-0.5"></i>
                <span class="ml-3 font-medium">Data Pendaftar</span>
            </a>
        </div>
        <div class="flex items-center mr-4">
            @if (request()->is('admin/pengumuman*'))
                <div class="w-[5px] h-12 bg-emerald-700 rounded-r-md"></div>
            @endif
            <a href="{{ route('admin.pengumuman.index') }}"
                class="flex items-center flex-1 px-4 py-3 {{ request()->is('admin/pengumuman*') ? 'bg-emerald-100 text-emerald-800' : 'text-gray-500 hover:bg-gray-50' }} rounded-lg ml-3">
                <i class="fi fi-rs-megaphone text-lg leading-none relative top-0.5"></i>
                <span class="ml-3 font-medium">Pengumuman</span>
            </a>
        </div>
    @endif
</nav>
