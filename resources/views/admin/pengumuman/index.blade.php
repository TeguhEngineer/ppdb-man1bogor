<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-bold text-xl text-gray-800 leading-tight">
                {{ __('Daftar Pengumuman Terkirim') }}
            </h2>
            <a href="{{ route('admin.pengumuman.create') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-2 px-4 rounded-md transition-colors text-sm shadow-sm">
                <i class="fi fi-rs-paper-plane mr-1.5"></i> Buat Pengumuman (Broadcast)
            </a>
        </div>
    </x-slot>

    <div class="bg-white overflow-hidden shadow-sm rounded-xl border border-gray-100 mb-6">
        <div class="p-6 md:p-8 text-gray-900">

            @if (session('success'))
                <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative text-sm" role="alert">
                    <strong class="font-bold"><i class="fi fi-rs-check-circle mr-1"></i> Berhasil!</strong>
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            <!-- Filter & Search -->
            <form method="GET" action="{{ route('admin.pengumuman.index') }}" class="mb-6 flex flex-col md:flex-row gap-4">
                <div class="flex-1">
                    <label for="search" class="sr-only">Cari</label>
                    <input type="text" name="search" id="search" value="{{ request('search') }}" placeholder="Cari berdasarkan judul atau nama penerima..." class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                </div>
                <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-2 px-4 rounded-md transition-colors">
                    Filter
                </button>
            </form>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50 border-b border-gray-200 text-sm text-gray-600">
                            <th class="p-4 font-semibold rounded-tl-lg">Judul Pesan</th>
                            <th class="p-4 font-semibold">Penerima</th>
                            <th class="p-4 font-semibold">Status Final</th>
                            <th class="p-4 font-semibold">Waktu Kirim</th>
                            <th class="p-4 font-semibold rounded-tr-lg text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="text-sm divide-y divide-gray-100">
                        @forelse($pengumumans as $pengumuman)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="p-4 font-medium text-gray-800">
                                {{ $pengumuman->judul }}
                            </td>
                            <td class="p-4">
                                <span class="text-indigo-600 font-medium">{{ $pengumuman->pendaftaran->user->name ?? 'User Dihapus' }}</span>
                                <div class="text-xs text-gray-500 mt-1">No: {{ $pengumuman->pendaftaran->no_pendaftaran ?? '-' }}</div>
                            </td>
                            <td class="p-4">
                                @php
                                    $statusColors = [
                                        'pending' => 'bg-yellow-100 text-yellow-800',
                                        'lulus' => 'bg-green-100 text-green-800',
                                        'tidak_lulus' => 'bg-red-100 text-red-800',
                                    ];
                                @endphp
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold uppercase {{ $statusColors[$pengumuman->status] ?? 'bg-gray-100 text-gray-800' }}">
                                    {{ str_replace('_', ' ', $pengumuman->status) }}
                                </span>
                            </td>
                            <td class="p-4 text-gray-500">
                                {{ $pengumuman->created_at->format('d M Y H:i') }}
                            </td>
                            <td class="p-4 text-right">
                                <form action="{{ route('admin.pengumuman.destroy', $pengumuman->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus pengumuman ini untuk peserta tersebut?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="inline-flex items-center justify-center text-red-600 hover:text-red-900 bg-red-50 hover:bg-red-100 font-medium px-3 py-1.5 rounded-md transition-colors text-xs border border-transparent hover:border-red-200">
                                        <i class="fi fi-rs-trash mr-1.5"></i> Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="p-8 text-center text-gray-500">
                                <i class="fi fi-rs-envelope-open text-3xl mb-3 block text-gray-300"></i>
                                Belum ada pengumuman yang dikirim.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="mt-6">
                {{ $pengumumans->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
