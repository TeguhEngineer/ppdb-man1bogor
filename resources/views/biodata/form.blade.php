<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-gray-800 leading-tight">
            {{ __('Isi Biodata') }}
        </h2>
    </x-slot>

    @php
        $tabs = [
            'registrasi' => 'Registrasi',
            'pribadi' => 'Data Pribadi',
            'alamat' => 'Alamat',
            'pendidikan' => 'Pendidikan',
            'prestasi' => 'Penunjang Prestasi',
            'ayah' => 'Data Ayah',
            'ibu' => 'Data Ibu',
            'wali' => 'Data Wali',
            'berkas' => 'Berkas',
        ];
        $tabKeys = array_keys($tabs);
        $activeTabIndex = array_search($activeTab, $tabKeys, true);
        $nextTab = $activeTabIndex !== false && isset($tabKeys[$activeTabIndex + 1]) ? $tabKeys[$activeTabIndex + 1] : null;
        $isLocked = in_array($pendaftaran->status_pendaftaran, ['verifikasi', 'tes', 'lulus', 'tidak_lulus'], true);
        $inputClass = 'mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500';
        $fileClass = 'mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100';
        $field = fn ($model, $name) => old($name, optional($model)->{$name});
        $fieldError = fn (string $name) => $errors->has($name) ? '<p class="mt-1 text-xs text-red-600 font-medium">'.e($errors->first($name)).'</p>' : '';
        $nextButton = fn (?string $tab) => $tab ? '<button type="submit" name="next_tab" value="'.$tab.'" class="w-full sm:w-auto px-6 py-3 rounded-lg bg-gray-100 text-gray-800 font-semibold hover:bg-gray-200">Simpan & Lanjut</button>' : '';
    @endphp

    <div class="bg-white overflow-hidden shadow-sm rounded-xl border border-blue-100 mb-6">
        <div class="p-6 md:p-8 flex flex-col md:flex-row justify-between gap-4">
            <div>
                <h3 class="text-lg font-bold text-blue-800 mb-2 flex items-center">
                    <i class="fi fi-rs-info text-blue-600 mr-2"></i> Pengisian Biodata Bertahap
                </h3>
                <ul class="list-disc list-inside text-sm text-gray-600 space-y-1">
                    <li>Setiap tab menyimpan data ke tabel terpisah.</li>
                    <li>Tab Berkas memakai tabel berkas yang sudah ada.</li>
                    <li>Data lama tetap disinkronkan ke tabel biodata untuk fitur cetak, verifikasi, dan kartu ujian.</li>
                </ul>
            </div>
            <div class="shrink-0 bg-gray-50 px-6 py-4 rounded-lg border border-gray-100 text-center">
                <p class="text-xs text-gray-500 uppercase tracking-wider font-semibold mb-1">Status Biodata</p>
                @if($pendaftaran->isBiodataLengkap())
                    <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-bold bg-green-100 text-green-800">
                        <i class="fi fi-rs-check-circle mr-2"></i> Lengkap
                    </span>
                @else
                    <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-bold bg-yellow-100 text-yellow-800">
                        <i class="fi fi-rs-exclamation mr-2"></i> Belum Lengkap
                    </span>
                @endif
            </div>
        </div>
    </div>

    @if ($errors->any())
        <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-xl" role="alert">
            <strong class="font-bold">Ada kesalahan!</strong>
            <ul class="mt-2 list-disc list-inside text-sm">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if (session('success'))
        <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-xl" role="alert">
            <strong class="font-bold">Berhasil!</strong>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    @if (session('error'))
        <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-xl" role="alert">
            <strong class="font-bold">Gagal!</strong>
            <span>{{ session('error') }}</span>
        </div>
    @endif

    <div class="bg-white shadow-sm rounded-xl border border-gray-100 mb-10 overflow-hidden">
        <div class="border-b border-gray-100 bg-gray-50">
            <nav class="grid grid-cols-2 sm:grid-cols-3 lg:flex lg:flex-wrap gap-2 p-3 md:p-4">
                @foreach($tabs as $key => $label)
                    <a href="{{ $biodatum ? route('biodata.edit', ['biodatum' => $biodatum->id, 'tab' => $key]) : route('biodata.create', ['tab' => $key]) }}"
                        class="min-h-11 inline-flex items-center justify-center text-center px-3 md:px-4 py-2 rounded-lg text-xs sm:text-sm font-semibold leading-tight transition-colors {{ $activeTab === $key ? 'bg-emerald-600 text-white shadow-sm' : 'bg-white text-gray-600 hover:bg-gray-100 border border-gray-200' }}">
                        {{ $label }}
                    </a>
                @endforeach
            </nav>
        </div>

        <div class="p-6 md:p-8">
            @if($isLocked && $activeTab !== 'berkas')
                <div class="mb-6 bg-green-100 border border-green-300 text-green-800 px-4 py-3 rounded-lg">
                    <strong>Data sudah masuk tahap verifikasi.</strong>
                    <span class="block">Biodata dan berkas tidak dapat diubah saat ini.</span>
                </div>
            @endif

            @if($activeTab === 'registrasi')
                <form action="{{ route('biodata.tab.update', 'registrasi') }}" method="POST" class="space-y-6">
                    @csrf
                    <fieldset @if($isLocked) disabled @endif>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">NISN <span class="text-red-500">*</span></label>
                                <input type="text" name="nisn" value="{{ old('nisn', $pendaftaran->nisn) }}" class="{{ $inputClass }}" required>
                                {!! $fieldError('nisn') !!}
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Jalur Pendaftaran <span class="text-red-500">*</span></label>
                                <select name="jalur_id" class="{{ $inputClass }}" required>
                                    @foreach($jalurs as $jalur)
                                        <option value="{{ $jalur->id }}" @selected(old('jalur_id', $pendaftaran->jalur_id) == $jalur->id)>{{ $jalur->nama_jalur }}</option>
                                    @endforeach
                                </select>
                                {!! $fieldError('jalur_id') !!}
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Pilihan Kampus <span class="text-red-500">*</span></label>
                                <select name="kampus" class="{{ $inputClass }}" required>
                                        <option value="MAN 1 BOGOR">MAN 1 BOGOR</option>
                                </select>
                                {!! $fieldError('kampus') !!}
                            </div>
                        </div>
                    </fieldset>
                    @unless($isLocked)
                        <div class="flex flex-col sm:flex-row sm:justify-end gap-3 border-t pt-6">
                            {!! $nextButton($nextTab) !!}
                            <button class="px-6 py-3 rounded-lg bg-emerald-600 text-white font-semibold hover:bg-emerald-700">Simpan Registrasi</button>
                        </div>
                    @endunless
                </form>
            @endif

            @if($activeTab === 'pribadi')
                <form action="{{ route('biodata.tab.update', 'pribadi') }}" method="POST" class="space-y-6">
                    @csrf
                    <fieldset @if($isLocked) disabled @endif>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Nama Lengkap <span class="text-red-500">*</span></label>
                                <input name="nama_lengkap" value="{{ $field($pendaftaran->dataPribadi, 'nama_lengkap') }}" class="{{ $inputClass }}" required>
                                {!! $fieldError('nama_lengkap') !!}
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">NIK <span class="text-red-500">*</span></label>
                                <input name="nik" value="{{ $field($pendaftaran->dataPribadi, 'nik') }}" class="{{ $inputClass }}" required>
                                {!! $fieldError('nik') !!}
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Tempat Lahir <span class="text-red-500">*</span></label>
                                <input name="tempat_lahir" value="{{ $field($pendaftaran->dataPribadi, 'tempat_lahir') }}" class="{{ $inputClass }}" required>
                                {!! $fieldError('tempat_lahir') !!}
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Tanggal Lahir <span class="text-red-500">*</span></label>
                                <input type="date" name="tanggal_lahir" value="{{ $field($pendaftaran->dataPribadi, 'tanggal_lahir') }}" class="{{ $inputClass }}" required>
                                {!! $fieldError('tanggal_lahir') !!}
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Jenis Kelamin <span class="text-red-500">*</span></label>
                                <select name="jenis_kelamin" class="{{ $inputClass }}" required>
                                    <option value="">Pilih</option>
                                    <option value="laki-laki" @selected($field($pendaftaran->dataPribadi, 'jenis_kelamin') === 'laki-laki')>Laki-laki</option>
                                    <option value="perempuan" @selected($field($pendaftaran->dataPribadi, 'jenis_kelamin') === 'perempuan')>Perempuan</option>
                                </select>
                                {!! $fieldError('jenis_kelamin') !!}
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Nomor KK <span class="text-red-500">*</span></label>
                                <input name="no_kk" value="{{ $field($pendaftaran->dataPribadi, 'no_kk') }}" class="{{ $inputClass }}" required>
                                {!! $fieldError('no_kk') !!}
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Tinggi Badan <span class="text-red-500">*</span></label>
                                <input type="number" name="tinggi_badan" value="{{ $field($pendaftaran->dataPribadi, 'tinggi_badan') }}" class="{{ $inputClass }}" required>
                                {!! $fieldError('tinggi_badan') !!}
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Berat Badan <span class="text-red-500">*</span></label>
                                <input type="number" name="berat_badan" value="{{ $field($pendaftaran->dataPribadi, 'berat_badan') }}" class="{{ $inputClass }}" required>
                                {!! $fieldError('berat_badan') !!}
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Status Dalam Keluarga <span class="text-red-500">*</span></label>
                                <input name="status_dalam_keluarga" value="{{ $field($pendaftaran->dataPribadi, 'status_dalam_keluarga') }}" class="{{ $inputClass }}" required>
                                {!! $fieldError('status_dalam_keluarga') !!}
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Tinggal Bersama <span class="text-red-500">*</span></label>
                                <input name="tinggal_bersama" value="{{ $field($pendaftaran->dataPribadi, 'tinggal_bersama') }}" class="{{ $inputClass }}" required>
                                {!! $fieldError('tinggal_bersama') !!}
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Anak Ke <span class="text-red-500">*</span></label>
                                <input type="number" name="anak_ke" value="{{ $field($pendaftaran->dataPribadi, 'anak_ke') }}" class="{{ $inputClass }}" required>
                                {!! $fieldError('anak_ke') !!}
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Jumlah Saudara <span class="text-red-500">*</span></label>
                                <input type="number" name="jumlah_saudara" value="{{ $field($pendaftaran->dataPribadi, 'jumlah_saudara') }}" class="{{ $inputClass }}" required>
                                {!! $fieldError('jumlah_saudara') !!}
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Agama <span class="text-red-500">*</span></label>
                                <input name="agama" value="{{ $field($pendaftaran->dataPribadi, 'agama') }}" class="{{ $inputClass }}" required>
                                {!! $fieldError('agama') !!}
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">No WhatsApp <span class="text-red-500">*</span></label>
                                <input name="no_whatsapp" value="{{ $field($pendaftaran->dataPribadi, 'no_whatsapp') }}" class="{{ $inputClass }}" required>
                                {!! $fieldError('no_whatsapp') !!}
                            </div>
                        </div>
                    </fieldset>
                    @unless($isLocked)
                        <div class="flex flex-col sm:flex-row sm:justify-end gap-3 border-t pt-6">
                            {!! $nextButton($nextTab) !!}
                            <button class="px-6 py-3 rounded-lg bg-emerald-600 text-white font-semibold hover:bg-emerald-700">Simpan Data Pribadi</button>
                        </div>
                    @endunless
                </form>
            @endif

            @if($activeTab === 'alamat')
                <form action="{{ route('biodata.tab.update', 'alamat') }}" method="POST" class="space-y-6">
                    @csrf
                    <fieldset @if($isLocked) disabled @endif>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700">Alamat Lengkap <span class="text-red-500">*</span></label>
                                <textarea name="alamat" class="{{ $inputClass }}" rows="3" required>{{ $field($pendaftaran->alamat, 'alamat') }}</textarea>
                                {!! $fieldError('alamat') !!}
                            </div>
                            @foreach(['desa' => 'Desa/Kelurahan', 'kecamatan' => 'Kecamatan', 'kabupaten' => 'Kabupaten/Kota', 'provinsi' => 'Provinsi', 'kode_pos' => 'Kode Pos', 'jarak_ke_sekolah' => 'Jarak ke Sekolah', 'waktu_tempuh_ke_sekolah' => 'Waktu Tempuh ke Sekolah'] as $name => $label)
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">{{ $label }} <span class="text-red-500">*</span></label>
                                    <input name="{{ $name }}" value="{{ $field($pendaftaran->alamat, $name) }}" class="{{ $inputClass }}" required>
                                    {!! $fieldError($name) !!}
                                </div>
                            @endforeach
                        </div>
                    </fieldset>
                    @unless($isLocked)
                        <div class="flex flex-col sm:flex-row sm:justify-end gap-3 border-t pt-6">
                            {!! $nextButton($nextTab) !!}
                            <button class="px-6 py-3 rounded-lg bg-emerald-600 text-white font-semibold hover:bg-emerald-700">Simpan Alamat</button>
                        </div>
                    @endunless
                </form>
            @endif

            @if($activeTab === 'pendidikan')
                <form action="{{ route('biodata.tab.update', 'pendidikan') }}" method="POST" class="space-y-6">
                    @csrf
                    <fieldset @if($isLocked) disabled @endif>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Asal Satuan Pendidikan <span class="text-red-500">*</span></label>
                                <select name="asal_satuan_pendidikan" class="{{ $inputClass }}" required>
                                    <option value="">Pilih</option>
                                    <option value="SMP" @selected($field($pendaftaran->pendidikan, 'asal_satuan_pendidikan') === 'SMP')>SMP</option>
                                    <option value="MTS" @selected($field($pendaftaran->pendidikan, 'asal_satuan_pendidikan') === 'MTS')>MTS</option>
                                </select>
                                {!! $fieldError('asal_satuan_pendidikan') !!}
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Nama Asal Sekolah <span class="text-red-500">*</span></label>
                                <input name="nama_asal_sekolah" value="{{ $field($pendaftaran->pendidikan, 'nama_asal_sekolah') }}" class="{{ $inputClass }}" required>
                                {!! $fieldError('nama_asal_sekolah') !!}
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">NPSN <span class="text-red-500">*</span></label>
                                <input name="npsn" value="{{ $field($pendaftaran->pendidikan, 'npsn') }}" class="{{ $inputClass }}" required>
                                {!! $fieldError('npsn') !!}
                            </div>
                        </div>
                    </fieldset>
                    @unless($isLocked)
                        <div class="flex flex-col sm:flex-row sm:justify-end gap-3 border-t pt-6">
                            {!! $nextButton($nextTab) !!}
                            <button class="px-6 py-3 rounded-lg bg-emerald-600 text-white font-semibold hover:bg-emerald-700">Simpan Pendidikan</button>
                        </div>
                    @endunless
                </form>
            @endif

            @if($activeTab === 'prestasi')
                <form action="{{ route('biodata.tab.update', 'prestasi') }}" method="POST" class="space-y-6">
                    @csrf
                    <fieldset @if($isLocked) disabled @endif>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            @foreach(['kategori_prestasi' => 'Kategori Prestasi', 'jumlah_juz' => 'Jumlah Juz Hafalan', 'tingkat_prestasi' => 'Tingkat Prestasi', 'jenis_prestasi' => 'Jenis Prestasi', 'nama_lomba' => 'Nama Lomba'] as $name => $label)
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">{{ $label }}</label>
                                    <input @if($name === 'jumlah_juz') type="number" @endif name="{{ $name }}" value="{{ $field($pendaftaran->penunjangPrestasi, $name) }}" class="{{ $inputClass }}">
                                    {!! $fieldError($name) !!}
                                </div>
                            @endforeach
                        </div>
                        <p class="text-sm text-gray-500 mt-4">File sertifikat prestasi diunggah pada tab Berkas.</p>
                    </fieldset>
                    @unless($isLocked)
                        <div class="flex flex-col sm:flex-row sm:justify-end gap-3 border-t pt-6">
                            {!! $nextButton($nextTab) !!}
                            <button class="px-6 py-3 rounded-lg bg-emerald-600 text-white font-semibold hover:bg-emerald-700">Simpan Prestasi</button>
                        </div>
                    @endunless
                </form>
            @endif

            @foreach(['ayah' => $pendaftaran->dataAyah, 'ibu' => $pendaftaran->dataIbu, 'wali' => $pendaftaran->dataWali] as $parentKey => $parentModel)
                @if($activeTab === $parentKey)
                    @php
                        $isWali = $parentKey === 'wali';
                        $suffix = $parentKey;
                        $title = ['ayah' => 'Ayah', 'ibu' => 'Ibu', 'wali' => 'Wali'][$parentKey];
                    @endphp
                    <form action="{{ route('biodata.tab.update', $parentKey) }}" method="POST" class="space-y-6">
                        @csrf
                        <fieldset @if($isLocked) disabled @endif>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                @foreach([
                                    "nama_$suffix" => "Nama $title",
                                    "nik_$suffix" => "NIK $title",
                                    "tempat_lahir_$suffix" => "Tempat Lahir $title",
                                    "tanggal_lahir_$suffix" => "Tanggal Lahir $title",
                                    "pendidikan_terakhir_$suffix" => "Pendidikan Terakhir $title",
                                    "pekerjaan_$suffix" => "Pekerjaan $title",
                                    "penghasilan_$suffix" => "Penghasilan $title",
                                    "no_hp_$suffix" => "No HP $title",
                                ] as $name => $label)
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">
                                            {{ $label }}
                                            @if(!$isWali && in_array($name, ["nama_$suffix", "pendidikan_terakhir_$suffix", "pekerjaan_$suffix", "penghasilan_$suffix", "no_hp_$suffix"], true))
                                                <span class="text-red-500">*</span>
                                            @endif
                                        </label>
                                        <input @if(str_starts_with($name, 'tanggal_lahir')) type="date" @endif
                                            name="{{ $name }}"
                                            value="{{ $field($parentModel, $name) }}"
                                            class="{{ $inputClass }}"
                                            @if(!$isWali && in_array($name, ["nama_$suffix", "pendidikan_terakhir_$suffix", "pekerjaan_$suffix", "penghasilan_$suffix", "no_hp_$suffix"], true)) required @endif>
                                        {!! $fieldError($name) !!}
                                    </div>
                                @endforeach
                            </div>
                        </fieldset>
                        @unless($isLocked)
                            <div class="flex flex-col sm:flex-row sm:justify-end gap-3 border-t pt-6">
                                {!! $nextButton($nextTab) !!}
                                <button class="px-6 py-3 rounded-lg bg-emerald-600 text-white font-semibold hover:bg-emerald-700">Simpan Data {{ $title }}</button>
                            </div>
                        @endunless
                    </form>
                @endif
            @endforeach

            @if($activeTab === 'berkas')
                @php
                    $berkas = $pendaftaran->berkas;
                    $hasBiodata = $pendaftaran->isBiodataLengkap();
                    $berkasRejected = optional($berkas)->status_berkas === 'tolak';
                    $berkasAccepted = optional($berkas)->status_berkas === 'terima';
                    $berkasWaiting = $pendaftaran->status_pendaftaran === 'verifikasi' && !$berkasRejected;
                    $berkasLocked = $berkasAccepted || in_array($pendaftaran->status_pendaftaran, ['tes', 'lulus', 'tidak_lulus'], true) || $berkasWaiting;
                    $berkasFields = [
                        'file_raport' => 'Scan Raport Terakhir',
                        'file_nisn' => 'Scan NISN',
                        'file_foto' => 'Pas Foto',
                        'file_surat_keterangan_aktif' => 'Surat Keterangan Aktif / SKL',
                        'file_kk' => 'Scan Kartu Keluarga (KK)',
                        'file_slip_gaji' => 'Slip Gaji Orang Tua',
                    ];

                    if(optional($pendaftaran->jalur)->nama_jalur === 'Prestasi') {
                        $berkasFields['file_sertifikat'] = 'Piagam/Sertifikat Kejuaraan';
                    }

                    if(optional($pendaftaran->jalur)->nama_jalur === 'Afirmasi') {
                        $berkasFields['file_sktm'] = 'Surat Keterangan Tidak Mampu (SKTM)';
                        $berkasFields['file_kip'] = 'Kartu KIP (Opsional)';
                    }
                @endphp

                @if(!$hasBiodata)
                    <div class="bg-yellow-50 border border-yellow-200 text-yellow-800 px-4 py-3 rounded-lg">
                        Lengkapi seluruh tab biodata wajib terlebih dahulu sebelum mengunggah berkas.
                    </div>
                @else
                    <form action="{{ $berkas ? route('berkas.update', $berkas->id) : route('berkas.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                        @csrf
                        <input type="hidden" name="from_biodata_tab" value="1">
                        @if($berkas)
                            @method('PUT')
                        @endif

                        @if($berkasRejected)
                            <div class="bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg">
                                <strong>Berkas ditolak.</strong>
                                <span class="block">Perbaiki dokumen sesuai catatan, lalu ajukan ulang dari dashboard.</span>
                                @if($berkas->pesan)
                                    <p class="mt-2 text-sm">{{ $berkas->pesan }}</p>
                                @endif
                            </div>
                        @elseif($berkasLocked)
                            <div class="bg-green-100 border border-green-300 text-green-800 px-4 py-3 rounded-lg">
                                <strong>{{ $berkasAccepted ? 'Berkas sudah diterima.' : 'Berkas sedang diverifikasi.' }}</strong>
                                <span class="block">Berkas tidak dapat diubah saat ini.</span>
                            </div>
                        @endif

                        <fieldset @if($berkasLocked) disabled @endif>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                @foreach($berkasFields as $name => $label)
                                    @php $path = optional($berkas)->{$name}; @endphp
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">
                                            {{ $label }}
                                            @if($name !== 'file_kip')
                                                <span class="text-red-500">*</span>
                                            @endif
                                        </label>
                                        @if($path)
                                            <span class="text-xs text-green-600 block mt-1"><i class="fi fi-rs-check-circle"></i> File sudah diunggah.</span>
                                            <a href="{{ Storage::url($path) }}" target="_blank"
                                                class="inline-flex items-center mt-2 px-3 py-1.5 rounded-md bg-gray-100 text-gray-700 text-xs font-semibold hover:bg-gray-200">
                                                <i class="fi fi-rs-eye mr-1.5"></i> View Berkas
                                            </a>
                                        @endif
                                        <input type="file" name="{{ $name }}" class="{{ $fileClass }}" accept=".pdf,image/*" @if(!$berkas && $name !== 'file_kip') required @endif>
                                        @error($name)
                                            <p class="mt-1 text-xs text-red-600 font-medium">{{ $message }}</p>
                                        @enderror
                                    </div>
                                @endforeach
                            </div>
                        </fieldset>

                        @unless($berkasLocked)
                            <div class="flex justify-end border-t pt-6">
                                <button class="px-6 py-3 rounded-lg bg-emerald-600 text-white font-semibold hover:bg-emerald-700">
                                    {{ $berkas ? 'Perbarui Berkas' : 'Unggah Berkas' }}
                                </button>
                            </div>
                        @endunless
                    </form>
                @endif
            @endif
        </div>
    </div>
</x-app-layout>
