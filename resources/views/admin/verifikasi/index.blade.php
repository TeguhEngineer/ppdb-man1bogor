<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-gray-800 leading-tight">
            {{ __('Data Pendaftar') }}
        </h2>
    </x-slot>


    <div class="bg-white overflow-hidden shadow-sm rounded-xl border border-gray-100 mb-6">
        <div class="p-6 md:p-8 text-gray-900">
            <!-- Action Row: Export Buttons (Left) & Search/Filter (Right) -->
            <div class="mb-6 flex flex-col md:flex-row justify-between items-end gap-4">
                <!-- Export Buttons & Quota Setting -->
                <div class="flex flex-wrap gap-2">
                    <a href="{{ route('admin.verifikasi.export', ['type' => 'csv', 'status' => request('status')]) }}"
                        class="inline-flex items-center px-4 py-2 bg-emerald-100 text-emerald-700 font-bold rounded-lg border border-emerald-200 hover:bg-emerald-200 transition-colors text-sm">
                        <i class="fi fi-rs-file-csv mr-2"></i> Export CSV
                    </a>
                    <a href="{{ route('admin.verifikasi.export', ['type' => 'excel', 'status' => request('status')]) }}"
                        class="inline-flex items-center px-4 py-2 bg-blue-100 text-blue-700 font-bold rounded-lg border border-blue-200 hover:bg-blue-200 transition-colors text-sm">
                        <i class="fi fi-rs-file-excel mr-2"></i> Export Excel
                    </a>
                </div>

                <!-- Search & Filter -->
                <form method="GET" action="{{ route('admin.verifikasi.index') }}"
                    class="flex flex-col md:flex-row gap-2 w-full md:w-auto">
                    <div class="relative">
                        <input type="text" name="search" value="{{ request('search') }}"
                            placeholder="Cari nama, NISN..."
                            class="w-full md:w-64 rounded-lg border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 pl-10 text-sm">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fi fi-rs-search text-gray-400"></i>
                        </div>
                    </div>
                    <select name="status"
                        class="rounded-lg border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 text-sm"
                        onchange="this.form.submit()">
                        <option value="">Semua Status</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="verifikasi" {{ request('status') == 'verifikasi' ? 'selected' : '' }}>Verifikasi
                        </option>
                        <option value="tes" {{ request('status') == 'tes' ? 'selected' : '' }}>Tes/Wawancara</option>
                        <option value="lulus" {{ request('status') == 'lulus' ? 'selected' : '' }}>Lulus</option>
                        <option value="tidak_lulus" {{ request('status') == 'tidak_lulus' ? 'selected' : '' }}>Tidak Lulus
                        </option>
                    </select>
                    <button type="submit"
                        class="bg-gray-800 hover:bg-gray-900 text-white font-medium py-2 px-4 rounded-lg transition-colors text-sm">
                        Filter
                    </button>
                </form>
            </div>

            <div class="overflow-x-auto">
                <table id="pendaftar-table" class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50 border-b border-gray-200 text-sm text-gray-600">
                            <th class="p-4 font-semibold">No. Pendaftaran</th>
                            <th class="p-4 font-semibold">Nama Peserta</th>
                            <th class="p-4 font-semibold">Jalur</th>
                            <th class="p-4 font-semibold text-center">Data</th>
                            <th class="p-4 font-semibold text-center">Status Berkas</th>
                            <th class="p-4 font-semibold text-center">Status</th>
                            <th class="p-4 font-semibold text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="text-sm divide-y divide-gray-100">
                        @forelse($pendaftarans as $pendaftaran)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="p-4 font-mono text-xs text-gray-700">{{ $pendaftaran->no_pendaftaran }}</td>
                                <td class="p-4">
                                    <p class="font-bold text-gray-800">{{ $pendaftaran->user->name }}</p>
                                    <p class="text-xs text-gray-500 mt-1">NISN: {{ $pendaftaran->nisn ?? '-' }}</p>
                                </td>
                                <td class="p-4 text-gray-600">{{ $pendaftaran->jalur->nama_jalur }}</td>
                                <td class="p-4 text-center">
                                    <div class="flex items-center justify-center gap-2">
                                        <span
                                            class="inline-flex items-center p-1.5 rounded-md {{ $pendaftaran->isBiodataLengkap() ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}"
                                            title="{{ $pendaftaran->isBiodataLengkap() ? 'Biodata Lengkap' : 'Biodata Belum Lengkap' }}">
                                            <i class="fi fi-rs-document"></i>
                                        </span>
                                        <span
                                            class="inline-flex items-center p-1.5 rounded-md {{ $pendaftaran->isBerkasLengkap() ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}"
                                            title="{{ $pendaftaran->isBerkasLengkap() ? 'Berkas Lengkap' : 'Berkas Belum Lengkap' }}">
                                            <i class="fi fi-rs-folder-upload"></i>
                                        </span>
                                    </div>
                                </td>
                                <td class="p-4 text-center">
                                    @php
                                        $berkasStatus = optional($pendaftaran->berkas)->status_berkas;
                                        $berkasBadge = [
                                            'terima' => 'bg-green-100 text-green-800',
                                            'tolak' => 'bg-red-100 text-red-800',
                                            null => 'bg-gray-100 text-gray-700',
                                        ];
                                        $berkasLabel = [
                                            'terima' => 'Diterima',
                                            'tolak' => 'Ditolak',
                                            null => 'Belum Diverifikasi',
                                        ];
                                    @endphp
                                    <div class="space-y-2">
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold {{ $berkasBadge[$berkasStatus] }}">
                                            {{ $berkasLabel[$berkasStatus] }}
                                        </span>
                                        @if($pendaftaran->berkas && $pendaftaran->berkas->pesan)
                                            <p class="text-[11px] text-gray-500 leading-snug">
                                                {{ $pendaftaran->berkas->pesan }}
                                            </p>
                                        @endif
                                        @if(!$pendaftaran->berkas)
                                            <span class="text-xs text-gray-400">Belum ada berkas</span>
                                        @endif
                                    </div>
                                </td>
                                <td class="p-4 text-center">
                                    @php
                                        $statusColors = [
                                            'pending' => 'bg-yellow-100 text-yellow-800',
                                            'verifikasi' => 'bg-blue-100 text-blue-800',
                                            'tes' => 'bg-purple-100 text-purple-800',
                                            'lulus' => 'bg-green-100 text-green-800',
                                            'tidak_lulus' => 'bg-red-100 text-red-800',
                                        ];
                                        $statusLabels = [
                                            'pending' => 'Pending',
                                            'verifikasi' => 'Verifikasi',
                                            'tes' => 'Tes / Wawancara',
                                            'lulus' => 'Lulus',
                                            'tidak_lulus' => 'Tidak Lulus',
                                        ];
                                    @endphp
                                    <span
                                        class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold {{ $statusColors[$pendaftaran->status_pendaftaran] }}">
                                        {{ $statusLabels[$pendaftaran->status_pendaftaran] }}
                                    </span>
                                </td>
                                <td class="p-4 text-right">
                                    <a href="{{ route('admin.verifikasi.show', $pendaftaran->id) }}"
                                        class="inline-flex items-center justify-center bg-white hover:bg-gray-50 text-emerald-600 font-medium border border-gray-200 px-3 py-1.5 rounded-md shadow-sm transition-colors text-xs">
                                        <i class="fi fi-rs-eye mr-1.5"></i> Detail
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr class="bg-white text-gray-500">
                                <td class="p-8 text-center font-medium">Tidak ada data pendaftar.</td>
                                <td class="p-8">&nbsp;</td>
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
                {{ $pendaftarans->links() }}
            </div>
        </div>
    </div>

    @push('js')
        <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
        <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
        <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
        <script>
            $(document).ready(function () {
                $('#pendaftar-table').DataTable({
                    "paging": false, // Handled by Laravel
                    "searching": false, // Handled by Laravel
                    "info": false,
                    "order": [], // Disable initial sort
                    "columnDefs": [
                        { "orderable": false, "targets": [3, 4, 6] }
                    ],
                    "language": {
                        "emptyTable": "Tidak ada data yang tersedia"
                    }
                });
            });
        </script>
    @endpush

</x-app-layout>
