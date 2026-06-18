<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-gray-800 leading-tight">
            {{ __('Report') }}
        </h2>
    </x-slot>

    @php
        $statusColors = [
            'pending' => 'yellow',
            'verifikasi' => 'blue',
            'tes' => 'purple',
            'lulus' => 'green',
            'tidak_lulus' => 'red',
        ];
    @endphp

    <div class="bg-white overflow-hidden shadow-sm rounded-xl border border-gray-100 mb-6">
        <div class="p-6 md:p-8 text-gray-900">
            <div class="flex flex-col lg:flex-row lg:items-end lg:justify-between gap-4 mb-6">
                <div>
                    <h3 class="text-lg font-bold text-gray-900">Laporan Data Pendaftaran</h3>
                    <p class="text-sm text-gray-500 mt-1">Filter data berdasarkan status pendaftaran peserta.</p>
                </div>

                <form method="GET" action="{{ route('admin.report.index') }}" class="flex flex-col md:flex-row gap-2 w-full lg:w-auto">
                    <input type="hidden" name="print" value="1">
                    <div class="relative">
                        <input type="text" name="search" value="{{ request('search') }}"
                            placeholder="Cari nama, email, NISN, no pendaftaran..."
                            class="w-full md:w-72 rounded-lg border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 pl-10 text-sm">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fi fi-rs-search text-gray-400"></i>
                        </div>
                    </div>
                    <select name="status"
                        class="rounded-lg border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 text-sm">
                        <option value="">Semua Status</option>
                        @foreach($statusOptions as $statusKey => $statusLabel)
                            <option value="{{ $statusKey }}" @selected(request('status') === $statusKey)>{{ $statusLabel }}</option>
                        @endforeach
                    </select>
                    <button type="submit"
                        class="bg-emerald-600 hover:bg-emerald-700 text-white font-medium py-2 px-4 rounded-lg transition-colors text-sm">
                        <i class="fi fi-rs-print mr-1.5"></i> Cetak Report
                    </button>
                    @if(request()->hasAny(['status', 'search']))
                        <a href="{{ route('admin.report.index') }}"
                            class="bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium py-2 px-4 rounded-lg transition-colors text-sm text-center print:hidden">
                            Reset
                        </a>
                    @endif
                </form>
            </div>

            @if($isPrinting)
                <div class="mb-4 rounded-lg bg-gray-50 border border-gray-100 px-4 py-3 text-sm text-gray-600">
                    Menampilkan <strong>{{ $pendaftarans->total() }}</strong> data
                    @if(request('status') && isset($statusOptions[request('status')]))
                        dengan status <strong>{{ $statusOptions[request('status')] }}</strong>
                    @endif
                    @if(request('search'))
                        untuk pencarian <strong>"{{ request('search') }}"</strong>
                    @endif
                    .
                </div>
            @else
                <div class="mb-4 rounded-lg bg-yellow-50 border border-yellow-200 px-4 py-3 text-sm text-yellow-800">
                    Pilih status lalu klik <strong>Cetak Report</strong>. Data awal sengaja dikosongkan dan baru tampil setelah report dicetak.
                </div>
            @endif

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50 border-b border-gray-200 text-sm text-gray-600">
                            <th class="p-4 font-semibold">No Pendaftaran</th>
                            <th class="p-4 font-semibold">Peserta</th>
                            <th class="p-4 font-semibold">NISN</th>
                            <th class="p-4 font-semibold">Jalur</th>
                            <th class="p-4 font-semibold">Kampus</th>
                            <th class="p-4 font-semibold text-center">Status</th>
                            <th class="p-4 font-semibold">Tanggal Daftar</th>
                            <th class="p-4 font-semibold text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="text-sm divide-y divide-gray-100">
                        @forelse($pendaftarans as $pendaftaran)
                            @php
                                $color = $statusColors[$pendaftaran->status_pendaftaran] ?? 'gray';
                                $statusLabel = $statusOptions[$pendaftaran->status_pendaftaran] ?? ucfirst($pendaftaran->status_pendaftaran);
                            @endphp
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="p-4 font-mono text-xs text-gray-700">{{ $pendaftaran->no_pendaftaran }}</td>
                                <td class="p-4">
                                    <p class="font-bold text-gray-800">{{ $pendaftaran->biodata->nama_lengkap ?? $pendaftaran->user->name }}</p>
                                    <p class="text-xs text-gray-500 mt-1">{{ $pendaftaran->user->email }}</p>
                                </td>
                                <td class="p-4 text-gray-600">{{ $pendaftaran->nisn ?? '-' }}</td>
                                <td class="p-4 text-gray-600">{{ $pendaftaran->jalur->nama_jalur ?? '-' }}</td>
                                <td class="p-4 text-gray-600">{{ $pendaftaran->kampus ?? '-' }}</td>
                                <td class="p-4 text-center">
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-{{ $color }}-100 text-{{ $color }}-800">
                                        {{ $statusLabel }}
                                    </span>
                                </td>
                                <td class="p-4 text-gray-500">{{ $pendaftaran->created_at->format('d M Y H:i') }}</td>
                                <td class="p-4 text-right">
                                    <a href="{{ route('admin.verifikasi.show', $pendaftaran->id) }}"
                                        class="inline-flex items-center justify-center bg-white hover:bg-gray-50 text-emerald-600 font-medium border border-gray-200 px-3 py-1.5 rounded-md shadow-sm transition-colors text-xs">
                                        <i class="fi fi-rs-eye mr-1.5"></i> Detail
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="p-8 text-center text-gray-500">
                                    <i class="fi fi-rs-print text-3xl mb-3 block text-gray-300"></i>
                                    {{ $isPrinting ? 'Tidak ada data pendaftaran sesuai report.' : 'Data belum ditampilkan. Klik Cetak Report untuk menampilkan data.' }}
                                </td>
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

</x-app-layout>
