<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-gray-800 leading-tight">
            {{ __('Hasil Kelulusan') }}
        </h2>
    </x-slot>

    @php
        $status = $pendaftaran->status_pendaftaran;
        $isFinal = in_array($status, ['lulus', 'tidak_lulus'], true);
        $isLulus = $status === 'lulus';
        $name = $pendaftaran->biodata->nama_lengkap ?? $pendaftaran->user->name;
        $statusLabel = $isLulus ? 'LULUS' : ($status === 'tidak_lulus' ? 'TIDAK LULUS' : 'BELUM DIUMUMKAN');
        $accent = $isLulus ? 'emerald' : ($status === 'tidak_lulus' ? 'red' : 'amber');
    @endphp

    <div class="space-y-6">
        @if (session('error'))
            <div class="bg-red-100 border border-red-300 text-red-700 px-4 py-3 rounded-xl text-sm">
                <strong class="font-bold">Gagal!</strong>
                <span>{{ session('error') }}</span>
            </div>
        @endif

        <div class="relative overflow-hidden rounded-2xl bg-white border-2 border-{{ $accent }}-200 shadow-sm">
            <div class="absolute inset-x-0 top-0 h-2 bg-{{ $accent }}-500"></div>
            <div class="p-6 md:p-10">
                <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-8">
                    <div class="space-y-5">
                        <div class="inline-flex items-center px-4 py-2 rounded-full bg-{{ $accent }}-50 text-{{ $accent }}-700 text-sm font-bold border border-{{ $accent }}-100">
                            <i class="fi fi-rs-{{ $isFinal ? ($isLulus ? 'check-circle' : 'cross-circle') : 'time-fast' }} mr-2"></i>
                            {{ $statusLabel }}
                        </div>

                        <div>
                            <p class="text-sm uppercase tracking-[0.25em] text-gray-400 font-bold mb-2">Pengumuman Hasil Seleksi</p>
                            <h3 class="text-2xl md:text-4xl font-black text-gray-900 leading-tight">
                                @if($isLulus)
                                    Anda Dinyatakan Lulus Seleksi
                                @elseif($status === 'tidak_lulus')
                                    Anda Belum Dinyatakan Lulus Seleksi
                                @else
                                    Hasil seleksi belum tersedia.
                                @endif
                            </h3>
                        </div>

                        <p class="text-gray-600 max-w-2xl leading-relaxed">
                            @if($isLulus)
                                Selamat kepada <strong class="text-gray-900">{{ $name }}</strong>. Berdasarkan hasil seleksi PPDB, Anda dinyatakan <strong class="text-emerald-700">lulus</strong>. Silakan cetak kartu kelulusan dan ikuti informasi lanjutan dari panitia.
                            @elseif($status === 'tidak_lulus')
                                Berdasarkan hasil seleksi PPDB, peserta atas nama <strong class="text-gray-900">{{ $name }}</strong> dinyatakan <strong class="text-red-700">tidak lulus</strong>. Terima kasih telah mengikuti proses PPDB.
                            @else
                                Status kelulusan akan muncul setelah panitia menyelesaikan proses seleksi dan mengubah hasil pada dashboard admin.
                            @endif
                        </p>

                        @if($isLulus)
                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 max-w-2xl">
                                <div class="flex items-start gap-3 rounded-xl bg-emerald-50 border border-emerald-100 p-4">
                                    <i class="fi fi-rs-check-circle text-emerald-600 mt-0.5"></i>
                                    <div>
                                        <p class="font-bold text-emerald-800 text-sm">Status Lulus</p>
                                        <p class="text-xs text-emerald-700 mt-1">Hasil akhir sudah ditetapkan.</p>
                                    </div>
                                </div>
                                <div class="flex items-start gap-3 rounded-xl bg-emerald-50 border border-emerald-100 p-4">
                                    <i class="fi fi-rs-print text-emerald-600 mt-0.5"></i>
                                    <div>
                                        <p class="font-bold text-emerald-800 text-sm">Kartu Tersedia</p>
                                        <p class="text-xs text-emerald-700 mt-1">Kartu kelulusan dapat dicetak.</p>
                                    </div>
                                </div>
                                <div class="flex items-start gap-3 rounded-xl bg-emerald-50 border border-emerald-100 p-4">
                                    <i class="fi fi-rs-megaphone text-emerald-600 mt-0.5"></i>
                                    <div>
                                        <p class="font-bold text-emerald-800 text-sm">Ikuti Arahan</p>
                                        <p class="text-xs text-emerald-700 mt-1">Pantau pengumuman lanjutan panitia.</p>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>

                    <div class="w-full lg:w-80">
                        <div class="rounded-2xl border border-{{ $accent }}-100 bg-{{ $accent }}-50/40 p-5 space-y-4">
                            <div>
                                <p class="text-xs uppercase tracking-wider text-gray-400 font-bold">No Pendaftaran</p>
                                <p class="text-lg font-black text-gray-900">{{ $pendaftaran->no_pendaftaran }}</p>
                            </div>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <p class="text-xs uppercase tracking-wider text-gray-400 font-bold">Jalur</p>
                                    <p class="font-semibold text-gray-800">{{ $pendaftaran->jalur->nama_jalur ?? '-' }}</p>
                                </div>
                                <div>
                                    <p class="text-xs uppercase tracking-wider text-gray-400 font-bold">Kampus</p>
                                    <p class="font-semibold text-gray-800">{{ $pendaftaran->kampus ?? '-' }}</p>
                                </div>
                            </div>
                            <div>
                                <p class="text-xs uppercase tracking-wider text-gray-400 font-bold">Status Akhir</p>
                                <p class="font-black text-{{ $accent }}-700">{{ $statusLabel }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-8 flex flex-col sm:flex-row gap-3 border-t border-gray-100 pt-6">
                    @if($isFinal)
                        <a href="{{ route('hasil-kelulusan.cetak') }}" target="_blank"
                            class="inline-flex items-center justify-center px-6 py-3 rounded-lg bg-{{ $accent }}-600 hover:bg-{{ $accent }}-700 text-white font-bold shadow-sm transition-colors">
                            <i class="fi fi-rs-print mr-2"></i> Cetak Kartu Kelulusan
                        </a>
                    @else
                        <button disabled class="inline-flex items-center justify-center px-6 py-3 rounded-lg bg-gray-200 text-gray-500 font-bold cursor-not-allowed">
                            <i class="fi fi-rs-print mr-2"></i> Cetak Kartu Belum Tersedia
                        </button>
                    @endif
                    <a href="{{ route('pengumuman.index') }}"
                        class="inline-flex items-center justify-center px-6 py-3 rounded-lg bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold transition-colors">
                        <i class="fi fi-rs-megaphone mr-2"></i> Lihat Pengumuman Umum
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
