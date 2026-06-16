<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <a href="{{ route('admin.verifikasi.index') }}"
                class="text-lg text-emerald-600 hover:text-emerald-900 font-medium">
                &larr;
            </a>
            <h2 class="font-bold text-xl text-gray-800 leading-tight">
                {{ __('Detail Pendaftar: ') }} {{ $pendaftaran->user->name }}
            </h2>
            
        </div>
    </x-slot>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-10" x-data="{ openBerkasModal: false }">
        <!-- Main Content: Biodata & Berkas (Span 2 cols) -->
        <div class="lg:col-span-2 space-y-6">

            <!-- Biodata Card -->
            <div class="bg-white overflow-hidden shadow-sm rounded-xl border border-gray-100">
                <div class="px-6 py-4 border-b border-gray-100 bg-gray-50 flex justify-between items-center">
                    <h3 class="font-bold text-lg text-gray-800">Biodata Peserta</h3>
                    @if($pendaftaran->biodata)
                        <span
                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">Tersedia</span>
                    @else
                        <span
                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">Belum
                            Mengisi</span>
                    @endif
                </div>

                @if($pendaftaran->biodata)
                    <div class="p-6">
                        <dl class="grid grid-cols-1 md:grid-cols-2 gap-x-4 gap-y-6 text-sm">
                            <!-- Data Pribadi -->
                            <div class="md:col-span-2">
                                <h4 class="font-semibold text-gray-900 border-b pb-1">Data Pribadi</h4>
                            </div>
                            <div>
                                <dt class="text-gray-500 font-medium">Nama Lengkap</dt>
                                <dd class="text-gray-900 mt-1">{{ $pendaftaran->biodata->nama_lengkap }}</dd>
                            </div>
                            <div>
                                <dt class="text-gray-500 font-medium">NIK</dt>
                                <dd class="text-gray-900 mt-1">{{ $pendaftaran->biodata->nik }}</dd>
                            </div>
                            <div>
                                <dt class="text-gray-500 font-medium">Tempat, Tgl Lahir</dt>
                                <dd class="text-gray-900 mt-1">{{ $pendaftaran->biodata->tempat_lahir }},
                                    {{ \Carbon\Carbon::parse($pendaftaran->biodata->tanggal_lahir)->format('d M Y') }}</dd>
                            </div>
                            <div>
                                <dt class="text-gray-500 font-medium">Jenis Kelamin</dt>
                                <dd class="text-gray-900 mt-1 capitalize">{{ $pendaftaran->biodata->jenis_kelamin }}</dd>
                            </div>
                            <div>
                                <dt class="text-gray-500 font-medium">No. KK</dt>
                                <dd class="text-gray-900 mt-1">{{ $pendaftaran->biodata->no_kk }}</dd>
                            </div>
                            <div>
                                <dt class="text-gray-500 font-medium">Agama</dt>
                                <dd class="text-gray-900 mt-1">{{ $pendaftaran->biodata->agama }}</dd>
                            </div>
                            <div>
                                <dt class="text-gray-500 font-medium">No. Whatsapp</dt>
                                <dd class="text-gray-900 mt-1">{{ $pendaftaran->biodata->no_whatsapp }}</dd>
                            </div>

                            <!-- Data Alamat -->
                            <div class="md:col-span-2 mt-2">
                                <h4 class="font-semibold text-gray-900 border-b pb-1">Data Alamat</h4>
                            </div>
                            <div class="md:col-span-2">
                                <dt class="text-gray-500 font-medium">Alamat Lengkap</dt>
                                <dd class="text-gray-900 mt-1">{{ $pendaftaran->biodata->alamat }}, Desa/Kel.
                                    {{ $pendaftaran->biodata->desa }}, Kec. {{ $pendaftaran->biodata->kecamatan }},
                                    Kab/Kota. {{ $pendaftaran->biodata->kabupaten }}, {{ $pendaftaran->biodata->provinsi }}
                                    - {{ $pendaftaran->biodata->kode_pos }}</dd>
                            </div>

                            <!-- Data Pendidikan -->
                            <div class="md:col-span-2 mt-2">
                                <h4 class="font-semibold text-gray-900 border-b pb-1">Data Pendidikan</h4>
                            </div>
                            <div>
                                <dt class="text-gray-500 font-medium">Asal Sekolah</dt>
                                <dd class="text-gray-900 mt-1">{{ $pendaftaran->biodata->asal_satuan_pendidikan }} -
                                    {{ $pendaftaran->biodata->nama_asal_sekolah }}</dd>
                            </div>
                            <div>
                                <dt class="text-gray-500 font-medium">NPSN</dt>
                                <dd class="text-gray-900 mt-1">{{ $pendaftaran->biodata->npsn ?? '-' }}</dd>
                            </div>

                            <!-- Data Orang Tua -->
                            <div class="md:col-span-2 mt-2">
                                <h4 class="font-semibold text-gray-900 border-b pb-1">Data Orang Tua</h4>
                            </div>
                            <div>
                                <dt class="text-gray-500 font-medium">Nama Ayah</dt>
                                <dd class="text-gray-900 mt-1">{{ $pendaftaran->biodata->nama_ayah ?? '-' }}</dd>
                            </div>
                            <div>
                                <dt class="text-gray-500 font-medium">Pekerjaan Ayah</dt>
                                <dd class="text-gray-900 mt-1">{{ $pendaftaran->biodata->pekerjaan_ayah ?? '-' }}</dd>
                            </div>
                            <div>
                                <dt class="text-gray-500 font-medium">Nama Ibu</dt>
                                <dd class="text-gray-900 mt-1">{{ $pendaftaran->biodata->nama_ibu ?? '-' }}</dd>
                            </div>
                            <div>
                                <dt class="text-gray-500 font-medium">Pekerjaan Ibu</dt>
                                <dd class="text-gray-900 mt-1">{{ $pendaftaran->biodata->pekerjaan_ibu ?? '-' }}</dd>
                            </div>
                        </dl>
                    </div>
                @else
                    <div class="p-8 text-center text-gray-500">
                        <i class="fi fi-rs-document text-3xl mb-3 block text-gray-300"></i>
                        Peserta belum mengisi form biodata.
                    </div>
                @endif
            </div>

            <!-- Berkas Card -->
            <div class="bg-white overflow-hidden shadow-sm rounded-xl border border-gray-100">
                <div class="px-6 py-4 border-b border-gray-100 bg-gray-50 flex justify-between items-center">
                    <h3 class="font-bold text-lg text-gray-800">Dokumen Berkas</h3>
                    @if($pendaftaran->berkas)
                        <span
                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">Tersedia</span>
                    @else
                        <span
                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">Belum
                            Diupload</span>
                    @endif
                </div>

                @if($pendaftaran->berkas)
                    <div class="p-6">
                        <ul class="space-y-3">
                            @php
                                $dokumenBerkas = [
                                    ['label' => 'Raport Terakhir', 'field' => 'file_raport', 'icon' => 'fi-rs-document-signed'],
                                    ['label' => 'Scan NISN', 'field' => 'file_nisn', 'icon' => 'fi-rs-id-badge'],
                                    ['label' => 'Pas Foto', 'field' => 'file_foto', 'icon' => 'fi-rs-picture'],
                                    ['label' => 'Surat Keterangan Aktif / SKL', 'field' => 'file_surat_keterangan_aktif', 'icon' => 'fi-rs-memo'],
                                    ['label' => 'Kartu Keluarga', 'field' => 'file_kk', 'icon' => 'fi-rs-users'],
                                    ['label' => 'Slip Gaji Orang Tua', 'field' => 'file_slip_gaji', 'icon' => 'fi-rs-money-bill-wave'],
                                ];

                                if ($pendaftaran->jalur->nama_jalur === 'Prestasi') {
                                    $dokumenBerkas[] = ['label' => 'Piagam/Sertifikat Kejuaraan', 'field' => 'file_sertifikat', 'icon' => 'fi-rs-diploma'];
                                }

                                if ($pendaftaran->jalur->nama_jalur === 'Afirmasi') {
                                    $dokumenBerkas[] = ['label' => 'Surat Keterangan Tidak Mampu (SKTM)', 'field' => 'file_sktm', 'icon' => 'fi-rs-document'];
                                    $dokumenBerkas[] = ['label' => 'Kartu KIP', 'field' => 'file_kip', 'icon' => 'fi-rs-credit-card'];
                                }
                            @endphp
                            @foreach($dokumenBerkas as $dokumen)
                                @php $filePath = $pendaftaran->berkas->{$dokumen['field']}; @endphp
                                <li
                                    class="flex items-center justify-between gap-3 p-3 border rounded-lg hover:bg-gray-50 transition-colors">
                                    <div class="flex items-center">
                                        <i class="fi {{ $dokumen['icon'] }} text-emerald-500 text-xl mr-3"></i>
                                        <div>
                                            <p class="font-medium text-sm text-gray-900">{{ $dokumen['label'] }}</p>
                                        </div>
                                    </div>
                                    @if($filePath)
                                        <a href="{{ Storage::url($filePath) }}" target="_blank"
                                            class="text-sm font-medium text-emerald-600 hover:text-emerald-900 bg-emerald-50 px-3 py-1 rounded-md whitespace-nowrap">
                                            Lihat / Unduh
                                        </a>
                                    @else
                                        <span class="text-xs font-medium text-gray-400 whitespace-nowrap">Belum diunggah</span>
                                    @endif
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @else
                    <div class="p-8 text-center text-gray-500">
                        <i class="fi fi-rs-folder-upload text-3xl mb-3 block text-gray-300"></i>
                        Peserta belum mengunggah berkas persyaratan.
                    </div>
                @endif
            </div>

            <!-- Uploaded on Biodata -->
            @if($pendaftaran->biodata && ($pendaftaran->biodata->kartu_keluarga || $pendaftaran->biodata->slip_gaji || $pendaftaran->biodata->sertifikat))
                <div class="bg-white overflow-hidden shadow-sm rounded-xl border border-gray-100">
                    <div class="px-6 py-4 border-b border-gray-100 bg-gray-50 flex justify-between items-center">
                        <h3 class="font-bold text-lg text-gray-800">Dokumen Pendukung (Biodata)</h3>
                    </div>
                    <div class="p-6">
                        <ul class="space-y-3">
                            @if($pendaftaran->biodata->kartu_keluarga)
                                <li
                                    class="flex items-center justify-between p-3 border rounded-lg hover:bg-gray-50 transition-colors">
                                    <div class="flex items-center">
                                        <i class="fi fi-rs-users text-emerald-500 text-xl mr-3"></i>
                                        <div>
                                            <p class="font-medium text-sm text-gray-900">Kartu Keluarga</p>
                                        </div>
                                    </div>
                                    <a href="{{ Storage::url($pendaftaran->biodata->kartu_keluarga) }}" target="_blank"
                                        class="text-sm font-medium text-emerald-600 hover:text-emerald-900 bg-emerald-50 px-3 py-1 rounded-md">Lihat
                                        / Unduh</a>
                                </li>
                            @endif
                            @if($pendaftaran->biodata->slip_gaji)
                                <li
                                    class="flex items-center justify-between p-3 border rounded-lg hover:bg-gray-50 transition-colors">
                                    <div class="flex items-center">
                                        <i class="fi fi-rs-money-bill-wave text-emerald-500 text-xl mr-3"></i>
                                        <div>
                                            <p class="font-medium text-sm text-gray-900">Slip Gaji / Penghasilan</p>
                                        </div>
                                    </div>
                                    <a href="{{ Storage::url($pendaftaran->biodata->slip_gaji) }}" target="_blank"
                                        class="text-sm font-medium text-emerald-600 hover:text-emerald-900 bg-emerald-50 px-3 py-1 rounded-md">Lihat
                                        / Unduh</a>
                                </li>
                            @endif
                            @if($pendaftaran->biodata->sertifikat)
                                <li
                                    class="flex items-center justify-between p-3 border rounded-lg hover:bg-gray-50 transition-colors">
                                    <div class="flex items-center">
                                        <i class="fi fi-rs-diploma text-emerald-500 text-xl mr-3"></i>
                                        <div>
                                            <p class="font-medium text-sm text-gray-900">Sertifikat Prestasi</p>
                                        </div>
                                    </div>
                                    <a href="{{ Storage::url($pendaftaran->biodata->sertifikat) }}" target="_blank"
                                        class="text-sm font-medium text-emerald-600 hover:text-emerald-900 bg-emerald-50 px-3 py-1 rounded-md">Lihat
                                        / Unduh</a>
                                </li>
                            @endif
                        </ul>
                    </div>
                </div>
            @endif

        </div>

        <!-- Sidebar Content: Berkas Verification & Selection Result (Span 1 col) -->
        <div class="space-y-6">
            <div class="bg-white overflow-hidden shadow-sm rounded-xl border border-gray-100">
                <div class="px-6 py-4 border-b border-gray-100 bg-gray-50">
                    <h3 class="font-bold text-lg text-gray-800">Verifikasi Berkas</h3>
                </div>
                <div class="p-6">
                    @if (session('success'))
                        <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative text-sm"
                            role="alert">
                            <strong class="font-bold">Berhasil!</strong>
                            <span class="block sm:inline">{{ session('success') }}</span>
                        </div>
                    @endif

                    @if($pendaftaran->berkas)
                        @php
                            $statusBerkas = $pendaftaran->berkas->status_berkas;
                            $statusBerkasStyles = [
                                'terima' => 'bg-green-100 text-green-800 border-green-200',
                                'tolak' => 'bg-red-100 text-red-800 border-red-200',
                                null => 'bg-gray-100 text-gray-800 border-gray-200',
                            ];
                            $statusBerkasLabels = [
                                'terima' => 'Berkas Diterima',
                                'tolak' => 'Berkas Ditolak',
                                null => 'Berkas Belum Diverifikasi',
                            ];
                        @endphp
                        <div class="mb-4 p-4 rounded-lg border {{ $statusBerkasStyles[$statusBerkas] }}">
                            <p class="text-sm font-semibold uppercase tracking-wide">
                                {{ $statusBerkasLabels[$statusBerkas] }}
                            </p>
                            @if($pendaftaran->berkas->pesan)
                                <p class="mt-1 text-sm">
                                    {{ $pendaftaran->berkas->pesan }}
                                </p>
                            @endif
                        </div>

                        @error('status_berkas')
                            <p class="mb-3 text-sm text-red-600">{{ $message }}</p>
                        @enderror

                        <div class="flex items-center gap-2">
                            <form action="{{ route('admin.verifikasi.berkas-status', $pendaftaran->id) }}" method="POST" class="flex-1">
                                @csrf
                                <input type="hidden" name="status_berkas" value="terima">
                                <button type="submit"
                                    class="w-full inline-flex justify-center items-center px-3 py-2 rounded-lg bg-green-600 text-white text-sm font-semibold hover:bg-green-700 transition-colors">
                                    <i class="fi fi-rs-check mr-1.5"></i> Terima
                                </button>
                            </form>
                            <button type="button" @click="openBerkasModal = true"
                                class="flex-1 inline-flex justify-center items-center px-3 py-2 rounded-lg bg-red-600 text-white text-sm font-semibold hover:bg-red-700 transition-colors">
                                <i class="fi fi-rs-cross-small mr-1.5"></i> Tolak
                            </button>
                        </div>
                    @else
                        <div class="p-4 bg-red-50 border border-red-200 rounded-lg text-sm text-red-700">
                            Peserta belum mengunggah berkas.
                        </div>
                    @endif
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm rounded-xl border border-gray-100">
                <div class="px-6 py-4 border-b border-gray-100 bg-gray-50">
                    <h3 class="font-bold text-lg text-gray-800">Hasil Seleksi</h3>
                </div>
                <div class="p-6">
                    @php
                        $hasilSeleksiColors = [
                            'lulus' => 'bg-green-100 text-green-800 border-green-200',
                            'tidak_lulus' => 'bg-red-100 text-red-800 border-red-200',
                        ];
                        $hasilSeleksiLabels = [
                            'lulus' => 'Lulus',
                            'tidak_lulus' => 'Tidak Lulus',
                        ];
                        $hasilSeleksi = in_array($pendaftaran->status_pendaftaran, ['lulus', 'tidak_lulus'], true)
                            ? $pendaftaran->status_pendaftaran
                            : null;
                    @endphp

                    <div class="mb-6">
                        <p class="text-sm text-gray-500 font-medium mb-1">Status Hasil:</p>
                        @if($hasilSeleksi)
                            <div
                                class="px-4 py-3 border rounded-lg {{ $hasilSeleksiColors[$hasilSeleksi] }} font-bold text-center uppercase tracking-wide">
                                {{ $hasilSeleksiLabels[$hasilSeleksi] }}
                            </div>
                        @else
                            <div
                                class="px-4 py-3 border rounded-lg bg-gray-100 text-gray-800 border-gray-200 font-bold text-center uppercase tracking-wide">
                                Belum Ditentukan
                            </div>
                        @endif
                    </div>

                    <form action="{{ route('admin.verifikasi.update', $pendaftaran->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-4">
                            <label for="status_pendaftaran" class="block text-sm font-medium text-gray-700 mb-1">Ubah
                                Hasil Menjadi:</label>
                            <select name="status_pendaftaran" id="status_pendaftaran"
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500"
                                required>
                                <option value="lulus" {{ $pendaftaran->status_pendaftaran == 'lulus' ? 'selected' : '' }}>Lulus</option>
                                <option value="tidak_lulus" {{ $pendaftaran->status_pendaftaran == 'tidak_lulus' ? 'selected' : '' }}>Tidak Lulus</option>
                            </select>
                            @error('status_pendaftaran')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        @if (!$pendaftaran->isLengkap())
                            <div class="mb-4 p-3 bg-red-50 border border-red-200 rounded-lg">
                                <p class="text-xs text-red-700 font-medium leading-relaxed">
                                    <i class="fi fi-rs-exclamation mr-1"></i>
                                    Peserta belum melengkapi biodata atau berkas wajib. Perubahan status dinonaktifkan.
                                </p>
                            </div>
                        @endif
                        @if (!$pendaftaran->berkas || $pendaftaran->berkas->status_berkas !== 'terima')
                            <div class="mb-4 p-3 bg-yellow-50 border border-yellow-200 rounded-lg">
                                <p class="text-xs text-yellow-800 font-medium leading-relaxed">
                                    <i class="fi fi-rs-exclamation mr-1"></i>
                                    Hasil seleksi dapat disimpan setelah berkas diterima.
                                </p>
                            </div>
                        @endif

                        <button type="submit"
                            class="w-full {{ $pendaftaran->isLengkap() && $pendaftaran->berkas && $pendaftaran->berkas->status_berkas === 'terima' ? 'bg-emerald-600 hover:bg-emerald-700' : 'bg-gray-400 cursor-not-allowed' }} text-white font-medium py-2.5 px-4 rounded-lg shadow-sm transition-colors"
                            {{ $pendaftaran->isLengkap() && $pendaftaran->berkas && $pendaftaran->berkas->status_berkas === 'terima' ? '' : 'disabled' }}>
                            Simpan Hasil Seleksi
                        </button>
                    </form>
                </div>
            </div>

            <!-- Quick Info -->
            <div class="bg-emerald-50 overflow-hidden shadow-sm rounded-xl border border-emerald-100 p-6">
                <h4 class="font-bold text-emerald-900 mb-3 text-sm uppercase tracking-wider">Informasi Pendaftaran</h4>
                <ul class="space-y-2 text-sm text-emerald-800">
                    <li class="flex justify-between">
                        <span class="font-medium opacity-70">Jalur</span>
                        <span class="font-bold">{{ $pendaftaran->jalur->nama_jalur }}</span>
                    </li>
                    <li class="flex justify-between">
                        <span class="font-medium opacity-70">Tanggal Daftar</span>
                        <span class="font-bold">{{ $pendaftaran->created_at->format('d M Y') }}</span>
                    </li>
                    <li class="flex justify-between">
                        <span class="font-medium opacity-70">Kampus</span>
                        <span class="font-bold">{{ $pendaftaran->kampus }}</span>
                    </li>
                </ul>
            </div>
        </div>

        @if($pendaftaran->berkas)
            <div x-show="openBerkasModal" x-cloak class="fixed inset-0 z-50 overflow-y-auto">
                <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
                    <div x-show="openBerkasModal" x-transition:enter="ease-out duration-300"
                        x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                        x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100"
                        x-transition:leave-end="opacity-0" class="fixed inset-0 transition-opacity" aria-hidden="true">
                        <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
                    </div>

                    <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                    <div x-show="openBerkasModal" x-transition:enter="ease-out duration-300"
                        x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                        x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                        x-transition:leave="ease-in duration-200"
                        x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                        x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                        class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                        <form method="POST" action="{{ route('admin.verifikasi.berkas-status', $pendaftaran->id) }}">
                            @csrf
                            <input type="hidden" name="status_berkas" value="tolak">
                            <div class="bg-white px-6 pt-6 pb-4 sm:p-8 sm:pb-4">
                                <div class="flex items-center justify-between mb-6">
                                    <h3 class="text-lg font-bold text-gray-900">Tolak Berkas</h3>
                                    <button type="button" @click="openBerkasModal = false"
                                        class="text-gray-400 hover:text-gray-500">
                                        <i class="fi fi-rs-cross-small text-2xl"></i>
                                    </button>
                                </div>

                                <p class="text-sm text-gray-600 mb-4">
                                    Berkas peserta <span class="font-semibold">{{ $pendaftaran->user->name }}</span> akan ditolak.
                                </p>

                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">Catatan Penolakan</label>
                                    <textarea name="pesan" rows="4"
                                        class="w-full rounded-lg border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500 text-sm"
                                        placeholder="Tuliskan alasan penolakan berkas">{{ old('pesan', $pendaftaran->berkas->pesan) }}</textarea>
                                    @error('pesan')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="bg-gray-50 px-6 py-4 sm:px-8 sm:flex sm:flex-row-reverse gap-2">
                                <button type="submit"
                                    class="w-full inline-flex justify-center rounded-lg border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:w-auto sm:text-sm">
                                    Simpan Penolakan
                                </button>
                                <button type="button" @click="openBerkasModal = false"
                                    class="mt-3 w-full inline-flex justify-center rounded-lg border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:mt-0 sm:w-auto sm:text-sm">
                                    Batal
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endif
    </div>
</x-app-layout>
