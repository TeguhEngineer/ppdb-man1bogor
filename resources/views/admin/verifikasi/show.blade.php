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

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-10">
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
                            <li
                                class="flex items-center justify-between p-3 border rounded-lg hover:bg-gray-50 transition-colors">
                                <div class="flex items-center">
                                    <i class="fi fi-rs-document-signed text-emerald-500 text-xl mr-3"></i>
                                    <div>
                                        <p class="font-medium text-sm text-gray-900">Raport Terakhir</p>
                                    </div>
                                </div>
                                <a href="{{ Storage::url($pendaftaran->berkas->file_raport) }}" target="_blank"
                                    class="text-sm font-medium text-emerald-600 hover:text-emerald-900 bg-emerald-50 px-3 py-1 rounded-md">Lihat
                                    / Unduh</a>
                            </li>
                            <li
                                class="flex items-center justify-between p-3 border rounded-lg hover:bg-gray-50 transition-colors">
                                <div class="flex items-center">
                                    <i class="fi fi-rs-id-badge text-emerald-500 text-xl mr-3"></i>
                                    <div>
                                        <p class="font-medium text-sm text-gray-900">Scan NISN</p>
                                    </div>
                                </div>
                                <a href="{{ Storage::url($pendaftaran->berkas->file_nisn) }}" target="_blank"
                                    class="text-sm font-medium text-emerald-600 hover:text-emerald-900 bg-emerald-50 px-3 py-1 rounded-md">Lihat
                                    / Unduh</a>
                            </li>
                            <li
                                class="flex items-center justify-between p-3 border rounded-lg hover:bg-gray-50 transition-colors">
                                <div class="flex items-center">
                                    <i class="fi fi-rs-picture text-emerald-500 text-xl mr-3"></i>
                                    <div>
                                        <p class="font-medium text-sm text-gray-900">Pas Foto</p>
                                    </div>
                                </div>
                                <a href="{{ Storage::url($pendaftaran->berkas->file_foto) }}" target="_blank"
                                    class="text-sm font-medium text-emerald-600 hover:text-emerald-900 bg-emerald-50 px-3 py-1 rounded-md">Lihat
                                    / Unduh</a>
                            </li>
                            <li
                                class="flex items-center justify-between p-3 border rounded-lg hover:bg-gray-50 transition-colors">
                                <div class="flex items-center">
                                    <i class="fi fi-rs-memo text-emerald-500 text-xl mr-3"></i>
                                    <div>
                                        <p class="font-medium text-sm text-gray-900">Surat Keterangan Aktif / SKL</p>
                                    </div>
                                </div>
                                <a href="{{ Storage::url($pendaftaran->berkas->file_surat_keterangan_aktif) }}"
                                    target="_blank"
                                    class="text-sm font-medium text-emerald-600 hover:text-emerald-900 bg-emerald-50 px-3 py-1 rounded-md">Lihat
                                    / Unduh</a>
                            </li>
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

        <!-- Sidebar Content: Status Update (Span 1 col) -->
        <div class="space-y-6">
            <div class="bg-white overflow-hidden shadow-sm rounded-xl border border-gray-100">
                <div class="px-6 py-4 border-b border-gray-100 bg-gray-50">
                    <h3 class="font-bold text-lg text-gray-800">Verifikasi & Status</h3>
                </div>
                <div class="p-6">

                    @if (session('success'))
                        <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative text-sm"
                            role="alert">
                            <strong class="font-bold">Berhasil!</strong>
                            <span class="block sm:inline">{{ session('success') }}</span>
                        </div>
                    @endif

                    <div class="mb-6">
                        <p class="text-sm text-gray-500 font-medium mb-1">Status Saat Ini:</p>
                        @php
                            $statusColors = [
                                'pending' => 'bg-yellow-100 text-yellow-800 border-yellow-200',
                                'verifikasi' => 'bg-blue-100 text-blue-800 border-blue-200',
                                'tes' => 'bg-purple-100 text-purple-800 border-purple-200',
                                'lulus' => 'bg-green-100 text-green-800 border-green-200',
                                'tidak_lulus' => 'bg-red-100 text-red-800 border-red-200',
                            ];
                            $statusLabels = [
                                'pending' => 'Pending (Belum Diproses)',
                                'verifikasi' => 'Sedang / Selesai Verifikasi',
                                'tes' => 'Tahap Tes / Wawancara',
                                'lulus' => 'Lulus',
                                'tidak_lulus' => 'Tidak Lulus',
                            ];
                        @endphp
                        <div
                            class="px-4 py-3 border rounded-lg {{ $statusColors[$pendaftaran->status_pendaftaran] }} font-bold text-center uppercase tracking-wide">
                            {{ $statusLabels[$pendaftaran->status_pendaftaran] }}
                        </div>
                    </div>

                    <form action="{{ route('admin.verifikasi.update', $pendaftaran->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-4">
                            <label for="status_pendaftaran" class="block text-sm font-medium text-gray-700 mb-1">Ubah
                                Status Menjadi:</label>
                            <select name="status_pendaftaran" id="status_pendaftaran"
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500"
                                required>
                                <option value="pending" {{ $pendaftaran->status_pendaftaran == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="verifikasi" {{ $pendaftaran->status_pendaftaran == 'verifikasi' ? 'selected' : '' }}>Verifikasi</option>
                                <option value="tes" {{ $pendaftaran->status_pendaftaran == 'tes' ? 'selected' : '' }}>Tes
                                    / Wawancara</option>
                                <option value="lulus" {{ $pendaftaran->status_pendaftaran == 'lulus' ? 'selected' : '' }}>
                                    Lulus</option>
                                <option value="tidak_lulus" {{ $pendaftaran->status_pendaftaran == 'tidak_lulus' ? 'selected' : '' }}>Tidak Lulus</option>
                            </select>
                            @error('status_pendaftaran')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <button type="submit"
                            class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-medium py-2.5 px-4 rounded-lg shadow-sm transition-colors">
                            Simpan Perubahan Status
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
    </div>
</x-app-layout>
