<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-bold text-gray-800">Dashboard Administrator</h2>
    </x-slot>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100 flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-500">Total Pendaftar</p>
                <p class="text-3xl font-bold text-gray-900 mt-1">{{ $totalPendaftar }}</p>
            </div>
            <div class="bg-blue-100 text-blue-600 p-4 rounded-full">
                <i class="fi fi-rs-users text-2xl"></i>
            </div>
        </div>
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100 flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-500">Pendaftar Hari Ini</p>
                <p class="text-3xl font-bold text-gray-900 mt-1">{{ $pendaftarBaru }}</p>
            </div>
            <div class="bg-emerald-100 text-emerald-600 p-4 rounded-full">
                <i class="fi fi-rs-user-add text-2xl"></i>
            </div>
        </div>
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100 flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-500">Menunggu Verifikasi</p>
                <p class="text-3xl font-bold text-gray-900 mt-1">{{ $menungguVerifikasi }}</p>
            </div>
            <div class="bg-yellow-100 text-yellow-600 p-4 rounded-full">
                <i class="fi fi-rs-time-check text-2xl"></i>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4 mb-8">
        <div class="bg-white rounded-xl shadow-sm p-4 border border-gray-100">
            <div class="flex items-center gap-3">
                <div class="bg-indigo-100 text-indigo-600 p-2.5 rounded-lg">
                    <i class="fi fi-rs-search text-xl"></i>
                </div>
                <div>
                    <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">Verifikasi</p>
                    <p class="text-xl font-bold text-gray-900">{{ $terverifikasi }}</p>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-xl shadow-sm p-4 border border-gray-100">
            <div class="flex items-center gap-3">
                <div class="bg-purple-100 text-purple-600 p-2.5 rounded-lg">
                    <i class="fi fi-rs-edit text-xl"></i>
                </div>
                <div>
                    <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">Tahap Tes</p>
                    <p class="text-xl font-bold text-gray-900">{{ $tahapTes }}</p>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-xl shadow-sm p-4 border border-gray-100">
            <div class="flex items-center gap-3">
                <div class="bg-green-100 text-green-600 p-2.5 rounded-lg">
                    <i class="fi fi-rs-check text-xl"></i>
                </div>
                <div>
                    <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">Lulus</p>
                    <p class="text-xl font-bold text-gray-900">{{ $lulus }}</p>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-xl shadow-sm p-4 border border-gray-100">
            <div class="flex items-center gap-3">
                <div class="bg-red-100 text-red-600 p-2.5 rounded-lg">
                    <i class="fi fi-rs-cross text-lg"></i>
                </div>
                <div>
                    <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">Tidak Lulus</p>
                    <p class="text-xl font-bold text-gray-900">{{ $tidakLulus }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center">
            <h3 class="font-bold text-gray-800">Pendaftar Terbaru</h3>
            <a href="{{ route('admin.verifikasi.index') }}"
                class="text-sm text-emerald-600 font-medium hover:text-emerald-800">Lihat Semua</a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50 text-gray-500 text-sm">
                        <th class="px-6 py-3 font-medium">No. Pendaftaran</th>
                        <th class="px-6 py-3 font-medium">Nama Peserta</th>
                        <th class="px-6 py-3 font-medium">Jalur</th>
                        <th class="px-6 py-3 font-medium">Tanggal</th>
                        <th class="px-6 py-3 font-medium">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($recentRegistrations as $reg)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 font-mono text-sm text-gray-700">{{ $reg->no_pendaftaran }}</td>
                            <td class="px-6 py-4 font-medium text-gray-900">{{ $reg->user->name }}</td>
                            <td class="px-6 py-4 text-sm text-gray-600">{{ $reg->jalur->nama_jalur }}</td>
                            <td class="px-6 py-4 text-sm text-gray-500">{{ $reg->created_at->format('d M Y') }}</td>
                            <td class="px-6 py-4">
                                @if($reg->status_pendaftaran == 'pending')
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">Pending</span>
                                @elseif($reg->status_pendaftaran == 'verifikasi')
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">Verifikasi</span>
                                @else
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">{{ ucfirst($reg->status_pendaftaran) }}</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-8 text-center text-gray-500">Belum ada pendaftar.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>