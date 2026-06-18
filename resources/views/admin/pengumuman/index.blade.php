<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-gray-800 leading-tight">
            {{ __('Data Master Pengumuman') }}
        </h2>
    </x-slot>

    <div class="bg-white overflow-hidden shadow-sm rounded-xl border border-gray-100 mb-6">
        <div class="p-6 md:p-8 text-gray-900">
            @if (session('success'))
                <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative text-sm" role="alert">
                    <strong class="font-bold"><i class="fi fi-rs-check-circle mr-1"></i> Berhasil!</strong>
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-6">
                <a href="{{ route('admin.pengumuman.create') }}" class="bg-emerald-600 hover:bg-emerald-700 text-white font-medium py-2.5 px-5 rounded-lg transition-colors text-sm shadow-sm shrink-0 inline-flex items-center">
                    <i class="fi fi-rs-plus mr-2"></i> Tambah Pengumuman
                </a>

                <form method="GET" action="{{ route('admin.pengumuman.index') }}" class="flex flex-col sm:flex-row gap-3 w-full md:w-auto">
                    <div class="flex-1 md:w-72">
                        <label for="search" class="sr-only">Cari</label>
                        <input type="text" name="search" id="search" value="{{ request('search') }}" placeholder="Cari judul / isi pengumuman..." class="w-full rounded-lg border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 text-sm">
                    </div>
                    <button type="submit" class="bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium py-2 px-4 rounded-lg transition-colors border border-gray-200 text-sm">
                        <i class="fi fi-rs-search mr-1.5"></i> Cari
                    </button>
                </form>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50 border-b border-gray-200 text-sm text-gray-600">
                            <th class="p-4 font-semibold rounded-tl-lg">Judul</th>
                            <th class="p-4 font-semibold">Status</th>
                            <th class="p-4 font-semibold">Tanggal Publish</th>
                            <th class="p-4 font-semibold">Dibuat</th>
                            <th class="p-4 font-semibold rounded-tr-lg text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="text-sm divide-y divide-gray-100">
                        @forelse($pengumumans as $pengumuman)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="p-4">
                                    <div class="font-semibold text-gray-800">{{ $pengumuman->judul }}</div>
                                    <div class="text-xs text-gray-500 mt-1 line-clamp-2">{{ \Illuminate\Support\Str::limit($pengumuman->keterangan, 120) }}</div>
                                </td>
                                <td class="p-4">
                                    @if($pengumuman->is_published)
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-700">Published</span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-gray-100 text-gray-700">Draft</span>
                                    @endif
                                </td>
                                <td class="p-4 text-gray-500">
                                    {{ $pengumuman->published_at ? \Carbon\Carbon::parse($pengumuman->published_at)->format('d M Y H:i') : '-' }}
                                </td>
                                <td class="p-4 text-gray-500">
                                    {{ $pengumuman->created_at->format('d M Y H:i') }}
                                </td>
                                <td class="p-4 text-right">
                                    <div class="flex justify-end gap-2">
                                    <a href="{{ route('admin.pengumuman.edit', $pengumuman->id) }}" class="inline-flex items-center justify-center text-blue-600 hover:text-blue-900 bg-blue-50 hover:bg-blue-100 font-medium px-3 py-1.5 rounded-md transition-colors text-xs border border-transparent hover:border-blue-200">
                                        <i class="fi fi-rs-edit mr-1.5"></i> Edit
                                    </a>
                                    <form action="{{ route('admin.pengumuman.destroy', $pengumuman->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus pengumuman ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="inline-flex items-center justify-center text-red-600 hover:text-red-900 bg-red-50 hover:bg-red-100 font-medium px-3 py-1.5 rounded-md transition-colors text-xs border border-transparent hover:border-red-200">
                                            <i class="fi fi-rs-trash mr-1.5"></i> Hapus
                                        </button>
                                    </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="p-8 text-center text-gray-500">
                                    <i class="fi fi-rs-envelope-open text-3xl mb-3 block text-gray-300"></i>
                                    Belum ada pengumuman.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-6">
                {{ $pengumumans->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
