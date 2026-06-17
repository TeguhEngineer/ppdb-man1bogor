<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-gray-800 leading-tight">
            {{ __('Jalur Pendaftaran') }}
        </h2>
    </x-slot>

    <div class="bg-white overflow-hidden shadow-sm rounded-xl border border-gray-100 mb-6">
        <div class="p-6 md:p-8 text-gray-900">
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

            <!-- Action Row -->
            <div class="mb-6 flex flex-col md:flex-row justify-between items-end gap-4">
                <div class="flex flex-wrap gap-2">
                    <a href="{{ route('admin.jalur.create') }}"
                        class="inline-flex items-center px-4 py-2 bg-emerald-100 text-emerald-700 font-bold rounded-lg border border-emerald-200 hover:bg-emerald-200 transition-colors text-sm">
                        <i class="fi fi-rs-plus mr-2"></i> Tambah Jalur
                    </a>
                </div>
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
                                <td class="p-8 text-center font-medium">Belum ada data jalur pendaftaran.</td>
                                <td class="p-8">&nbsp;</td>
                                <td class="p-8">&nbsp;</td>
                                <td class="p-8">&nbsp;</td>
                                <td class="p-8">&nbsp;</td>
                                <td class="p-8">&nbsp;</td>
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
