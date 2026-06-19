@csrf

<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <div class="md:col-span-2">
        <label for="nama_jalur" class="block text-sm font-semibold text-gray-700 mb-2">Nama Jalur <span class="text-red-500">*</span></label>
        <input type="text" name="nama_jalur" id="nama_jalur"
            value="{{ old('nama_jalur', $jalur->nama_jalur ?? '') }}"
            class="w-full rounded-lg border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 text-sm"
            placeholder="Contoh: Reguler" required>
        @error('nama_jalur')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="total_kuota" class="block text-sm font-semibold text-gray-700 mb-2">Total Kuota <span class="text-red-500">*</span></label>
        <input type="number" name="total_kuota" id="total_kuota"
            value="{{ old('total_kuota', $jalur->total_kuota ?? 0) }}" min="0"
            class="w-full rounded-lg border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 text-sm"
            required>
        @isset($jalur)
            <p class="mt-1 text-xs text-gray-500">Pendaftar saat ini: {{ $jalur->pendaftarans_count ?? 0 }}</p>
        @endisset
        @error('total_kuota')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label class="block text-sm font-semibold text-gray-700 mb-2">Status Saat Ini</label>
        @isset($jalur)
            @php
                $status = $jalur->getStatus();
                $statusClass = [
                    'belum_dibuka' => 'bg-orange-100 text-orange-800 border-orange-200',
                    'terbuka' => 'bg-green-100 text-green-800 border-green-200',
                    'ditutup' => 'bg-red-100 text-red-800 border-red-200',
                ][$status];
                $statusLabel = [
                    'belum_dibuka' => 'Belum Dibuka',
                    'terbuka' => 'Terbuka',
                    'ditutup' => 'Ditutup',
                ][$status];
            @endphp
            <div class="inline-flex items-center px-3 py-2 rounded-lg border text-sm font-semibold {{ $statusClass }}">
                {{ $statusLabel }}
            </div>
        @else
            <div class="inline-flex items-center px-3 py-2 rounded-lg border text-sm font-semibold bg-gray-100 text-gray-700 border-gray-200">
                Mengikuti jadwal setelah disimpan
            </div>
        @endisset
    </div>

    <div>
        <label for="tgl_buka" class="block text-sm font-semibold text-gray-700 mb-2">Tanggal Buka</label>
        <input type="datetime-local" name="tgl_buka" id="tgl_buka"
            value="{{ old('tgl_buka', isset($jalur) && $jalur->tgl_buka ? $jalur->tgl_buka->format('Y-m-d\TH:i') : '') }}"
            class="w-full rounded-lg border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 text-sm">
        @error('tgl_buka')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="tgl_tutup" class="block text-sm font-semibold text-gray-700 mb-2">Tanggal Tutup</label>
        <input type="datetime-local" name="tgl_tutup" id="tgl_tutup"
            value="{{ old('tgl_tutup', isset($jalur) && $jalur->tgl_tutup ? $jalur->tgl_tutup->format('Y-m-d\TH:i') : '') }}"
            class="w-full rounded-lg border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 text-sm">
        @error('tgl_tutup')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div class="md:col-span-2">
        <label for="deskripsi" class="block text-sm font-semibold text-gray-700 mb-2">Deskripsi</label>
        <textarea name="deskripsi" id="deskripsi" rows="4"
            class="w-full rounded-lg border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 text-sm"
            placeholder="Deskripsi singkat jalur pendaftaran">{{ old('deskripsi', $jalur->deskripsi ?? '') }}</textarea>
        @error('deskripsi')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>
</div>

<div class="flex items-center justify-end gap-3 border-t pt-6 mt-8">
    <a href="{{ route('admin.pengaturan-sistem.index') }}"
        class="inline-flex items-center px-4 py-2 rounded-lg border border-gray-300 bg-white text-sm font-semibold text-gray-700 hover:bg-gray-50 transition-colors">
        Batal
    </a>
    <button type="submit"
        class="inline-flex items-center px-4 py-2 rounded-lg bg-emerald-600 text-sm font-semibold text-white hover:bg-emerald-700 transition-colors">
        Simpan
    </button>
</div>
