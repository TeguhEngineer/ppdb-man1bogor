<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-gray-800 leading-tight">
            {{ __('Pengumuman Peserta') }}
        </h2>
    </x-slot>

    <div class="space-y-6">
        @if(!$pendaftaran)
            <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 rounded-r-lg shadow-sm">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <i class="fi fi-rs-exclamation text-yellow-500 text-xl"></i>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-yellow-700">
                            Anda belum melengkapi data pendaftaran. Silakan lengkapi biodata terlebih dahulu.
                        </p>
                    </div>
                </div>
            </div>
        @else
            @if($pengumumans->isEmpty())
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-12 text-center">
                    <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-emerald-50 mb-4 text-emerald-500">
                        <i class="fi fi-rs-envelope-open text-2xl"></i>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 mb-1">Belum Ada Pengumuman</h3>
                    <p class="text-gray-500 text-sm max-w-md mx-auto">Saat ini belum ada pengumuman atau pesan baru dari panitia PPDB untuk Anda. Silakan cek kembali nanti.</p>
                </div>
            @else
                <div class="grid grid-cols-1 gap-6">
                    @foreach($pengumumans as $pengumuman)
                        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden relative">
                            @if(!$pengumuman->sudah_dibaca)
                                <div class="absolute top-0 right-0">
                                    <div class="bg-red-500 text-white text-[10px] font-bold px-3 py-1 rounded-bl-lg uppercase tracking-wider">
                                        Baru / Belum Dibaca
                                    </div>
                                </div>
                            @endif

                            <div class="p-6 sm:p-8">
                                <div class="flex items-center space-x-3 mb-4">
                                    <div class="flex-shrink-0 bg-emerald-100 text-emerald-600 rounded-lg p-2">
                                        <i class="fi fi-rs-megaphone text-xl"></i>
                                    </div>
                                    <div>
                                        <h3 class="text-xl font-bold text-gray-900">{{ $pengumuman->judul }}</h3>
                                        <p class="text-xs text-gray-500 mt-1">Dikirim pada: {{ $pengumuman->created_at->format('d M Y, H:i') }} WIB</p>
                                    </div>
                                </div>
                                
                                <div class="mt-4 prose prose-sm max-w-none text-gray-700 bg-gray-50 p-6 rounded-lg border border-gray-100 whitespace-pre-line">
                                    {{ $pengumuman->keterangan }}
                                </div>

                                <div class="mt-6 flex items-center justify-between border-t border-gray-100 pt-6">
                                    @if(!$pengumuman->sudah_dibaca)
                                        <form action="{{ route('pengumuman.dibaca', $pengumuman->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-bold rounded-lg transition-colors shadow-sm">
                                                <i class="fi fi-rs-check-circle mr-2"></i> Tandai Telah Dibaca
                                            </button>
                                        </form>
                                    @else
                                        <div class="flex items-center text-gray-500 text-xs italic">
                                            <i class="fi fi-rs-check-double text-emerald-500 mr-2"></i>
                                            Sudah dibaca pada {{ \Carbon\Carbon::parse($pengumuman->dibaca_pada)->format('d M Y, H:i') }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="mt-6">
                    {{ $pengumumans->links() }}
                </div>
            @endif
        @endif
    </div>
</x-app-layout>
