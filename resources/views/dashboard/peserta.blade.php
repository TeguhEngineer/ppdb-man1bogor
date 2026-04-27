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
                    <p class="text-emerald-100">Jalur Pendaftaran: <span class="font-bold text-yellow-300">{{ $pendaftaran->jalur->nama_jalur }}</span></p>
                </div>
                <div class="z-10 bg-white bg-opacity-20 backdrop-blur-md px-6 py-4 rounded-lg text-center border border-white border-opacity-30">
                    <p class="text-xs uppercase tracking-wider text-emerald-100 mb-1">No. Pendaftaran</p>
                    <p class="text-3xl font-bold tracking-widest font-mono">{{ $pendaftaran->no_pendaftaran }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Status Timeline -->
    <div class="bg-white rounded-xl shadow-md p-6 mb-6">
        <h3 class="text-lg font-bold text-gray-800 mb-6">Status Pendaftaran</h3>
        <div class="flex flex-col md:flex-row justify-between items-center w-full relative">
            <div class="absolute hidden md:block top-1/2 left-0 w-full h-1 bg-gray-200 -z-0"></div>
            <!-- Progress Line (Active) -->
            <div class="absolute hidden md:block top-1/2 left-0 h-1 bg-emerald-600 -z-0" style="width: {{ 
                $pendaftaran->status_pendaftaran == 'pending' ? '10%' : 
                ($pendaftaran->status_pendaftaran == 'verifikasi' ? '40%' : 
                ($pendaftaran->status_pendaftaran == 'tes' ? '70%' : '100%')) 
            }}"></div>

            <!-- Steps -->
            @php
                $steps = [
                    'pending' => 'Menunggu Verifikasi',
                    'verifikasi' => 'Terverifikasi',
                    'tes' => 'Seleksi Tes',
                    'lulus' => 'Lulus',
                    'tidak_lulus' => 'Tidak Lulus'
                ];
                $statuses = array_keys($steps);
                $currentIndex = array_search($pendaftaran->status_pendaftaran == 'tidak_lulus' ? 'lulus' : $pendaftaran->status_pendaftaran, $statuses);
            @endphp

            @foreach (['pending', 'verifikasi', 'tes', 'lulus'] as $index => $step)
                <div class="flex flex-col items-center relative z-10 bg-white px-4 py-2 mb-4 md:mb-0">
                    <div class="w-10 h-10 rounded-full flex items-center justify-center {{ $index <= $currentIndex ? 'bg-emerald-600 text-white' : 'bg-gray-200 text-gray-400' }} border-4 border-white">
                        @if ($index < $currentIndex)
                            <i class="fi fi-rs-check text-sm"></i>
                        @elseif ($index == $currentIndex && $pendaftaran->status_pendaftaran == 'tidak_lulus')
                            <i class="fi fi-rs-cross text-sm bg-red-500 text-white w-full h-full rounded-full flex items-center justify-center"></i>
                        @else
                            <span class="font-bold text-sm">{{ $index + 1 }}</span>
                        @endif
                    </div>
                    <span class="mt-2 text-sm font-medium {{ $index <= $currentIndex ? 'text-gray-800' : 'text-gray-400' }}">{{ $steps[$step] }}</span>
                </div>
            @endforeach
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Biodata Action -->
        @php
            $hasBiodata = $pendaftaran->biodata != null;
            $isBiodataComplete = $hasBiodata && $pendaftaran->biodata->kartu_keluarga && $pendaftaran->biodata->slip_gaji;
        @endphp
        <div class="bg-white rounded-xl shadow-md p-6 border-t-4 border-{{ $isBiodataComplete ? 'green' : 'yellow' }}-500">
            <div class="flex items-start justify-between">
                <div>
                    <h3 class="text-lg font-bold text-gray-800">Biodata Diri</h3>
                    <p class="text-gray-500 text-sm mt-1">Lengkapi data pribadi dan orang tua.</p>
                </div>
                <div class="bg-{{ $isBiodataComplete ? 'green' : 'yellow' }}-100 text-{{ $isBiodataComplete ? 'green' : 'yellow' }}-600 p-3 rounded-full">
                    <i class="fi fi-rs-{{ $isBiodataComplete ? 'check-circle' : 'exclamation' }} text-xl"></i>
                </div>
            </div>
            <div class="mt-6">
                @if ($isBiodataComplete)
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                        Selesai Diisi
                    </span>
                    <div class="grid grid-cols-2 gap-3 mt-4">
                        <a href="{{ route('biodata.edit', $pendaftaran->biodata->id) }}" class="flex items-center justify-center bg-gray-100 hover:bg-gray-200 text-gray-800 font-medium py-2 rounded-lg transition-colors text-sm">
                            <i class="fi fi-rs-eye mr-2"></i> Lihat Data
                        </a>
                        <a href="{{ route('pendaftaran.cetak') }}" target="_blank" class="flex items-center justify-center bg-emerald-600 hover:bg-emerald-700 text-white font-medium py-2 rounded-lg shadow transition-colors text-sm">
                            <i class="fi fi-rs-print mr-2"></i> Cetak Formulir
                        </a>
                    </div>
                @elseif ($hasBiodata)
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                        Belum Lengkap
                    </span>
                    <a href="{{ route('biodata.edit', $pendaftaran->biodata->id) }}" class="block mt-4 w-full text-center bg-emerald-600 hover:bg-emerald-700 text-white font-medium py-2 rounded-lg shadow transition-colors">Lengkapi Biodata</a>
                @else
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                        Belum Diisi
                    </span>
                    <a href="{{ route('biodata.create') }}" class="block mt-4 w-full text-center bg-emerald-600 hover:bg-emerald-700 text-white font-medium py-2 rounded-lg shadow transition-colors">Isi Biodata Sekarang</a>
                @endif
            </div>
        </div>

        <!-- Berkas Action -->
        <div class="bg-white rounded-xl shadow-md p-6 border-t-4 border-{{ $pendaftaran->berkas ? 'green' : 'red' }}-500">
            <div class="flex items-start justify-between">
                <div>
                    <h3 class="text-lg font-bold text-gray-800">Upload Berkas</h3>
                    <p class="text-gray-500 text-sm mt-1">Unggah dokumen persyaratan jalur {{ $pendaftaran->jalur->nama_jalur }}.</p>
                </div>
                <div class="bg-{{ $pendaftaran->berkas ? 'green' : 'red' }}-100 text-{{ $pendaftaran->berkas ? 'green' : 'red' }}-600 p-3 rounded-full">
                    <i class="fi fi-rs-{{ $pendaftaran->berkas ? 'check-circle' : 'document' }} text-xl"></i>
                </div>
            </div>
            <div class="mt-6">
                @if ($pendaftaran->berkas)
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                        Selesai Diupload
                    </span>
                    <a href="{{ route('berkas.edit', $pendaftaran->berkas->id) }}" class="block text-center mt-4 w-full bg-gray-100 hover:bg-gray-200 text-gray-800 font-medium py-2 rounded-lg transition-colors">Lihat Berkas</a>
                @else
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800">
                        Belum Diupload
                    </span>
                    @if(!$isBiodataComplete)
                        <button class="mt-4 w-full bg-emerald-600 hover:bg-emerald-700 text-white font-medium py-2 rounded-lg shadow transition-colors opacity-50 cursor-not-allowed" disabled title="Lengkapi biodata terlebih dahulu">Upload Berkas</button>
                    @else
                        <a href="{{ route('berkas.create') }}" class="block text-center mt-4 w-full bg-emerald-600 hover:bg-emerald-700 text-white font-medium py-2 rounded-lg shadow transition-colors">Upload Berkas</a>
                    @endif
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
