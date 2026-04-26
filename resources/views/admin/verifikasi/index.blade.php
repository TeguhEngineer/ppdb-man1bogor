<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-gray-800 leading-tight">
            {{ __('Data Pendaftar') }}
        </h2>
    </x-slot>

    <div class="bg-white overflow-hidden shadow-sm rounded-xl border border-gray-100 mb-6">
        <div class="p-6 md:p-8 text-gray-900">
            <!-- Filter & Search -->
            <form method="GET" action="{{ route('admin.verifikasi.index') }}" class="mb-6 flex flex-col md:flex-row gap-4">
                <div class="flex-1">
                    <label for="search" class="sr-only">Cari</label>
                    <input type="text" name="search" id="search" value="{{ request('search') }}" placeholder="Cari nama, NISN, no pendaftaran..." class="w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500">
                </div>
                <div class="w-full md:w-64">
                    <label for="status" class="sr-only">Status</label>
                    <select name="status" id="status" class="w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500" onchange="this.form.submit()">
                        <option value="">Semua Status</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="verifikasi" {{ request('status') == 'verifikasi' ? 'selected' : '' }}>Verifikasi</option>
                        <option value="tes" {{ request('status') == 'tes' ? 'selected' : '' }}>Tes/Wawancara</option>
                        <option value="lulus" {{ request('status') == 'lulus' ? 'selected' : '' }}>Lulus</option>
                        <option value="tidak_lulus" {{ request('status') == 'tidak_lulus' ? 'selected' : '' }}>Tidak Lulus</option>
                    </select>
                </div>
                <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white font-medium py-2 px-4 rounded-md transition-colors">
                    Filter
                </button>
            </form>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50 border-b border-gray-200 text-sm text-gray-600">
                            <th class="p-4 font-semibold rounded-tl-lg">No. Pendaftaran</th>
                            <th class="p-4 font-semibold">Nama Peserta</th>
                            <th class="p-4 font-semibold">Jalur</th>
                            <th class="p-4 font-semibold text-center">Data</th>
                            <th class="p-4 font-semibold text-center">Status</th>
                            <th class="p-4 font-semibold rounded-tr-lg text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="text-sm divide-y divide-gray-100">
                        @forelse($pendaftarans as $pendaftaran)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="p-4 font-medium text-emerald-600">{{ $pendaftaran->no_pendaftaran }}</td>
                            <td class="p-4">
                                <p class="font-bold text-gray-800">{{ $pendaftaran->user->name }}</p>
                                <p class="text-xs text-gray-500 mt-1">NISN: {{ $pendaftaran->nisn ?? '-' }}</p>
                            </td>
                            <td class="p-4 text-gray-600">{{ $pendaftaran->jalur->nama_jalur }}</td>
                            <td class="p-4 text-center">
                                <div class="flex items-center justify-center gap-2">
                                    <span class="inline-flex items-center p-1.5 rounded-md {{ $pendaftaran->biodata ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}" title="{{ $pendaftaran->biodata ? 'Biodata Lengkap' : 'Biodata Belum Lengkap' }}">
                                        <i class="fi fi-rs-document"></i>
                                    </span>
                                    <span class="inline-flex items-center p-1.5 rounded-md {{ $pendaftaran->berkas ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}" title="{{ $pendaftaran->berkas ? 'Berkas Lengkap' : 'Berkas Belum Lengkap' }}">
                                        <i class="fi fi-rs-folder-upload"></i>
                                    </span>
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
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold {{ $statusColors[$pendaftaran->status_pendaftaran] }}">
                                    {{ $statusLabels[$pendaftaran->status_pendaftaran] }}
                                </span>
                            </td>
                            <td class="p-4 text-right">
                                <a href="{{ route('admin.verifikasi.show', $pendaftaran->id) }}" class="inline-flex items-center justify-center bg-white hover:bg-gray-50 text-emerald-600 font-medium border border-gray-200 px-3 py-1.5 rounded-md shadow-sm transition-colors text-xs">
                                    <i class="fi fi-rs-eye mr-1.5"></i> Detail
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="p-8 text-center text-gray-500">
                                <i class="fi fi-rs-sad text-3xl mb-3 block text-gray-300"></i>
                                Tidak ada data pendaftar yang ditemukan.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="mt-6">
                {{ $pendaftarans->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
