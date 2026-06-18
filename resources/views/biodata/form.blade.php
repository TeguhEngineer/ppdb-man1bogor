<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-gray-800 leading-tight">
            {{ __('Isi Biodata') }}
        </h2>
    </x-slot>

    @php
        $tabs = [
            'pribadi' => 'Data Pribadi',
            'orangtua' => 'Data Orangtua',
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
        $tabUrl = fn ($key) => route('biodata.edit', ['tab' => $key]);
        $dataPribadi = $pendaftaran->dataPribadi;
        $dataOrangtua = $pendaftaran->dataOrangtua;
    @endphp

    <div class="bg-white overflow-hidden shadow-sm rounded-xl border border-blue-100 mb-6">
        <div class="p-6 md:p-8 flex flex-col md:flex-row justify-between gap-4">
            <div>
                <h3 class="text-lg font-bold text-blue-800 mb-2 flex items-center">
                    <i class="fi fi-rs-info text-blue-600 mr-2"></i> Pengisian Biodata
                </h3>
                <ul class="list-disc list-inside text-sm text-gray-600 space-y-1">
                    <li>Data Pribadi berisi registrasi, identitas, alamat, dan pendidikan.</li>
                    <li>Data Orangtua berisi data ayah, ibu, dan wali dalam satu tabel.</li>
                    <li>Tab Berkas memakai tabel berkas yang sudah ada.</li>
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

    @foreach (['success' => 'green', 'error' => 'red'] as $sessionKey => $color)
        @if (session($sessionKey))
            <div class="mb-4 bg-{{ $color }}-100 border border-{{ $color }}-400 text-{{ $color }}-700 px-4 py-3 rounded-xl" role="alert">
                <strong class="font-bold">{{ $sessionKey === 'success' ? 'Berhasil!' : 'Gagal!' }}</strong>
                <span>{{ session($sessionKey) }}</span>
            </div>
        @endif
    @endforeach

    <div class="bg-white shadow-sm rounded-xl border border-gray-100 mb-10 overflow-hidden">
        <div class="border-b border-gray-100 bg-gray-50">
            <nav class="grid grid-cols-1 sm:grid-cols-3 gap-2 p-3 md:p-4">
                @foreach($tabs as $key => $label)
                    <a href="{{ $tabUrl($key) }}"
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
                    <span class="block">Biodata tidak dapat diubah saat ini.</span>
                </div>
            @endif

            @if($activeTab === 'pribadi')
                <form action="{{ route('biodata.tab.update', 'pribadi') }}" method="POST" class="space-y-8">
                    @csrf
                    <fieldset @if($isLocked) disabled @endif>
                        <section>
                            <h3 class="text-base font-bold text-gray-800 mb-4">Registrasi</h3>
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
                                        <option value="MAN 1 BOGOR" @selected(old('kampus', $pendaftaran->kampus) === 'MAN 1 BOGOR')>MAN 1 BOGOR</option>
                                    </select>
                                    {!! $fieldError('kampus') !!}
                                </div>
                            </div>
                        </section>

                        <section class="border-t pt-6 mt-6">
                            <h3 class="text-base font-bold text-gray-800 mb-4">Identitas Peserta</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                @foreach([
                                    'nama_lengkap' => ['Nama Lengkap', 'text'],
                                    'nik' => ['NIK', 'text'],
                                    'tempat_lahir' => ['Tempat Lahir', 'text'],
                                    'tanggal_lahir' => ['Tanggal Lahir', 'date'],
                                    'no_kk' => ['Nomor KK', 'text'],
                                    'tinggi_badan' => ['Tinggi Badan', 'number'],
                                    'berat_badan' => ['Berat Badan', 'number'],
                                    'status_dalam_keluarga' => ['Status Dalam Keluarga', 'text'],
                                    'tinggal_bersama' => ['Tinggal Bersama', 'text'],
                                    'anak_ke' => ['Anak Ke', 'number'],
                                    'jumlah_saudara' => ['Jumlah Saudara', 'number'],
                                    'agama' => ['Agama', 'text'],
                                    'no_whatsapp' => ['No WhatsApp', 'text'],
                                ] as $name => [$label, $type])
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">{{ $label }} <span class="text-red-500">*</span></label>
                                        <input type="{{ $type }}" name="{{ $name }}" value="{{ $field($dataPribadi, $name) }}" class="{{ $inputClass }}" @if($name === 'no_whatsapp') maxlength="20" @endif required>
                                        {!! $fieldError($name) !!}
                                    </div>
                                @endforeach
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Jenis Kelamin <span class="text-red-500">*</span></label>
                                    <select name="jenis_kelamin" class="{{ $inputClass }}" required>
                                        <option value="">Pilih</option>
                                        <option value="laki-laki" @selected($field($dataPribadi, 'jenis_kelamin') === 'laki-laki')>Laki-laki</option>
                                        <option value="perempuan" @selected($field($dataPribadi, 'jenis_kelamin') === 'perempuan')>Perempuan</option>
                                    </select>
                                    {!! $fieldError('jenis_kelamin') !!}
                                </div>
                            </div>
                        </section>

                        <section class="border-t pt-6 mt-6">
                            <h3 class="text-base font-bold text-gray-800 mb-4">Alamat</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="md:col-span-2">
                                    <label class="block text-sm font-medium text-gray-700">Alamat Lengkap <span class="text-red-500">*</span></label>
                                    <textarea name="alamat" class="{{ $inputClass }}" rows="3" required>{{ $field($dataPribadi, 'alamat') }}</textarea>
                                    {!! $fieldError('alamat') !!}
                                </div>
                                @foreach([
                                    'desa' => 'Desa/Kelurahan',
                                    'kecamatan' => 'Kecamatan',
                                    'kabupaten' => 'Kabupaten/Kota',
                                    'provinsi' => 'Provinsi',
                                    'kode_pos' => 'Kode Pos',
                                    'jarak_ke_sekolah' => 'Jarak ke Sekolah',
                                    'waktu_tempuh_ke_sekolah' => 'Waktu Tempuh ke Sekolah',
                                ] as $name => $label)
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">{{ $label }} <span class="text-red-500">*</span></label>
                                        <input name="{{ $name }}" value="{{ $field($dataPribadi, $name) }}" class="{{ $inputClass }}" required>
                                        {!! $fieldError($name) !!}
                                    </div>
                                @endforeach
                            </div>
                        </section>

                        <section class="border-t pt-6 mt-6">
                            <h3 class="text-base font-bold text-gray-800 mb-4">Pendidikan</h3>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Asal Satuan Pendidikan <span class="text-red-500">*</span></label>
                                    <select name="asal_satuan_pendidikan" class="{{ $inputClass }}" required>
                                        <option value="">Pilih</option>
                                        <option value="SMP" @selected($field($dataPribadi, 'asal_satuan_pendidikan') === 'SMP')>SMP</option>
                                        <option value="MTS" @selected($field($dataPribadi, 'asal_satuan_pendidikan') === 'MTS')>MTS</option>
                                    </select>
                                    {!! $fieldError('asal_satuan_pendidikan') !!}
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Nama Asal Sekolah <span class="text-red-500">*</span></label>
                                    <input name="nama_asal_sekolah" value="{{ $field($dataPribadi, 'nama_asal_sekolah') }}" class="{{ $inputClass }}" required>
                                    {!! $fieldError('nama_asal_sekolah') !!}
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">NPSN <span class="text-red-500">*</span></label>
                                    <input name="npsn" value="{{ $field($dataPribadi, 'npsn') }}" class="{{ $inputClass }}" required>
                                    {!! $fieldError('npsn') !!}
                                </div>
                            </div>
                        </section>
                    </fieldset>

                    @unless($isLocked)
                        <div class="flex flex-col sm:flex-row sm:justify-end gap-3 border-t pt-6">
                            <button type="submit" name="next_tab" value="orangtua" class="w-full sm:w-auto px-6 py-3 rounded-lg bg-gray-100 text-gray-800 font-semibold hover:bg-gray-200">Simpan & Lanjut</button>
                            <button class="w-full sm:w-auto px-6 py-3 rounded-lg bg-emerald-600 text-white font-semibold hover:bg-emerald-700">Simpan Data Pribadi</button>
                        </div>
                    @endunless
                </form>
            @endif

            @if($activeTab === 'orangtua')
                <form action="{{ route('biodata.tab.update', 'orangtua') }}" method="POST" class="space-y-8">
                    @csrf
                    <fieldset @if($isLocked) disabled @endif>
                        @foreach(['ayah' => 'Ayah', 'ibu' => 'Ibu', 'wali' => 'Wali'] as $suffix => $title)
                            @php $isWali = $suffix === 'wali'; @endphp
                            <section class="{{ !$loop->first ? 'border-t pt-6 mt-6' : '' }}">
                                <h3 class="text-base font-bold text-gray-800 mb-4">Data {{ $title }}</h3>
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
                                        @php
                                            $requiredParentField = !$isWali && in_array($name, ["nama_$suffix", "pendidikan_terakhir_$suffix", "pekerjaan_$suffix", "penghasilan_$suffix", "no_hp_$suffix"], true);
                                        @endphp
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700">
                                                {{ $label }}
                                                @if($requiredParentField)
                                                    <span class="text-red-500">*</span>
                                                @endif
                                            </label>
                                            <input @if(str_starts_with($name, 'tanggal_lahir')) type="date" @endif
                                                name="{{ $name }}"
                                                value="{{ $field($dataOrangtua, $name) }}"
                                                class="{{ $inputClass }}"
                                                @if($requiredParentField) required @endif>
                                            {!! $fieldError($name) !!}
                                        </div>
                                    @endforeach
                                </div>
                            </section>
                        @endforeach
                    </fieldset>

                    @unless($isLocked)
                        <div class="flex flex-col sm:flex-row sm:justify-end gap-3 border-t pt-6">
                            <button type="submit" name="next_tab" value="berkas" class="w-full sm:w-auto px-6 py-3 rounded-lg bg-gray-100 text-gray-800 font-semibold hover:bg-gray-200">Simpan & Lanjut</button>
                            <button class="w-full sm:w-auto px-6 py-3 rounded-lg bg-emerald-600 text-white font-semibold hover:bg-emerald-700">Simpan Data Orangtua</button>
                        </div>
                    @endunless
                </form>
            @endif

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
                        Lengkapi tab Data Pribadi dan Data Orangtua terlebih dahulu sebelum mengunggah berkas.
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
                                <button class="w-full sm:w-auto px-6 py-3 rounded-lg bg-emerald-600 text-white font-semibold hover:bg-emerald-700">
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
