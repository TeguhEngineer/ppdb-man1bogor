<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-gray-800 leading-tight">
            {{ __('Pengumuman') }}
        </h2>
    </x-slot>

    <div class="space-y-6">
        @if($pengumumans->isEmpty())
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-12 text-center">
                <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-emerald-50 mb-4 text-emerald-500">
                    <i class="fi fi-rs-envelope-open text-2xl"></i>
                </div>
                <h3 class="text-lg font-bold text-gray-900 mb-1">Belum Ada Pengumuman</h3>
                <p class="text-gray-500 text-sm max-w-md mx-auto">Saat ini belum ada pengumuman dari panitia PPDB. Silakan cek kembali nanti.</p>
            </div>
        @else
            <div class="grid grid-cols-1 gap-6">
                @foreach($pengumumans as $pengumuman)
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                        <div class="p-6 sm:p-8">
                            <div class="flex items-start space-x-3 mb-4">
                                <div class="flex-shrink-0 bg-emerald-100 text-emerald-600 rounded-lg p-2">
                                    <i class="fi fi-rs-megaphone text-xl"></i>
                                </div>
                                <div>
                                    <h3 class="text-xl font-bold text-gray-900">{{ $pengumuman->judul }}</h3>
                                    <p class="text-xs text-gray-500 mt-1">
                                        Dipublikasikan:
                                        {{ ($pengumuman->published_at ? \Carbon\Carbon::parse($pengumuman->published_at) : $pengumuman->created_at)->format('d M Y, H:i') }} WIB
                                    </p>
                                </div>
                            </div>

                            <div class="mt-4 prose prose-sm max-w-none text-gray-700 bg-gray-50 p-6 rounded-lg border border-gray-100 whitespace-pre-line">
                                {{ $pengumuman->keterangan }}
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-6">
                {{ $pengumumans->links() }}
            </div>
        @endif
    </div>
</x-app-layout>
