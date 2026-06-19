<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-gray-800 leading-tight">
            {{ __('Pengaturan Sistem') }}
        </h2>
    </x-slot>

    @if (session('success'))
        <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg text-sm" role="alert">
            <strong class="font-bold">Berhasil!</strong>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    @if (session('error'))
        <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg text-sm" role="alert">
            <strong class="font-bold">Gagal!</strong>
            <span>{{ session('error') }}</span>
        </div>
    @endif

    <div class="bg-white overflow-hidden shadow-sm rounded-xl border border-gray-100 mb-6">
        <form action="{{ route('admin.pengaturan-sistem.skl.update') }}" method="POST" enctype="multipart/form-data" class="p-6 md:p-8">
            @csrf
            @method('PUT')

            <div class="flex flex-col md:flex-row md:items-start md:justify-between gap-4 mb-6">
                <div>
                    <h3 class="text-lg font-bold text-gray-800">Pengaturan Surat Keterangan Lulus</h3>
                    <p class="text-sm text-gray-500 mt-1">Data ini dipakai pada cetak Surat Keterangan Kelulusan Seleksi peserta.</p>
                </div>
                <button type="submit"
                    class="inline-flex items-center justify-center px-4 py-2 bg-emerald-600 text-white font-bold rounded-lg hover:bg-emerald-700 transition-colors text-sm">
                    <i class="fi fi-rs-disk mr-2"></i> Simpan Pengaturan SKL
                </button>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="skl_agenda_tanggal" class="block text-sm font-semibold text-gray-700 mb-2">Hari, Tanggal <span class="text-red-500">*</span></label>
                    <input type="text" name="skl_agenda_tanggal" id="skl_agenda_tanggal"
                        value="{{ old('skl_agenda_tanggal', $sklSettings['skl_agenda_tanggal']) }}"
                        class="w-full rounded-lg border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 text-sm"
                        placeholder="Contoh: Rabu, 20 Mei 2026" required>
                    @error('skl_agenda_tanggal')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="skl_agenda_waktu" class="block text-sm font-semibold text-gray-700 mb-2">Waktu <span class="text-red-500">*</span></label>
                    <input type="text" name="skl_agenda_waktu" id="skl_agenda_waktu"
                        value="{{ old('skl_agenda_waktu', $sklSettings['skl_agenda_waktu']) }}"
                        class="w-full rounded-lg border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 text-sm"
                        placeholder="Contoh: 08.00 - 09.30 WIB" required>
                    @error('skl_agenda_waktu')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="skl_agenda_tempat" class="block text-sm font-semibold text-gray-700 mb-2">Tempat <span class="text-red-500">*</span></label>
                    <input type="text" name="skl_agenda_tempat" id="skl_agenda_tempat"
                        value="{{ old('skl_agenda_tempat', $sklSettings['skl_agenda_tempat']) }}"
                        class="w-full rounded-lg border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 text-sm"
                        placeholder="Contoh: MAN 1 BOGOR" required>
                    @error('skl_agenda_tempat')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="skl_agenda_keperluan" class="block text-sm font-semibold text-gray-700 mb-2">Keperluan <span class="text-red-500">*</span></label>
                    <input type="text" name="skl_agenda_keperluan" id="skl_agenda_keperluan"
                        value="{{ old('skl_agenda_keperluan', $sklSettings['skl_agenda_keperluan']) }}"
                        class="w-full rounded-lg border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 text-sm"
                        placeholder="Contoh: Rapat Sosialisasi Program MAN 1 Bogor" required>
                    @error('skl_agenda_keperluan')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="skl_ttd_tempat_tanggal" class="block text-sm font-semibold text-gray-700 mb-2">Tempat & Tanggal Tanda Tangan <span class="text-red-500">*</span></label>
                    <input type="text" name="skl_ttd_tempat_tanggal" id="skl_ttd_tempat_tanggal"
                        value="{{ old('skl_ttd_tempat_tanggal', $sklSettings['skl_ttd_tempat_tanggal']) }}"
                        class="w-full rounded-lg border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 text-sm"
                        placeholder="Contoh: Bogor, 19 Juni 2026"
                        required>
                    @error('skl_ttd_tempat_tanggal')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="skl_ketua_panitia" class="block text-sm font-semibold text-gray-700 mb-2">Ketua Panitia <span class="text-red-500">*</span></label>
                    <input type="text" name="skl_ketua_panitia" id="skl_ketua_panitia"
                        value="{{ old('skl_ketua_panitia', $sklSettings['skl_ketua_panitia']) }}"
                        class="w-full rounded-lg border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 text-sm"
                        placeholder="Contoh: WAHYU MULYADIN, SP, MM" required>
                    @error('skl_ketua_panitia')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="skl_nip_ketua_panitia" class="block text-sm font-semibold text-gray-700 mb-2">NIP Ketua Panitia <span class="text-red-500">*</span></label>
                    <input type="text" name="skl_nip_ketua_panitia" id="skl_nip_ketua_panitia"
                        value="{{ old('skl_nip_ketua_panitia', $sklSettings['skl_nip_ketua_panitia']) }}"
                        class="w-full rounded-lg border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 text-sm"
                        placeholder="Contoh: 196806221999031003" required>
                    @error('skl_nip_ketua_panitia')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="md:col-span-2">
                    <label for="skl_tanda_tangan_ketua_panitia" class="block text-sm font-semibold text-gray-700 mb-2">Tanda Tangan Ketua Panitia</label>
                    <div class="grid grid-cols-1 md:grid-cols-[220px,1fr] gap-4 items-start">
                        <div class="rounded-lg border border-dashed border-gray-300 bg-gray-50 p-4 min-h-28 flex items-center justify-center">
                            @if(!empty($sklSettings['skl_tanda_tangan_ketua_panitia']))
                                <img src="{{ Storage::url($sklSettings['skl_tanda_tangan_ketua_panitia']) }}"
                                    alt="Tanda tangan ketua panitia"
                                    class="max-h-24 max-w-full object-contain">
                            @else
                                <span class="text-xs text-gray-500 text-center">Belum ada tanda tangan</span>
                            @endif
                        </div>
                        <div>
                            <input type="file" name="skl_tanda_tangan_ketua_panitia" id="skl_tanda_tangan_ketua_panitia"
                                class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100"
                                accept="image/png,image/jpeg,image/webp">
                            <p class="mt-2 text-xs text-gray-500">Format PNG/JPG/JPEG/WEBP, maksimal 1 MB. Disarankan gambar tanda tangan dengan background transparan.</p>
                            @error('skl_tanda_tangan_ketua_panitia')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <div class="bg-white overflow-hidden shadow-sm rounded-xl border border-gray-100 mb-6">
        <div class="p-6 md:p-8 text-gray-900">
            <div class="mb-6 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                <div>
                    <h3 class="text-lg font-bold text-gray-800">Jalur Pendaftaran</h3>
                    <p class="text-sm text-gray-500 mt-1">Kelola jalur pendaftaran, kuota, deskripsi, dan jadwal buka/tutup.</p>
                </div>
                <a href="{{ route('admin.jalur.create') }}"
                    class="inline-flex items-center px-4 py-2 bg-emerald-100 text-emerald-700 font-bold rounded-lg border border-emerald-200 hover:bg-emerald-200 transition-colors text-sm">
                    <i class="fi fi-rs-plus mr-2"></i> Tambah Jalur
                </a>
            </div>

            <div class="overflow-x-auto">
                <table id="jalur-table" class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50 border-b border-gray-200 text-sm text-gray-600">
                            <th class="p-4 font-semibold">Nama Jalur</th>
                            <th class="p-4 font-semibold text-center">Kuota</th>
                            <th class="p-4 font-semibold text-center">Pendaftar</th>
                            <th class="p-4 font-semibold">Jadwal</th>
                            <th class="p-4 font-semibold text-center">Status</th>
                            <th class="p-4 font-semibold text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="text-sm divide-y divide-gray-100">
                        @forelse($jalurs as $jalur)
                            @php
                                $status = $jalur->getStatus();
                                $statusClass = [
                                    'belum_dibuka' => 'bg-orange-100 text-orange-800',
                                    'terbuka' => 'bg-green-100 text-green-800',
                                    'ditutup' => 'bg-red-100 text-red-800',
                                ][$status];
                                $statusLabel = [
                                    'belum_dibuka' => 'Belum Dibuka',
                                    'terbuka' => 'Terbuka',
                                    'ditutup' => 'Ditutup',
                                ][$status];
                            @endphp
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="p-4">
                                    <p class="font-bold text-gray-800">{{ $jalur->nama_jalur }}</p>
                                    <p class="text-xs text-gray-500 mt-1 line-clamp-2">{{ $jalur->deskripsi ?? 'Tidak ada deskripsi.' }}</p>
                                </td>
                                <td class="p-4 text-center font-semibold text-gray-800">{{ $jalur->total_kuota }}</td>
                                <td class="p-4 text-center">
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-800">
                                        {{ $jalur->pendaftarans_count }} peserta
                                    </span>
                                </td>
                                <td class="p-4 text-gray-600">
                                    <div class="space-y-1">
                                        <p><span class="font-medium">Buka:</span> {{ $jalur->getFormattedTglBuka() }}</p>
                                        <p><span class="font-medium">Tutup:</span> {{ $jalur->getFormattedTglTutup() }}</p>
                                    </div>
                                </td>
                                <td class="p-4 text-center">
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold {{ $statusClass }}">
                                        {{ $statusLabel }}
                                    </span>
                                </td>
                                <td class="p-4">
                                    <div class="flex items-center justify-end gap-2">
                                        <a href="{{ route('admin.jalur.edit', $jalur->id) }}"
                                            class="inline-flex items-center justify-center bg-white hover:bg-gray-50 text-emerald-600 font-medium border border-gray-200 px-3 py-1.5 rounded-md shadow-sm transition-colors text-xs">
                                            <i class="fi fi-rs-pencil mr-1.5"></i> Edit
                                        </a>
                                        <form action="{{ route('admin.jalur.destroy', $jalur->id) }}" method="POST"
                                            onsubmit="return confirm('Hapus jalur pendaftaran ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="inline-flex items-center justify-center bg-white hover:bg-red-50 text-red-600 font-medium border border-gray-200 px-3 py-1.5 rounded-md shadow-sm transition-colors text-xs {{ $jalur->pendaftarans_count > 0 ? 'opacity-50 cursor-not-allowed' : '' }}"
                                                {{ $jalur->pendaftarans_count > 0 ? 'disabled' : '' }}>
                                                <i class="fi fi-rs-trash mr-1.5"></i> Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr class="bg-white text-gray-500">
                                <td class="p-8 text-center font-medium" colspan="6">Belum ada data jalur pendaftaran.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-6">
                {{ $jalurs->links() }}
            </div>
        </div>
    </div>

    @push('js')
        <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
        <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
        <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
        <script>
            $(document).ready(function () {
                $('#jalur-table').DataTable({
                    "paging": false,
                    "searching": false,
                    "info": false,
                    "order": [],
                    "columnDefs": [
                        { "orderable": false, "targets": [5] }
                    ],
                    "language": {
                        "emptyTable": "Tidak ada data yang tersedia"
                    }
                });
            });
        </script>
    @endpush
</x-app-layout>
