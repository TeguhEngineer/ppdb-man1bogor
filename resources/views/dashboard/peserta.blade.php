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
                        'text' => 'Menyusul',
                        'class' => 'bg-gray-100 text-gray-700 border-gray-200',
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

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Biodata Action -->
        @php
            $hasBiodata = $pendaftaran->biodata != null;
            $isBiodataComplete = $hasBiodata;
        @endphp
        <div
            class="bg-white rounded-xl shadow-md p-6 border-t-4 border-{{ $isBiodataComplete ? 'green' : 'yellow' }}-500">
            <div class="flex items-start justify-between">
                <div>
                    <h3 class="text-lg font-bold text-gray-800">Biodata</h3>
                    <p class="text-gray-500 text-sm mt-1">Lengkapi data diri dan data orang tua.</p>
                </div>
                <div
                    class="bg-{{ $isBiodataComplete ? 'green' : 'yellow' }}-100 text-{{ $isBiodataComplete ? 'green' : 'yellow' }}-600 p-3 rounded-full">
                    <i class="fi fi-rs-{{ $isBiodataComplete ? 'check-circle' : 'exclamation' }} text-xl"></i>
                </div>
            </div>
            <div class="mt-6">
                @if ($isBiodataComplete)
                    <span
                        class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                        Selesai Diisi
                    </span>
                    <div class="grid grid-cols-2 gap-3 mt-4">
                        <a href="{{ route('biodata.edit', $pendaftaran->biodata->id) }}"
                            class="flex items-center justify-center bg-gray-100 hover:bg-gray-200 text-gray-800 font-medium py-2 rounded-lg transition-colors text-sm">
                            <i class="fi fi-rs-eye mr-2"></i> Lihat Data
                        </a>
                        <a href="{{ route('pendaftaran.cetak') }}" target="_blank"
                            class="flex items-center justify-center bg-emerald-600 hover:bg-emerald-700 text-white font-medium py-2 rounded-lg shadow transition-colors text-sm">
                            <i class="fi fi-rs-print mr-2"></i> Cetak Formulir
                        </a>
                    </div>
                @elseif ($hasBiodata)
                    <span
                        class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                        Belum Lengkap
                    </span>
                    <a href="{{ route('biodata.edit', $pendaftaran->biodata->id) }}"
                        class="block mt-4 w-full text-center bg-emerald-600 hover:bg-emerald-700 text-white font-medium py-2 rounded-lg shadow transition-colors">Lengkapi
                        Biodata</a>
                @else
                    <span
                        class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                        Belum Diisi
                    </span>
                    <a href="{{ route('biodata.create') }}"
                        class="block mt-4 w-full text-center bg-emerald-600 hover:bg-emerald-700 text-white font-medium py-2 rounded-lg shadow transition-colors">Isi
                        Biodata Sekarang</a>
                @endif
            </div>
        </div>

        <!-- Berkas Action -->
        @php
            $isBerkasComplete = $pendaftaran->isBerkasLengkap();
            $hasBerkas = $pendaftaran->berkas != null;
            $berkasStatus = optional($pendaftaran->berkas)->status_berkas;
            $berkasRejected = $berkasStatus === 'tolak';
            $berkasAccepted = $berkasStatus === 'terima';
            $berkasBorderColor = $berkasRejected ? 'red' : ($isBerkasComplete ? 'green' : ($hasBerkas ? 'yellow' : 'red'));
        @endphp
        <div
            class="bg-white rounded-xl shadow-md p-6 border-t-4 border-{{ $berkasBorderColor }}-500">
            <div class="flex items-start justify-between">
                <div>
                    <h3 class="text-lg font-bold text-gray-800">Upload Berkas</h3>
                    <p class="text-gray-500 text-sm mt-1">Unggah dokumen persyaratan jalur
                        {{ $pendaftaran->jalur->nama_jalur }}.
                    </p>
                </div>
                <div
                    class="bg-{{ $berkasBorderColor }}-100 text-{{ $berkasBorderColor }}-600 p-3 rounded-full">
                    <i
                        class="fi fi-rs-{{ $berkasRejected ? 'cross' : ($isBerkasComplete ? 'check-circle' : ($hasBerkas ? 'exclamation' : 'document')) }} text-xl"></i>
                </div>
            </div>
            <div class="mt-6">
                @if ($berkasRejected)
                    <button type="button" onclick="alert(@js($pendaftaran->berkas->pesan ?? 'Berkas ditolak. Silakan perbaiki unggahan Anda.'))"
                        class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800 hover:bg-red-200 transition-colors"
                        title="Klik untuk melihat pesan penolakan">
                        Ditolak
                    </button>
                    <a href="{{ route('berkas.edit', $pendaftaran->berkas->id) }}"
                        class="block text-center mt-4 w-full bg-emerald-600 hover:bg-emerald-700 text-white font-medium py-2 rounded-lg shadow transition-colors">Perbaiki
                        Berkas</a>
                @elseif ($isBerkasComplete)
                    <span
                        class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium {{ $berkasAccepted ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                        {{ $berkasAccepted ? 'Diterima' : 'Selesai Diupload' }}
                    </span>
                    <a href="{{ route('berkas.edit', $pendaftaran->berkas->id) }}"
                        class="block text-center mt-4 w-full bg-gray-100 hover:bg-gray-200 text-gray-800 font-medium py-2 rounded-lg transition-colors">Lihat
                        Berkas</a>
                @elseif ($hasBerkas)
                    <span
                        class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                        Belum Lengkap
                    </span>
                    <a href="{{ route('berkas.edit', $pendaftaran->berkas->id) }}"
                        class="block text-center mt-4 w-full bg-emerald-600 hover:bg-emerald-700 text-white font-medium py-2 rounded-lg shadow transition-colors">Lengkapi
                        Berkas</a>
                @else
                    <span
                        class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800">
                        Belum Diupload
                    </span>
                    @if(!$isBiodataComplete)
                        <button
                            class="mt-4 w-full bg-emerald-600 hover:bg-emerald-700 text-white font-medium py-2 rounded-lg shadow transition-colors opacity-50 cursor-not-allowed"
                            disabled title="Lengkapi biodata terlebih dahulu">Upload Berkas</button>
                    @else
                        <a href="{{ route('berkas.create') }}"
                            class="block text-center mt-4 w-full bg-emerald-600 hover:bg-emerald-700 text-white font-medium py-2 rounded-lg shadow transition-colors">Upload
                            Berkas</a>
                    @endif
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
