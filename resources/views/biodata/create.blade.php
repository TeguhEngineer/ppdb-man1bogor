<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-gray-800 leading-tight">
            {{ __('Isi Formulir Biodata') }}
        </h2>
    </x-slot>

    <!-- Info Card -->
    <div class="bg-white overflow-hidden shadow-sm rounded-xl border border-blue-100 mb-6">
        <div
            class="p-6 md:p-8 text-gray-900 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div>
                <h3 class="text-lg font-bold text-blue-800 mb-2 flex items-center">
                    <i class="fi fi-rs-info text-blue-600 mr-2"></i> Petunjuk Pengisian
                </h3>
                <ul class="list-disc list-inside text-sm text-gray-600 space-y-1">
                    <li>Isi data diri Anda dengan benar dan sesuai dokumen resmi.</li>
                    <li>Kolom bertanda bintang merah (<span class="text-red-500">*</span>) wajib diisi.</li>
                    <li>Kosongkan bagian yang berlabel (Opsional) jika tidak ada data terkait.</li>
                    <li>Berkas dokumen (KK, Slip Gaji, dll) akan diunggah pada halaman khusus berkas setelah biodata disimpan.</li>
                </ul>
            </div>
            <div class="shrink-0 bg-gray-50 px-6 py-4 rounded-lg border border-gray-100 text-center w-full md:w-auto">
                <p class="text-xs text-gray-500 uppercase tracking-wider font-semibold mb-1">Status Pengisian</p>
                <span
                    class="inline-flex items-center px-4 py-2 rounded-full text-sm font-bold bg-yellow-100 text-yellow-800">
                    <i class="fi fi-rs-time-fast mr-2"></i> Belum Diisi
                </span>
            </div>
        </div>
    </div>

    <!-- Form Card -->
    <div class="bg-white overflow-hidden shadow-sm rounded-xl border border-gray-100">
        <div class="p-6 md:p-8 text-gray-900">

            @if ($errors->any())
                <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                    <strong class="font-bold">Ada kesalahan!</strong>
                    <ul class="mt-2 list-disc list-inside text-sm">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('biodata.store') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
                @csrf

                <!-- Section 0: Data Pendaftaran -->
                <div class="bg-blue-50 p-6 rounded-xl border border-blue-100">
                    <h3 class="text-lg leading-6 font-bold text-blue-900 border-b border-blue-200 pb-2 mb-4">Data
                        Pendaftaran</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Jalur Pendaftaran <span
                                    class="text-red-500">*</span></label>
                            <select name="jalur_id"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500"
                                required>
                                @foreach($jalurs as $jalur)
                                    <option value="{{ $jalur->id }}" {{ old('jalur_id', $pendaftaran->jalur_id) == $jalur->id ? 'selected' : '' }}>{{ $jalur->nama_jalur }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">NISN <span
                                    class="text-red-500">*</span></label>
                            <input type="text" name="nisn" value="{{ old('nisn', $pendaftaran->nisn) }}"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500"
                                required>
                            @error('nisn')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Kampus Tujuan <span
                                    class="text-red-500">*</span></label>
                            <input type="text" name="kampus" value="{{ old('kampus', $pendaftaran->kampus) }}"
                                class="mt-1 block w-full rounded-md border-gray-300 bg-gray-100 text-gray-600 shadow-sm cursor-not-allowed"
                                readonly required>
                        </div>
                    </div>
                </div>

                <!-- Section 1: Data Pribadi -->
                <div>
                    <h3 class="text-lg leading-6 font-medium text-gray-900 border-b pb-2 mb-4">1. Data Pribadi</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Nama Lengkap <span
                                    class="text-red-500">*</span></label>
                            <input type="text" name="nama_lengkap" value="{{ Auth::user()->name }}"
                                class="mt-1 block w-full rounded-md border-gray-300 bg-gray-100 text-gray-600 shadow-sm cursor-not-allowed"
                                readonly>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">NIK <span
                                    class="text-red-500">*</span></label>
                            <input type="text" name="nik" value="{{ old('nik') }}"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500"
                                required>
                            @error('nik')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">No. Kartu Keluarga <span
                                    class="text-red-500">*</span></label>
                            <input type="text" name="no_kk" value="{{ old('no_kk') }}"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500"
                                required>
                            @error('no_kk')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Tempat Lahir <span
                                    class="text-red-500">*</span></label>
                            <input type="text" name="tempat_lahir" value="{{ old('tempat_lahir') }}"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500"
                                required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Tanggal Lahir <span
                                    class="text-red-500">*</span></label>
                            <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500"
                                required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Jenis Kelamin <span
                                    class="text-red-500">*</span></label>
                            <select name="jenis_kelamin"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500"
                                required>
                                <option value="">Pilih</option>
                                <option value="laki-laki" {{ old('jenis_kelamin') == 'laki-laki' ? 'selected' : '' }}>
                                    Laki-Laki</option>
                                <option value="perempuan" {{ old('jenis_kelamin') == 'perempuan' ? 'selected' : '' }}>
                                    Perempuan</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Agama <span
                                    class="text-red-500">*</span></label>
                            <select name="agama"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500"
                                required>
                                <option value="">Pilih</option>
                                <option value="Islam" {{ old('agama') == 'Islam' ? 'selected' : '' }}>Islam</option>
                                <option value="Kristen" {{ old('agama') == 'Kristen' ? 'selected' : '' }}>Kristen</option>
                                <option value="Katolik" {{ old('agama') == 'Katolik' ? 'selected' : '' }}>Katolik</option>
                                <option value="Hindu" {{ old('agama') == 'Hindu' ? 'selected' : '' }}>Hindu</option>
                                <option value="Buddha" {{ old('agama') == 'Buddha' ? 'selected' : '' }}>Buddha</option>
                                <option value="Konghucu" {{ old('agama') == 'Konghucu' ? 'selected' : '' }}>Konghucu
                                </option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">No. WhatsApp <span
                                    class="text-red-500">*</span></label>
                            <input type="text" name="no_whatsapp" value="{{ old('no_whatsapp') }}"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500"
                                required>
                            @error('no_whatsapp')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Tinggi Badan (cm) <span class="text-red-500">*</span></label>
                            <input type="number" name="tinggi_badan" value="{{ old('tinggi_badan') }}"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Berat Badan (kg) <span class="text-red-500">*</span></label>
                            <input type="number" name="berat_badan" value="{{ old('berat_badan') }}"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Anak Ke <span class="text-red-500">*</span></label>
                            <input type="number" name="anak_ke" value="{{ old('anak_ke') }}"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Jumlah Saudara <span class="text-red-500">*</span></label>
                            <input type="number" name="jumlah_saudara" value="{{ old('jumlah_saudara') }}"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Status Dalam Keluarga <span class="text-red-500">*</span></label>
                            <input type="text" name="status_dalam_keluarga" placeholder="Anak Kandung / Anak Tiri / dll"
                                value="{{ old('status_dalam_keluarga') }}"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Tinggal Bersama <span class="text-red-500">*</span></label>
                            <input type="text" name="tinggal_bersama" placeholder="Orang Tua / Wali / Asrama"
                                value="{{ old('tinggal_bersama') }}"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500" required>
                        </div>
                    </div>
                </div>

                <!-- Section 2: Data Alamat -->
                <div>
                    <h3 class="text-lg leading-6 font-medium text-gray-900 border-b pb-2 mb-4">2. Data Alamat Tempat
                        Tinggal</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700">Alamat Lengkap <span
                                    class="text-red-500">*</span></label>
                            <textarea name="alamat" rows="3"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500"
                                required>{{ old('alamat') }}</textarea>
                            @error('alamat')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Desa/Kelurahan <span
                                    class="text-red-500">*</span></label>
                            <input type="text" name="desa" value="{{ old('desa') }}"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500"
                                required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Kecamatan <span
                                    class="text-red-500">*</span></label>
                            <input type="text" name="kecamatan" value="{{ old('kecamatan') }}"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500"
                                required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Kabupaten/Kota <span
                                    class="text-red-500">*</span></label>
                            <input type="text" name="kabupaten" value="{{ old('kabupaten') }}"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500"
                                required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Provinsi <span
                                    class="text-red-500">*</span></label>
                            <input type="text" name="provinsi" value="{{ old('provinsi') }}"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500"
                                required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Kode Pos <span
                                    class="text-red-500">*</span></label>
                            <input type="text" name="kode_pos" value="{{ old('kode_pos') }}"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500"
                                required>
                            @error('kode_pos')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Jarak ke Sekolah (km) <span class="text-red-500">*</span></label>
                            <input type="text" name="jarak_ke_sekolah" value="{{ old('jarak_ke_sekolah') }}"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Waktu Tempuh (menit) <span class="text-red-500">*</span></label>
                            <input type="text" name="waktu_tempuh_ke_sekolah"
                                value="{{ old('waktu_tempuh_ke_sekolah') }}"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500" required>
                        </div>
                    </div>
                </div>

                <!-- Section 3: Data Pendidikan -->
                <div>
                    <h3 class="text-lg leading-6 font-medium text-gray-900 border-b pb-2 mb-4">3. Data Pendidikan</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Asal Satuan Pendidikan <span
                                    class="text-red-500">*</span></label>
                            <select name="asal_satuan_pendidikan"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500"
                                required>
                                <option value="">Pilih</option>
                                <option value="SMP" {{ old('asal_satuan_pendidikan') == 'SMP' ? 'selected' : '' }}>SMP
                                </option>
                                <option value="MTS" {{ old('asal_satuan_pendidikan') == 'MTS' ? 'selected' : '' }}>MTs
                                </option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Nama Asal Sekolah <span
                                    class="text-red-500">*</span></label>
                            <input type="text" name="nama_asal_sekolah" value="{{ old('nama_asal_sekolah') }}"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500"
                                required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">NPSN <span class="text-red-500">*</span></label>
                            <input type="text" name="npsn" value="{{ old('npsn') }}"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500" required>
                        </div>
                    </div>
                </div>

                <!-- Section 4: Data Orang Tua -->
                <div>
                    <h3 class="text-lg leading-6 font-medium text-gray-900 border-b pb-2 mb-4">4. Data Orang Tua (Ayah &
                        Ibu)</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Ayah -->
                        <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                            <h4 class="font-semibold text-gray-700 mb-3 border-b border-gray-200 pb-2">Data Ayah</h4>
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-xs font-medium text-gray-700">Nama Ayah <span class="text-red-500">*</span></label>
                                    <input type="text" name="nama_ayah" value="{{ old('nama_ayah') }}"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500" required>
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-gray-700">NIK Ayah</label>
                                    <input type="text" name="nik_ayah" value="{{ old('nik_ayah') }}"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500">
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-gray-700">Tempat Lahir Ayah</label>
                                    <input type="text" name="tempat_lahir_ayah" value="{{ old('tempat_lahir_ayah') }}"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500">
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-gray-700">Tanggal Lahir Ayah</label>
                                    <input type="date" name="tanggal_lahir_ayah" value="{{ old('tanggal_lahir_ayah') }}"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500">
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-gray-700">Pendidikan Terakhir
                                        Ayah <span class="text-red-500">*</span></label>
                                    <input type="text" name="pendidikan_terakhir_ayah"
                                        value="{{ old('pendidikan_terakhir_ayah') }}"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500" required>
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-gray-700">Pekerjaan Ayah <span class="text-red-500">*</span></label>
                                    <input type="text" name="pekerjaan_ayah" value="{{ old('pekerjaan_ayah') }}"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500" required>
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-gray-700">Penghasilan Ayah
                                        /Bulan <span class="text-red-500">*</span></label>
                                    <input type="text" name="penghasilan_ayah" value="{{ old('penghasilan_ayah') }}"
                                        placeholder="Contoh: 3.000.000"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500" required>
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-gray-700">No HP Ayah <span class="text-red-500">*</span></label>
                                    <input type="text" name="no_hp_ayah" value="{{ old('no_hp_ayah') }}"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500" required>
                                </div>
                            </div>
                        </div>
                        <!-- Ibu -->
                        <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                            <h4 class="font-semibold text-gray-700 mb-3 border-b border-gray-200 pb-2">Data Ibu</h4>
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-xs font-medium text-gray-700">Nama Ibu <span class="text-red-500">*</span></label>
                                    <input type="text" name="nama_ibu" value="{{ old('nama_ibu') }}"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500" required>
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-gray-700">NIK Ibu</label>
                                    <input type="text" name="nik_ibu" value="{{ old('nik_ibu') }}"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500">
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-gray-700">Tempat Lahir Ibu</label>
                                    <input type="text" name="tempat_lahir_ibu" value="{{ old('tempat_lahir_ibu') }}"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500">
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-gray-700">Tanggal Lahir Ibu</label>
                                    <input type="date" name="tanggal_lahir_ibu" value="{{ old('tanggal_lahir_ibu') }}"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500">
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-gray-700">Pendidikan Terakhir
                                        Ibu <span class="text-red-500">*</span></label>
                                    <input type="text" name="pendidikan_terakhir_ibu"
                                        value="{{ old('pendidikan_terakhir_ibu') }}"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500" required>
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-gray-700">Pekerjaan Ibu <span class="text-red-500">*</span></label>
                                    <input type="text" name="pekerjaan_ibu" value="{{ old('pekerjaan_ibu') }}"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500" required>
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-gray-700">Penghasilan Ibu
                                        /Bulan <span class="text-red-500">*</span></label>
                                    <input type="text" name="penghasilan_ibu" value="{{ old('penghasilan_ibu') }}"
                                        placeholder="Contoh: 3.000.000"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500" required>
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-gray-700">No HP Ibu <span class="text-red-500">*</span></label>
                                    <input type="text" name="no_hp_ibu" value="{{ old('no_hp_ibu') }}"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500" required>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Section 5: Data Wali (Opsional) -->
                <div>
                    <h3 class="text-lg leading-6 font-medium text-gray-900 border-b pb-2 mb-4">5. Data Wali (Opsional)</h3>
                    <div class="grid grid-cols-1 md:grid-cols-1 gap-6">
                        <!-- Wali -->
                        <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                            <h4 class="font-semibold text-gray-700 mb-3 border-b border-gray-200 pb-2">Data Wali
                                (Kosongkan jika tinggal dengan orang tua)</h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-xs font-medium text-gray-700">Nama Wali</label>
                                    <input type="text" name="nama_wali" value="{{ old('nama_wali') }}"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500">
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-gray-700">NIK Wali</label>
                                    <input type="text" name="nik_wali" value="{{ old('nik_wali') }}"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500">
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-gray-700">Tempat Lahir Wali</label>
                                    <input type="text" name="tempat_lahir_wali" value="{{ old('tempat_lahir_wali') }}"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500">
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-gray-700">Tanggal Lahir Wali</label>
                                    <input type="date" name="tanggal_lahir_wali" value="{{ old('tanggal_lahir_wali') }}"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500">
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-gray-700">Pendidikan Terakhir
                                        Wali</label>
                                    <input type="text" name="pendidikan_terakhir_wali"
                                        value="{{ old('pendidikan_terakhir_wali') }}"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500">
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-gray-700">Pekerjaan Wali</label>
                                    <input type="text" name="pekerjaan_wali" value="{{ old('pekerjaan_wali') }}"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500">
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-gray-700">Penghasilan Wali
                                        /Bulan</label>
                                    <input type="text" name="penghasilan_wali" value="{{ old('penghasilan_wali') }}"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500">
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-gray-700">No HP Wali</label>
                                    <input type="text" name="no_hp_wali" value="{{ old('no_hp_wali') }}"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Section 6: Data Prestasi (Opsional) -->
                <div>
                    <h3 class="text-lg leading-6 font-medium text-gray-900 border-b pb-2 mb-4">6. Data Prestasi Hafalan Al-Qur'an (Opsional)</h3>
                    <div class="grid grid-cols-1 md:grid-cols-1 gap-6">
                        <!-- Prestasi -->
                        <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                            <h4 class="font-semibold text-gray-700 mb-3 border-b border-gray-200 pb-2">Informasi Prestasi / Tahfidz</h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-xs font-medium text-gray-700">Kategori Prestasi</label>
                                    <input type="text" name="kategori_prestasi" value="{{ old('kategori_prestasi') }}"
                                        placeholder="Akademik / Non Akademik / Tahfidz"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500">
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-gray-700">Jumlah Juz (Khusus
                                        Tahfidz)</label>
                                    <input type="number" name="jumlah_juz" value="{{ old('jumlah_juz') }}"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500">
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-gray-700">Jenis Prestasi</label>
                                    <input type="text" name="jenis_prestasi" value="{{ old('jenis_prestasi') }}"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500">
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-gray-700">Tingkat Prestasi</label>
                                    <input type="text" name="tingkat_prestasi" value="{{ old('tingkat_prestasi') }}"
                                        placeholder="Kabupaten / Provinsi / Nasional"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500">
                                </div>
                                <div class="md:col-span-2">
                                    <label class="block text-xs font-medium text-gray-700">Nama Lomba / Prestasi</label>
                                    <input type="text" name="nama_lomba" value="{{ old('nama_lomba') }}"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>



                <div class="flex items-center justify-end pt-6 border-t mt-8">
                    <button type="submit"
                        class="bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-3 px-8 rounded-lg shadow-md transition-colors w-full md:w-auto text-lg flex items-center justify-center">
                        <i class="fi fi-rs-disk mr-2"></i> Simpan Biodata
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>