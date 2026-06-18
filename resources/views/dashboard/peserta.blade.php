<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-bold text-gray-800">Dashboard Peserta</h2>
    </x-slot>

    <div class="mb-6">
        <div class="bg-emerald-600 rounded-xl shadow-lg overflow-hidden text-white">
            <div class="p-6 md:p-8 flex flex-col md:flex-row items-center justify-between relative overflow-hidden">
                <div class="absolute -right-10 -top-10 opacity-10">
                    <i class="fi fi-rs-graduation-cap text-9xl"></i>
                </div>
                <div class="z-10 text-center md:text-left mb-4 md:mb-0">
                    <h3 class="text-2xl font-bold mb-1">Selamat Datang, {{ Auth::user()->name }}!</h3>
                    <p class="text-emerald-100">Jalur Pendaftaran: <span
                            class="font-bold text-yellow-300">{{ $pendaftaran->jalur->nama_jalur }}</span></p>
                </div>
                <div
                    class="z-10 bg-white bg-opacity-20 backdrop-blur-md px-6 py-4 rounded-lg text-center border border-white border-opacity-30">
                    <p class="text-xs uppercase tracking-wider text-emerald-100 mb-1">No. Pendaftaran</p>
                    <p class="text-3xl font-bold tracking-widest font-mono">{{ $pendaftaran->no_pendaftaran }}</p>
                </div>
            </div>
        </div>
    </div>

    @if (session('success'))
        <div class="mb-6 bg-green-50 border-l-4 border-green-500 p-4 rounded-r-xl shadow-sm">
            <div class="flex items-center">
                <div class="shrink-0">
                    <i class="fi fi-rs-check-circle text-green-500 text-xl"></i>
                </div>
                <div class="ml-3">
                    <h3 class="text-sm font-bold text-green-800 uppercase tracking-wider">Berhasil</h3>
                    <p class="text-xs text-green-700 mt-1 leading-relaxed">{{ session('success') }}</p>
                </div>
            </div>
        </div>
    @endif

    @if (session('error'))
        <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4 rounded-r-xl shadow-sm">
            <div class="flex items-center">
                <div class="shrink-0">
                    <i class="fi fi-rs-cross text-red-500 text-xl"></i>
                </div>
                <div class="ml-3">
                    <h3 class="text-sm font-bold text-red-800 uppercase tracking-wider">Gagal</h3>
                    <p class="text-xs text-red-700 mt-1 leading-relaxed">{{ session('error') }}</p>
                </div>
            </div>
        </div>
    @endif

    <!-- Informasi Penting Badge -->
    @if (!$pendaftaran->isLengkap())
        <div class="mb-6 bg-yellow-50 border-l-4 border-yellow-500 p-4 rounded-r-xl shadow-sm">
            <div class="flex items-center">
                <div class="shrink-0">
                    <i class="fi fi-rs-exclamation text-yellow-500 text-xl"></i>
                </div>
                <div class="ml-3">
                    <h3 class="text-sm font-bold text-yellow-800 uppercase tracking-wider">Peringatan Penting!</h3>
                    <p class="text-xs text-yellow-700 mt-1 leading-relaxed">
                        Data Anda tidak akan diverifikasi oleh Admin selama <strong>Biodata</strong> dan <strong>Berkas
                            Wajib</strong> belum diisi lengkap. Silakan lengkapi seluruh data Anda segera agar dapat
                        diproses ke tahap selanjutnya.
                    </p>
                </div>
            </div>
        </div>
    @endif

   

    <!-- Status Timeline -->
    <div class="bg-white rounded-xl shadow-md p-6 mb-6">
        <h3 class="text-lg font-bold text-gray-800 mb-6">Status Pendaftaran</h3>
        <div class="flex flex-col md:flex-row justify-between items-center w-full relative">
            <div class="absolute hidden md:block top-1/2 left-0 w-full h-1 bg-gray-200 -z-0"></div>
            <!-- Progress Line (Active) -->
            @php
                $statusStage = in_array($pendaftaran->status_pendaftaran, ['lulus', 'tidak_lulus'])
                    ? 'pengumuman'
                    : $pendaftaran->status_pendaftaran;

                $statusStageWidths = [
                    'pending' => '15%',
                    'verifikasi' => '45%',
                    'tes' => '75%',
                    'pengumuman' => '100%',
                ];

                $timelineSteps = [
                    'pending' => 'Registrasi',
                    'verifikasi' => 'Verifikasi Berkas',
                    'tes' => 'Seleksi Tes',
                    'pengumuman' => 'Pengumuman',
                ];

                $timelineOrder = array_keys($timelineSteps);
                $currentIndex = array_search($statusStage, $timelineOrder, true);
                $currentIndex = $currentIndex === false ? 0 : $currentIndex;
                $berkasStatus = optional($pendaftaran->berkas)->status_berkas;
                $berkasDitolak = $berkasStatus === 'tolak';
                $berkasDiterima = $berkasStatus === 'terima';
                $berkasPesan = optional($pendaftaran->berkas)->pesan;
                $kartuUjian = $pendaftaran->kartuPesertaUjian;
                $kartuUjianSiap = $kartuUjian && $kartuUjian->ruangan_id && $kartuUjian->jadwal_ujian_id;

                $statusColors = [
                    'pending' => 'bg-yellow-100 text-yellow-800 border-yellow-200',
                    'verifikasi' => 'bg-blue-100 text-blue-800 border-blue-200',
                    'tes' => 'bg-purple-100 text-purple-800 border-purple-200',
                    'lulus' => 'bg-green-100 text-green-800 border-green-200',
                    'tidak_lulus' => 'bg-red-100 text-red-800 border-red-200',
                ];

                $statusLabels = [
                    'pending' => 'Registrasi',
                    'verifikasi' => 'Verifikasi Berkas',
                    'tes' => 'Seleksi Tes',
                    'lulus' => 'Pengumuman',
                    'tidak_lulus' => 'Pengumuman',
                ];

                $stepNotes = [
                    'pending' => [
                        'text' => 'Selesai',
                        'class' => 'bg-green-100 text-green-800 border-green-200',
                    ],
                    'verifikasi' => [
                        'text' => $berkasDitolak ? 'Ditolak' : ($berkasDiterima ? 'Diterima' : 'Menunggu'),
                        'class' => $berkasDitolak
                            ? 'bg-red-100 text-red-800 border-red-200'
                            : ($berkasDiterima ? 'bg-green-100 text-green-800 border-green-200' : 'bg-gray-100 text-gray-700 border-gray-200'),
                    ],
                    'tes' => [
                        'text' => $kartuUjianSiap ? 'Kartu Siap' : 'Menyusul',
                        'class' => $kartuUjianSiap ? 'bg-purple-100 text-purple-800 border-purple-200' : 'bg-gray-100 text-gray-700 border-gray-200',
                    ],
                    'pengumuman' => [
                        'text' => $pendaftaran->status_pendaftaran === 'lulus'
                            ? 'Lulus'
                            : ($pendaftaran->status_pendaftaran === 'tidak_lulus' ? 'Tidak Lulus' : 'Menyusul'),
                        'class' => $pendaftaran->status_pendaftaran === 'lulus'
                            ? 'bg-green-100 text-green-800 border-green-200'
                            : ($pendaftaran->status_pendaftaran === 'tidak_lulus' ? 'bg-red-100 text-red-800 border-red-200' : 'bg-gray-100 text-gray-700 border-gray-200'),
                    ],
                ];
            @endphp
            <div class="absolute hidden md:block top-1/2 left-0 h-1 bg-emerald-600 -z-0" style="width: {{ $statusStageWidths[$statusStage] }}"></div>

            <!-- Steps -->
            @foreach ($timelineSteps as $stepKey => $stepLabel)
                @php $index = array_search($stepKey, $timelineOrder, true); @endphp
                <div class="flex flex-col items-center relative z-10 bg-white px-4 py-2 mb-4 md:mb-0">
                    @if($stepKey === 'verifikasi' && $berkasDitolak && $berkasPesan)
                        <button type="button"
                            onclick="alert(@js($berkasPesan))"
                            class="mb-2 inline-flex items-center px-2.5 py-1 rounded-full border text-xs font-semibold {{ $stepNotes[$stepKey]['class'] }} hover:bg-red-200 transition-colors"
                            title="Klik untuk melihat pesan penolakan">
                            {{ $stepNotes[$stepKey]['text'] }}
                        </button>
                    @else
                        <span class="mb-2 inline-flex items-center px-2.5 py-1 rounded-full border text-xs font-semibold {{ $stepNotes[$stepKey]['class'] }}">
                            {{ $stepNotes[$stepKey]['text'] }}
                        </span>
                    @endif
                    <div
                        class="w-10 h-10 rounded-full flex items-center justify-center {{ $stepKey === 'verifikasi' && $berkasDitolak ? 'bg-red-600 text-white' : ($index <= $currentIndex ? 'bg-emerald-600 text-white' : 'bg-gray-200 text-gray-400') }} border-4 border-white">
                        @if ($stepKey === 'verifikasi' && $berkasDitolak)
                            <i class="fi fi-rs-cross text-sm"></i>
                        @elseif ($index < $currentIndex)
                            <i class="fi fi-rs-check text-sm"></i>
                        @elseif ($stepKey === 'pengumuman' && $pendaftaran->status_pendaftaran == 'tidak_lulus')
                            <i
                                class="fi fi-rs-cross text-sm bg-red-500 text-white w-full h-full rounded-full flex items-center justify-center"></i>
                        @else
                            <span class="font-bold text-sm">{{ $index + 1 }}</span>
                        @endif
                    </div>
                    <span class="mt-2 text-sm font-medium {{ $stepKey === 'verifikasi' && $berkasDitolak ? 'text-red-700' : ($index <= $currentIndex ? 'text-gray-800' : 'text-gray-400') }}">{{ $stepLabel }}</span>
                    @if($stepKey === 'verifikasi' && $berkasDitolak && $berkasPesan)
                        <p class="mt-1 text-[11px] text-red-600 text-center">Klik status ditolak untuk detail.</p>
                    @endif
                </div>
            @endforeach
        </div>
    </div>
    
     @if (optional($pendaftaran->berkas)->status_berkas === 'tolak')
        <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4 rounded-r-xl shadow-sm">
            <div class="flex flex-col md:flex-row md:items-start md:justify-between gap-4">
                <div class="flex items-start">
                    <div class="shrink-0">
                        <i class="fi fi-rs-exclamation text-red-500 text-xl"></i>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-bold text-red-800 uppercase tracking-wider">Verifikasi Berkas Ditolak</h3>
                        <p class="text-xs text-red-700 mt-1 leading-relaxed">
                            Admin menolak berkas Anda. Perbaiki dokumen sesuai catatan, lalu klik
                            <strong>Ajukan Ulang Verifikasi</strong> agar status berkas kembali menunggu pemeriksaan admin.
                        </p>
                        @if($pendaftaran->berkas->pesan)
                            <div class="mt-3 bg-white border border-red-200 rounded-lg px-3 py-2 text-xs text-red-800">
                                <span class="font-bold">Catatan admin:</span> {{ $pendaftaran->berkas->pesan }}
                            </div>
                        @endif
                    </div>
                </div>
                <div class="flex flex-col sm:flex-row gap-2 md:shrink-0">
                    <a href="{{ route('biodata.edit', ['tab' => 'berkas']) }}"
                        class="inline-flex items-center justify-center px-4 py-2 bg-white border border-red-200 text-red-700 font-bold rounded-lg hover:bg-red-100 transition-colors text-sm">
                        Perbaiki Berkas
                    </a>
                    <form action="{{ route('berkas.ajukan-ulang', $pendaftaran->berkas->id) }}" method="POST">
                        @csrf
                        <button type="submit"
                            class="w-full inline-flex items-center justify-center px-4 py-2 bg-red-600 text-white font-bold rounded-lg hover:bg-red-700 transition-colors text-sm">
                            Ajukan Ulang Verifikasi
                        </button>
                    </form>
                </div>
            </div>
        </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Biodata Action -->
        @php
            $hasBiodata = $pendaftaran->dataPribadi || $pendaftaran->dataOrangtua;
            $isBiodataComplete = $pendaftaran->isBiodataLengkap();
            $isBerkasComplete = $pendaftaran->isBerkasLengkap();
            $hasBerkas = $pendaftaran->berkas != null;
            $berkasStatus = optional($pendaftaran->berkas)->status_berkas;
            $berkasRejected = $berkasStatus === 'tolak';
            $berkasAccepted = $berkasStatus === 'terima';
            $isBiodataFinished = $isBiodataComplete && $isBerkasComplete;
            $nextBiodataTab = $isBiodataComplete ? 'berkas' : 'pribadi';
            $biodataUrl = fn ($tab = 'pribadi') => route('biodata.edit', ['tab' => $tab]);
        @endphp
        <div
            class="bg-white rounded-xl shadow-md p-6 border-t-4 border-{{ $isBiodataFinished ? 'green' : ($berkasRejected ? 'red' : 'yellow') }}-500">
            <div class="flex items-start justify-between">
                <div>
                    <h3 class="text-lg font-bold text-gray-800">Biodata</h3>
                    <p class="text-gray-500 text-sm mt-1">Lengkapi data diri, data orang tua, dan berkas persyaratan.</p>
                </div>
                <div
                    class="bg-{{ $isBiodataFinished ? 'green' : ($berkasRejected ? 'red' : 'yellow') }}-100 text-{{ $isBiodataFinished ? 'green' : ($berkasRejected ? 'red' : 'yellow') }}-600 p-3 rounded-full">
                    <i class="fi fi-rs-{{ $isBiodataFinished ? 'check-circle' : ($berkasRejected ? 'cross' : 'exclamation') }} text-xl"></i>
                </div>
            </div>
            <div class="mt-6">
                @if ($isBiodataFinished)
                    <div>
                        <span
                            class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                            Biodata Selesai Diisi
                        </span>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 mt-4">
                            <a href="{{ $biodataUrl('pribadi') }}"
                                class="flex items-center justify-center bg-gray-100 hover:bg-gray-200 text-gray-800 font-medium py-2 rounded-lg transition-colors text-sm">
                                <i class="fi fi-rs-eye mr-2"></i> Lihat Data
                            </a>
                            <a href="{{ route('pendaftaran.cetak') }}" target="_blank"
                                class="flex items-center justify-center bg-emerald-600 hover:bg-emerald-700 text-white font-medium py-2 rounded-lg shadow transition-colors text-sm">
                                <i class="fi fi-rs-print mr-2"></i> Cetak Formulir
                            </a>
                        </div>
                    </div>
                @elseif ($hasBiodata)
                    <div>
                        <span
                            class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium {{ $berkasRejected ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800' }}">
                            @if($berkasRejected)
                                Berkas Ditolak
                            @elseif(!$isBiodataComplete)
                                Biodata Belum Lengkap
                            @elseif($hasBerkas)
                                Berkas Belum Lengkap
                            @else
                                Berkas Belum Diupload
                            @endif
                        </span>
                        <a href="{{ $biodataUrl($nextBiodataTab) }}"
                            class="block mt-4 w-full text-center bg-emerald-600 hover:bg-emerald-700 text-white font-medium py-2 rounded-lg shadow transition-colors">Lihat Data</a>
                        @if($berkasRejected && optional($pendaftaran->berkas)->pesan)
                            <button type="button" onclick="alert(@js($pendaftaran->berkas->pesan))"
                                class="block mt-3 w-full text-center bg-red-100 hover:bg-red-200 text-red-800 font-medium py-2 rounded-lg transition-colors">
                                Lihat Pesan Penolakan
                            </button>
                        @endif
                    </div>
                @else
                    <div>
                        <span
                            class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                            Biodata Belum Diisi
                        </span>
                        <a href="{{ $biodataUrl('pribadi') }}"
                            class="block mt-4 w-full text-center bg-emerald-600 hover:bg-emerald-700 text-white font-medium py-2 rounded-lg shadow transition-colors">Isi
                            Biodata Sekarang</a>
                    </div>
                @endif
            </div>
        </div>

        <!-- Kartu Ujian Action -->
        <div
            class="bg-white rounded-xl shadow-md p-6 border-t-4 border-{{ $kartuUjianSiap ? 'purple' : 'gray' }}-500">
            <div class="flex items-start justify-between">
                <div>
                    <h3 class="text-lg font-bold text-gray-800">Kartu Peserta Ujian</h3>
                    <p class="text-gray-500 text-sm mt-1">Kartu tersedia setelah berkas diterima dan jadwal ujian ditentukan panitia.</p>
                </div>
                <div
                    class="bg-{{ $kartuUjianSiap ? 'purple' : 'gray' }}-100 text-{{ $kartuUjianSiap ? 'purple' : 'gray' }}-600 p-3 rounded-full">
                    <i class="fi fi-rs-{{ $kartuUjianSiap ? 'ticket' : 'time-past' }} text-xl"></i>
                </div>
            </div>
            <div class="mt-6">
                @if ($kartuUjianSiap)
                    <span
                        class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                        Siap Dicetak
                    </span>
                    <a href="{{ route('kartu-ujian.cetak') }}" target="_blank"
                        class="block text-center mt-4 w-full bg-purple-600 hover:bg-purple-700 text-white font-medium py-2 rounded-lg shadow transition-colors">
                        Cetak Kartu Ujian
                    </a>
                @elseif($berkasAccepted)
                    <span
                        class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                        Menunggu Jadwal
                    </span>
                @else
                    <span
                        class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-700">
                        Belum Tersedia
                    </span>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
