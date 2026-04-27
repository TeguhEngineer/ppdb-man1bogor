<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-gray-800 leading-tight">
            {{ __('Perbarui Berkas Persyaratan') }}
        </h2>
    </x-slot>

    <!-- Info Card -->
    <div class="bg-white overflow-hidden shadow-sm rounded-xl border border-blue-100 mb-6">
        <div class="p-6 md:p-8 text-gray-900 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div>
                <h3 class="text-lg font-bold text-blue-800 mb-2 flex items-center">
                    <i class="fi fi-rs-info text-blue-600 mr-2"></i> Petunjuk Pengunggahan
                </h3>
                <ul class="list-disc list-inside text-sm text-gray-600 space-y-1">
                    <li>Pilih file baru jika Anda ingin mengganti file yang sudah diunggah.</li>
                    <li>Kosongkan pilihan jika tidak ingin mengubah file saat ini.</li>
                    <li>Pastikan berkas khusus (seperti Sertifikat atau SKTM) sudah terunggah sesuai jalur pendaftaran Anda.</li>
                    <li>Status akan berubah menjadi <span class="text-green-600 font-bold">"Selesai"</span> jika semua berkas wajib sudah terpenuhi.</li>
                    <li>Ukuran maksimal untuk setiap file adalah 1MB (Sertifikat maks 2MB).</li>
                </ul>
            </div>
            <div class="shrink-0 bg-gray-50 px-6 py-4 rounded-lg border border-gray-100 text-center w-full md:w-auto">
                <p class="text-xs text-gray-500 uppercase tracking-wider font-semibold mb-1">Status Pengisian</p>
                @if($pendaftaran->isBerkasLengkap())
                    <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-bold bg-green-100 text-green-800">
                        <i class="fi fi-rs-check-circle mr-2"></i> Selesai Diupload
                    </span>
                @else
                    <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-bold bg-yellow-100 text-yellow-800">
                        <i class="fi fi-rs-exclamation mr-2"></i> Belum Lengkap
                    </span>
                @endif
            </div>
        </div>
    </div>

    <!-- Form Card -->
    <div class="bg-white overflow-hidden shadow-sm rounded-xl border border-gray-100 mb-10">
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

            @if (session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                    <strong class="font-bold">Berhasil!</strong>
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            <form action="{{ route('berkas.update', $berka->id) }}" method="POST" enctype="multipart/form-data" class="space-y-8">
                @csrf
                @method('PUT')
                
                <div>
                    <h3 class="text-lg leading-6 font-medium text-gray-900 border-b pb-2 mb-4">Dokumen Persyaratan</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Scan Raport Terakhir <span class="text-red-500">*</span></label>
                            @if($berka->file_raport)
                                <span class="text-xs text-green-600 block mt-1"><i class="fi fi-rs-check-circle"></i> File sudah diunggah. Pilih file baru untuk mengganti.</span>
                            @endif
                            <input type="file" name="file_raport" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100" accept=".pdf,image/*">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Scan NISN <span class="text-red-500">*</span></label>
                            @if($berka->file_nisn)
                                <span class="text-xs text-green-600 block mt-1"><i class="fi fi-rs-check-circle"></i> File sudah diunggah. Pilih file baru untuk mengganti.</span>
                            @endif
                            <input type="file" name="file_nisn" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100" accept=".pdf,image/*">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Pas Foto <span class="text-red-500">*</span></label>
                            @if($berka->file_foto)
                                <span class="text-xs text-green-600 block mt-1"><i class="fi fi-rs-check-circle"></i> File sudah diunggah. Pilih file baru untuk mengganti.</span>
                            @endif
                            <input type="file" name="file_foto" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100" accept=".pdf,image/*">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Surat Keterangan Aktif / SKL <span class="text-red-500">*</span></label>
                            @if($berka->file_surat_keterangan_aktif)
                                <span class="text-xs text-green-600 block mt-1"><i class="fi fi-rs-check-circle"></i> File sudah diunggah. Pilih file baru untuk mengganti.</span>
                            @endif
                            <input type="file" name="file_surat_keterangan_aktif" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100" accept=".pdf,image/*">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Scan Kartu Keluarga (KK) <span class="text-red-500">*</span></label>
                            @if($berka->file_kk)
                                <span class="text-xs text-green-600 block mt-1"><i class="fi fi-rs-check-circle"></i> File sudah diunggah. Pilih file baru untuk mengganti.</span>
                            @endif
                            <input type="file" name="file_kk" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100" accept=".pdf,image/*">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Slip Gaji Orang Tua <span class="text-red-500">*</span></label>
                            @if($berka->file_slip_gaji)
                                <span class="text-xs text-green-600 block mt-1"><i class="fi fi-rs-check-circle"></i> File sudah diunggah. Pilih file baru untuk mengganti.</span>
                            @endif
                            <input type="file" name="file_slip_gaji" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100" accept=".pdf,image/*">
                        </div>

                        {{-- Berkas Khusus Jalur Prestasi --}}
                        @if($pendaftaran->jalur->nama_jalur == 'Prestasi')
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Piagam/Sertifikat Kejuaraan <span class="text-red-500">*</span></label>
                            @if($berka->file_sertifikat)
                                <span class="text-xs text-green-600 block mt-1"><i class="fi fi-rs-check-circle"></i> File sudah diunggah. Pilih file baru untuk mengganti.</span>
                            @endif
                            <input type="file" name="file_sertifikat" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100" accept=".pdf,image/*">
                        </div>
                        @endif

                        {{-- Berkas Khusus Jalur Afirmasi --}}
                        @if($pendaftaran->jalur->nama_jalur == 'Afirmasi')
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Surat Keterangan Tidak Mampu (SKTM) <span class="text-red-500">*</span></label>
                            @if($berka->file_sktm)
                                <span class="text-xs text-green-600 block mt-1"><i class="fi fi-rs-check-circle"></i> File sudah diunggah. Pilih file baru untuk mengganti.</span>
                            @endif
                            <input type="file" name="file_sktm" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100" accept=".pdf,image/*">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Kartu KIP (Optional)</label>
                            @if($berka->file_kip)
                                <span class="text-xs text-green-600 block mt-1"><i class="fi fi-rs-check-circle"></i> File sudah diunggah. Pilih file baru untuk mengganti.</span>
                            @endif
                            <input type="file" name="file_kip" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100" accept=".pdf,image/*">
                        </div>
                        @endif
                    </div>
                </div>

                <div class="flex justify-end border-t pt-6 mt-8">
                    <button type="submit" class="inline-flex justify-center py-3 px-6 border border-transparent shadow-sm text-sm font-medium rounded-lg text-white bg-emerald-600 hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 transition-colors">
                        Perbarui Berkas
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
