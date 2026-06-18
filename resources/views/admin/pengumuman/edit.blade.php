<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <a href="{{ route('admin.pengumuman.index') }}"
                class="text-lg text-emerald-600 hover:text-emerald-900 font-medium">
                &larr;
            </a>
            <h2 class="font-bold text-xl text-gray-800 leading-tight">
                {{ __('Edit Pengumuman') }}
            </h2>
        </div>
    </x-slot>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-10">
        <div class="lg:col-span-1">
            <div class="bg-emerald-50 border border-emerald-100 rounded-xl p-6 shadow-sm">
                <h3 class="text-emerald-800 font-bold text-lg mb-3 flex items-center">
                    <i class="fi fi-rs-info mr-2"></i> Status Publikasi
                </h3>
                <p class="text-sm text-emerald-700 leading-relaxed">
                    Jika status ditampilkan, pengumuman ini terlihat oleh semua peserta. Jika tidak, pengumuman menjadi draft.
                </p>
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

                <form action="{{ route('admin.pengumuman.update', $pengumuman->id) }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <div>
                        <label for="judul" class="block text-sm font-bold text-gray-700 mb-1">
                            Judul Pengumuman <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="judul" id="judul" value="{{ old('judul', $pengumuman->judul) }}"
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
                            required>{{ old('keterangan', $pengumuman->keterangan) }}</textarea>
                        @error('keterangan')
                            <p class="mt-1 text-xs text-red-600 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <label class="inline-flex items-center gap-2 text-sm text-gray-700">
                        <input type="checkbox" name="is_published" value="1" class="rounded border-gray-300 text-emerald-600 focus:ring-emerald-500" @checked(old('is_published', $pengumuman->is_published))>
                        Tampilkan ke semua peserta
                    </label>

                    <div class="flex justify-end pt-4 border-t border-gray-100">
                        <button type="submit"
                            class="inline-flex justify-center items-center py-3 px-6 border border-transparent shadow-sm text-sm font-medium rounded-lg text-white bg-emerald-600 hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 transition-colors">
                            <i class="fi fi-rs-disk mr-2"></i> Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
