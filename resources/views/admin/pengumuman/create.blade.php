<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <a href="{{ route('admin.pengumuman.index') }}"
                class="text-lg text-emerald-600 hover:text-emerald-900 font-medium">
                &larr;
            </a>
            <h2 class="font-bold text-xl text-gray-800 leading-tight">
                {{ __('Buat Pengumuman Umum') }}
            </h2>
        </div>
    </x-slot>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-10">
        <div class="lg:col-span-1">
            <div class="bg-emerald-50 border border-emerald-100 rounded-xl p-6 shadow-sm">
                <h3 class="text-emerald-800 font-bold text-lg mb-3 flex items-center">
                    <i class="fi fi-rs-info mr-2"></i> Pengumuman Umum
                </h3>
                <ul class="text-sm text-emerald-700 space-y-3 leading-relaxed">
                    <li>Pengumuman dibuat satu kali dan tampil untuk semua peserta.</li>
                    <li>Tidak ada duplikasi data per peserta, sehingga lebih ringan saat jumlah pendaftar besar.</li>
                    <li>Setiap pengumuman yang disimpan otomatis tampil untuk semua peserta.</li>
                </ul>
            </div>
        </div>

        <div class="lg:col-span-2">
            <div class="bg-white overflow-hidden shadow-sm rounded-xl border border-gray-100 p-6 md:p-8">
                @if ($errors->any())
                    <div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative text-sm" role="alert">
                        <strong class="font-bold">Ada kesalahan pengisian:</strong>
                        <ul class="mt-1 list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('admin.pengumuman.store') }}" method="POST" class="space-y-6">
                    @csrf

                    <div>
                        <label for="judul" class="block text-sm font-bold text-gray-700 mb-1">
                            Judul Pengumuman <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="judul" id="judul" value="{{ old('judul') }}"
                            placeholder="Contoh: Pengumuman Jadwal Tes Seleksi"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500"
                            required>
                        @error('judul')
                            <p class="mt-1 text-xs text-red-600 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="keterangan" class="block text-sm font-bold text-gray-700 mb-1">
                            Isi Pengumuman <span class="text-red-500">*</span>
                        </label>
                        <textarea name="keterangan" id="keterangan" rows="8"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500"
                            placeholder="Tulis pengumuman Anda di sini..." required>{{ old('keterangan') }}</textarea>
                        @error('keterangan')
                            <p class="mt-1 text-xs text-red-600 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex justify-end pt-4 border-t border-gray-100">
                        <button type="submit"
                            class="inline-flex justify-center items-center py-3 px-6 border border-transparent shadow-sm text-sm font-medium rounded-lg text-white bg-emerald-600 hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 transition-colors"
                            onclick="return confirm('Simpan pengumuman ini?');">
                            <i class="fi fi-rs-disk mr-2"></i> Simpan Pengumuman
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
