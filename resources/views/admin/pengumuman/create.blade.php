<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <a href="{{ route('admin.pengumuman.index') }}"
                class="text-lg text-emerald-600 hover:text-emerald-900 font-medium">
                &larr;
            </a>
            <h2 class="font-bold text-xl text-gray-800 leading-tight">
                {{ __('Kirim Pengumuman Peserta') }}
            </h2>

        </div>
    </x-slot>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-10">

        <!-- Info Panel -->
        <div class="lg:col-span-1 space-y-6">
            <div class="bg-emerald-50 border border-emerald-100 rounded-xl p-6 shadow-sm">
                <h3 class="text-emerald-800 font-bold text-lg mb-3 flex items-center">
                    <i class="fi fi-rs-info mr-2"></i> Petunjuk Siaran
                </h3>
                <ul class="text-sm text-emerald-700 space-y-3 leading-relaxed">
                    <li><strong class="font-bold block">1. Pilih Target</strong> Tentukan kelompok peserta mana yang
                        akan menerima pesan ini berdasarkan status pendaftarannya.</li>
                    <li><strong class="font-bold block">2. Broadcast Massal</strong> Sistem akan menduplikat pesan
                        secara otomatis ke semua akun yang cocok dengan target.</li>
                </ul>
            </div>
        </div>

        <!-- Form Panel -->
        <div class="lg:col-span-2">
            <div class="bg-white overflow-hidden shadow-sm rounded-xl border border-gray-100 p-6 md:p-8">

                @if ($errors->any())
                    <div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative text-sm"
                        role="alert">
                        <strong class="font-bold">Ada kesalahan pengisian:</strong>
                        <ul class="mt-1 list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if (session('error'))
                    <div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative text-sm"
                        role="alert">
                        <strong class="font-bold"><i class="fi fi-rs-exclamation mr-1"></i> Gagal!</strong>
                        <span class="block sm:inline">{{ session('error') }}</span>
                    </div>
                @endif

                <form action="{{ route('admin.pengumuman.store') }}" method="POST" class="space-y-6">
                    @csrf

                    <div class="grid grid-cols-1 gap-6">
                        <!-- Target Status Pendaftaran -->
                        <div>
                            <label for="target_status" class="block text-sm font-bold text-gray-700 mb-1">Target Peserta
                                <span class="text-red-500">*</span></label>
                            <p class="text-xs text-gray-500 mb-2">Pilih target penerima pesan ini.</p>
                            <select name="target_status" id="target_status"
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500"
                                required>
                                <option value="semua" {{ old('target_status') == 'semua' ? 'selected' : '' }}>Semua
                                    Peserta</option>
                                <option value="pending" {{ old('target_status') == 'pending' ? 'selected' : '' }}>Status
                                    Pendaftaran: Pending</option>
                                <option value="verifikasi" {{ old('target_status') == 'verifikasi' ? 'selected' : '' }}>
                                    Status Pendaftaran: Verifikasi</option>
                                <option value="tes" {{ old('target_status') == 'tes' ? 'selected' : '' }}>Status
                                    Pendaftaran: Tes/Wawancara</option>
                                <option value="lulus" {{ old('target_status') == 'lulus' ? 'selected' : '' }}>Status
                                    Pendaftaran: Lulus</option>
                                <option value="tidak_lulus" {{ old('target_status') == 'tidak_lulus' ? 'selected' : '' }}>
                                    Status Pendaftaran: Tidak Lulus</option>
                                <option value="personal" {{ old('target_status') == 'personal' ? 'selected' : '' }}>Personal (Kirim ke 1 Peserta)</option>
                            </select>
                        </div>

                        <!-- Search Participant (Hidden by default) -->
                        <div id="personal_search_container" class="{{ old('target_status') == 'personal' ? '' : 'hidden' }} mt-4">
                            <label for="participant_search" class="block text-sm font-bold text-gray-700 mb-1">Cari Peserta <span class="text-red-500">*</span></label>
                            <div class="relative">
                                <input type="text" id="participant_search" autocomplete="off" placeholder="Ketik Nama atau No. Pendaftaran..."
                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500">
                                <input type="hidden" name="pendaftaran_id" id="pendaftaran_id" value="{{ old('pendaftaran_id') }}">
                                
                                <!-- Search Results Dropdown -->
                                <div id="search_results" class="absolute z-50 w-full mt-1 bg-white border border-gray-200 rounded-md shadow-lg hidden max-h-60 overflow-y-auto">
                                    <!-- Results will be injected here -->
                                </div>
                            </div>
                            <p id="selected_participant_text" class="mt-2 text-sm text-emerald-600 font-medium {{ old('pendaftaran_id') ? '' : 'hidden' }}">
                                Terpilih: <span id="participant_name"></span>
                            </p>
                        </div>
                    </div>

                    <!-- Judul Pengumuman -->
                    <div class="mt-6">
                        <label for="judul" class="block text-sm font-bold text-gray-700 mb-1">Judul Pengumuman <span
                                class="text-red-500">*</span></label>
                        <input type="text" name="judul" id="judul" value="{{ old('judul') }}"
                            placeholder="Contoh: Pengumuman Hasil Seleksi Tahap I"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500"
                            required>
                    </div>

                    <!-- Isi Pengumuman -->
                    <div class="mt-6">
                        <label for="keterangan" class="block text-sm font-bold text-gray-700 mb-1">Isi Pesan /
                            Keterangan <span class="text-red-500">*</span></label>
                        <p class="text-xs text-gray-500 mb-2">Tuliskan instruksi atau pesan lengkap di sini.</p>
                        <textarea name="keterangan" id="keterangan" rows="8"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500"
                            placeholder="Tulis pengumuman Anda di sini..." required>{{ old('keterangan') }}</textarea>
                    </div>

                    <div class="flex justify-end pt-4 border-t border-gray-100">
                        <button type="submit"
                            class="inline-flex justify-center items-center py-3 px-6 border border-transparent shadow-sm text-sm font-medium rounded-lg text-white bg-emerald-600 hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 transition-colors"
                            onclick="return confirm('Pengumuman ini akan dikirimkan. Lanjutkan?');">
                            <i class="fi fi-rs-paper-plane mr-2"></i> Kirim Pengumuman
                        </button>
                    </div>
                </form>

            </div>
        </div>

    </div>

    @push('js')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const targetStatus = document.getElementById('target_status');
            const personalSearchContainer = document.getElementById('personal_search_container');
            const participantSearch = document.getElementById('participant_search');
            const searchResults = document.getElementById('search_results');
            const pendaftaranId = document.getElementById('pendaftaran_id');
            const selectedParticipantText = document.getElementById('selected_participant_text');
            const participantName = document.getElementById('participant_name');

            // Toggle Personal Search field
            targetStatus.addEventListener('change', function() {
                if (this.value === 'personal') {
                    personalSearchContainer.classList.remove('hidden');
                } else {
                    personalSearchContainer.classList.add('hidden');
                    pendaftaranId.value = '';
                    selectedParticipantText.classList.add('hidden');
                }
            });

            // AJAX Search
            let debounceTimer;
            participantSearch.addEventListener('input', function() {
                clearTimeout(debounceTimer);
                const query = this.value;

                if (query.length < 2) {
                    searchResults.classList.add('hidden');
                    return;
                }

                debounceTimer = setTimeout(() => {
                    fetch(`{{ route('admin.pengumuman.search') }}?q=${query}`)
                        .then(response => response.json())
                        .then(data => {
                            searchResults.innerHTML = '';
                            if (data.length > 0) {
                                data.forEach(item => {
                                    const div = document.createElement('div');
                                    div.className = 'px-4 py-2 hover:bg-emerald-50 cursor-pointer text-sm border-b last:border-0';
                                    div.textContent = item.text;
                                    div.addEventListener('click', () => {
                                        pendaftaranId.value = item.id;
                                        participantSearch.value = item.text;
                                        participantName.textContent = item.text;
                                        selectedParticipantText.classList.remove('hidden');
                                        searchResults.classList.add('hidden');
                                    });
                                    searchResults.appendChild(div);
                                });
                                searchResults.classList.remove('hidden');
                            } else {
                                searchResults.innerHTML = '<div class="px-4 py-2 text-sm text-gray-500">Tidak ada hasil ditemukan</div>';
                                searchResults.classList.remove('hidden');
                            }
                        });
                }, 300);
            });

            // Close results on outside click
            document.addEventListener('click', function(e) {
                if (!personalSearchContainer.contains(e.target)) {
                    searchResults.classList.add('hidden');
                }
            });
        });
    </script>
    @endpush
</x-app-layout>
