<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-gray-800 leading-tight">
            {{ __('Seleksi Ujian') }}
        </h2>
    </x-slot>

    <div class="space-y-6 mb-10">
        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg text-sm" role="alert">
                <strong class="font-bold">Berhasil!</strong>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        @if (session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg text-sm" role="alert">
                <strong class="font-bold">Gagal!</strong>
                <span>{{ session('error') }}</span>
            </div>
        @endif

        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg text-sm" role="alert">
                <strong class="font-bold">Ada kesalahan!</strong>
                <ul class="mt-2 list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="grid grid-cols-1 xl:grid-cols-2 gap-6">
            <div class="bg-white overflow-hidden shadow-sm rounded-xl border border-gray-100">
                <div class="px-6 py-4 border-b border-gray-100 bg-gray-50">
                    <h3 class="font-bold text-lg text-gray-800">Master Ruangan</h3>
                </div>
                <div class="p-6">
                    <form action="{{ route('admin.seleksi-ujian.ruangan.store') }}" method="POST" class="grid grid-cols-1 md:grid-cols-4 gap-3 mb-6">
                        @csrf
                        <input type="text" name="nama_ruangan" placeholder="Nama ruangan"
                            class="rounded-lg border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 text-sm" required>
                        <input type="text" name="lokasi" placeholder="Lokasi"
                            class="rounded-lg border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 text-sm">
                        <input type="number" name="kapasitas" placeholder="Kapasitas" min="1"
                            class="rounded-lg border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 text-sm">
                        <button type="submit"
                            class="inline-flex justify-center items-center px-4 py-2 bg-emerald-100 text-emerald-700 font-bold rounded-lg border border-emerald-200 hover:bg-emerald-200 transition-colors text-sm">
                            <i class="fi fi-rs-plus mr-2"></i> Tambah
                        </button>
                    </form>

                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-gray-50 border-b border-gray-200 text-sm text-gray-600">
                                    <th class="p-3 font-semibold">Ruangan</th>
                                    <th class="p-3 font-semibold">Lokasi</th>
                                    <th class="p-3 font-semibold text-center">Kapasitas</th>
                                    <th class="p-3 font-semibold text-right">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="text-sm divide-y divide-gray-100">
                                @forelse($ruangans as $ruangan)
                                    <tr class="hover:bg-gray-50 transition-colors">
                                        <form action="{{ route('admin.seleksi-ujian.ruangan.update', $ruangan->id) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <td class="p-3">
                                                <input type="text" name="nama_ruangan" value="{{ $ruangan->nama_ruangan }}"
                                                    class="w-full rounded-md border-gray-300 text-sm">
                                            </td>
                                            <td class="p-3">
                                                <input type="text" name="lokasi" value="{{ $ruangan->lokasi }}"
                                                    class="w-full rounded-md border-gray-300 text-sm">
                                            </td>
                                            <td class="p-3">
                                                <input type="number" name="kapasitas" value="{{ $ruangan->kapasitas }}" min="1"
                                                    class="w-24 rounded-md border-gray-300 text-sm text-center">
                                            </td>
                                            <td class="p-3">
                                                <div class="flex justify-end gap-2">
                                                    <button type="submit"
                                                        class="inline-flex items-center px-3 py-1.5 rounded-md border border-gray-200 bg-white text-xs font-medium text-emerald-600 hover:bg-gray-50 shadow-sm">
                                                        Simpan
                                                    </button>
                                        </form>
                                                    <form action="{{ route('admin.seleksi-ujian.ruangan.destroy', $ruangan->id) }}" method="POST"
                                                        onsubmit="return confirm('Hapus ruangan ini?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"
                                                            class="inline-flex items-center px-3 py-1.5 rounded-md border border-gray-200 bg-white text-xs font-medium text-red-600 hover:bg-red-50 shadow-sm">
                                                            Hapus
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                    </tr>
                                @empty
                                    <tr class="bg-white text-gray-500">
                                        <td class="p-6 text-center font-medium" colspan="4">Belum ada ruangan ujian.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm rounded-xl border border-gray-100">
                <div class="px-6 py-4 border-b border-gray-100 bg-gray-50">
                    <h3 class="font-bold text-lg text-gray-800">Mapel Per Jalur</h3>
                </div>
                <div class="p-6">
                    <form action="{{ route('admin.seleksi-ujian.mapel.store') }}" method="POST" class="space-y-4 mb-6">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                            <input type="text" name="nama_mapel" placeholder="Nama mata pelajaran"
                                class="rounded-lg border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 text-sm" required>
                            <input type="text" name="deskripsi" placeholder="Deskripsi singkat"
                                class="rounded-lg border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 text-sm">
                        </div>
                        <div class="flex flex-wrap gap-3">
                            @foreach($jalurs as $jalur)
                                <label class="inline-flex items-center gap-2 text-sm text-gray-700">
                                    <input type="checkbox" name="jalur_ids[]" value="{{ $jalur->id }}"
                                        class="rounded border-gray-300 text-emerald-600 focus:ring-emerald-500">
                                    {{ $jalur->nama_jalur }}
                                </label>
                            @endforeach
                        </div>
                        <button type="submit"
                            class="inline-flex items-center px-4 py-2 bg-emerald-100 text-emerald-700 font-bold rounded-lg border border-emerald-200 hover:bg-emerald-200 transition-colors text-sm">
                            <i class="fi fi-rs-plus mr-2"></i> Tambah Mapel
                        </button>
                    </form>

                    <div class="space-y-3">
                        @forelse($mapels as $mapel)
                            <div class="border border-gray-100 rounded-lg p-4">
                                <form action="{{ route('admin.seleksi-ujian.mapel.update', $mapel->id) }}" method="POST" class="space-y-3">
                                    @csrf
                                    @method('PUT')
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                        <input type="text" name="nama_mapel" value="{{ $mapel->nama_mapel }}"
                                            class="rounded-md border-gray-300 text-sm font-semibold">
                                        <input type="text" name="deskripsi" value="{{ $mapel->deskripsi }}"
                                            class="rounded-md border-gray-300 text-sm">
                                    </div>
                                    <div class="flex flex-wrap gap-3">
                                        @foreach($jalurs as $jalur)
                                            <label class="inline-flex items-center gap-2 text-sm text-gray-700">
                                                <input type="checkbox" name="jalur_ids[]" value="{{ $jalur->id }}"
                                                    class="rounded border-gray-300 text-emerald-600 focus:ring-emerald-500"
                                                    {{ $mapel->jalurs->contains('id', $jalur->id) ? 'checked' : '' }}>
                                                {{ $jalur->nama_jalur }}
                                            </label>
                                        @endforeach
                                    </div>
                                    <div class="flex justify-end gap-2">
                                        <button type="submit"
                                            class="inline-flex items-center px-3 py-1.5 rounded-md border border-gray-200 bg-white text-xs font-medium text-emerald-600 hover:bg-gray-50 shadow-sm">
                                            Simpan
                                        </button>
                                </form>
                                        <form action="{{ route('admin.seleksi-ujian.mapel.destroy', $mapel->id) }}" method="POST"
                                            onsubmit="return confirm('Hapus mapel ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="inline-flex items-center px-3 py-1.5 rounded-md border border-gray-200 bg-white text-xs font-medium text-red-600 hover:bg-red-50 shadow-sm">
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                            </div>
                        @empty
                            <div class="text-center text-sm text-gray-500 p-6 border border-dashed rounded-lg">
                                Belum ada mata pelajaran ujian.
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white overflow-hidden shadow-sm rounded-xl border border-gray-100">
            <div class="px-6 py-4 border-b border-gray-100 bg-gray-50">
                <h3 class="font-bold text-lg text-gray-800">Jadwal Ujian Seleksi</h3>
            </div>
            <div class="p-6">
                <form action="{{ route('admin.seleksi-ujian.jadwal.store') }}" method="POST" class="grid grid-cols-1 md:grid-cols-4 xl:grid-cols-8 gap-3 mb-6">
                    @csrf
                    <select name="jalur_id" class="rounded-lg border-gray-300 text-sm" required>
                        <option value="">Pilih jalur</option>
                        @foreach($jalurs as $jalur)
                            <option value="{{ $jalur->id }}">{{ $jalur->nama_jalur }}</option>
                        @endforeach
                    </select>
                    <input type="date" name="tanggal_ujian" class="rounded-lg border-gray-300 text-sm" required>
                    <input type="time" name="waktu_mulai" class="rounded-lg border-gray-300 text-sm" required>
                    <input type="time" name="waktu_selesai" class="rounded-lg border-gray-300 text-sm" required>
                    <input type="date" name="tanggal_wawancara_btq" class="rounded-lg border-gray-300 text-sm">
                    <input type="time" name="waktu_wawancara_btq" class="rounded-lg border-gray-300 text-sm">
                    <input type="text" name="tempat_wawancara_btq" placeholder="Tempat wawancara/BTQ" class="rounded-lg border-gray-300 text-sm">
                    <button type="submit"
                        class="inline-flex justify-center items-center px-4 py-2 bg-emerald-100 text-emerald-700 font-bold rounded-lg border border-emerald-200 hover:bg-emerald-200 transition-colors text-sm">
                        Tambah
                    </button>
                </form>

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-50 border-b border-gray-200 text-sm text-gray-600">
                                <th class="p-4 font-semibold">Jalur</th>
                                <th class="p-4 font-semibold">Mapel</th>
                                <th class="p-4 font-semibold">Ujian</th>
                                <th class="p-4 font-semibold">Wawancara/BTQ</th>
                                <th class="p-4 font-semibold text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="text-sm divide-y divide-gray-100">
                            @forelse($jadwalUjians as $jadwal)
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <form action="{{ route('admin.seleksi-ujian.jadwal.update', $jadwal->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <td class="p-4">
                                            <select name="jalur_id" class="w-36 rounded-md border-gray-300 text-sm" required>
                                                @foreach($jalurs as $jalur)
                                                    <option value="{{ $jalur->id }}" {{ $jadwal->jalur_id == $jalur->id ? 'selected' : '' }}>
                                                        {{ $jalur->nama_jalur }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td class="p-4 text-gray-600">
                                            {{ $jadwal->jalur->mapels->pluck('nama_mapel')->join(', ') ?: '-' }}
                                        </td>
                                        <td class="p-4">
                                            <div class="space-y-2">
                                                <input type="date" name="tanggal_ujian" value="{{ $jadwal->tanggal_ujian->format('Y-m-d') }}"
                                                    class="w-36 rounded-md border-gray-300 text-sm" required>
                                                <div class="flex gap-2">
                                                    <input type="time" name="waktu_mulai" value="{{ \Illuminate\Support\Str::of($jadwal->waktu_mulai)->substr(0, 5) }}"
                                                        class="w-28 rounded-md border-gray-300 text-sm" required>
                                                    <input type="time" name="waktu_selesai" value="{{ \Illuminate\Support\Str::of($jadwal->waktu_selesai)->substr(0, 5) }}"
                                                        class="w-28 rounded-md border-gray-300 text-sm" required>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="p-4">
                                            <div class="space-y-2">
                                                <input type="date" name="tanggal_wawancara_btq" value="{{ $jadwal->tanggal_wawancara_btq ? $jadwal->tanggal_wawancara_btq->format('Y-m-d') : '' }}"
                                                    class="w-36 rounded-md border-gray-300 text-sm">
                                                <input type="time" name="waktu_wawancara_btq" value="{{ $jadwal->waktu_wawancara_btq ? \Illuminate\Support\Str::of($jadwal->waktu_wawancara_btq)->substr(0, 5) : '' }}"
                                                    class="w-28 rounded-md border-gray-300 text-sm">
                                                <input type="text" name="tempat_wawancara_btq" value="{{ $jadwal->tempat_wawancara_btq }}"
                                                    class="w-52 rounded-md border-gray-300 text-sm" placeholder="Tempat">
                                            </div>
                                        </td>
                                        <td class="p-4 text-right">
                                            <div class="flex justify-end gap-2">
                                                <button type="submit"
                                                    class="inline-flex items-center px-3 py-1.5 rounded-md border border-gray-200 bg-white text-xs font-medium text-emerald-600 hover:bg-gray-50 shadow-sm">
                                                    Simpan
                                                </button>
                                    </form>
                                                <form action="{{ route('admin.seleksi-ujian.jadwal.destroy', $jadwal->id) }}" method="POST"
                                                    onsubmit="return confirm('Hapus jadwal ini?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="inline-flex items-center px-3 py-1.5 rounded-md border border-gray-200 bg-white text-xs font-medium text-red-600 hover:bg-red-50 shadow-sm">
                                                        Hapus
                                                    </button>
                                                </form>
                                            </div>
                                    </td>
                                </tr>
                            @empty
                                <tr class="bg-white text-gray-500">
                                    <td class="p-8 text-center font-medium" colspan="5">Belum ada jadwal ujian.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="bg-white overflow-hidden shadow-sm rounded-xl border border-gray-100">
            <div class="px-6 py-4 border-b border-gray-100 bg-gray-50">
                <h3 class="font-bold text-lg text-gray-800">Kartu Peserta Ujian</h3>
                <p class="text-sm text-gray-500 mt-1">Peserta muncul setelah status berkas diterima.</p>
            </div>
            <div class="p-6">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-50 border-b border-gray-200 text-sm text-gray-600">
                                <th class="p-4 font-semibold">Peserta</th>
                                <th class="p-4 font-semibold">Jalur/Kampus</th>
                                <th class="p-4 font-semibold">Ruangan</th>
                                <th class="p-4 font-semibold">Jadwal</th>
                                <th class="p-4 font-semibold">Akun Ujian</th>
                                <th class="p-4 font-semibold text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="text-sm divide-y divide-gray-100">
                            @forelse($pendaftarans as $pendaftaran)
                                @php
                                    $kartu = $pendaftaran->kartuPesertaUjian;
                                    $defaultAkun = $pendaftaran->nisn ?: $pendaftaran->no_pendaftaran;
                                @endphp
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <form action="{{ route('admin.seleksi-ujian.kartu.update', $pendaftaran->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <td class="p-4">
                                            <p class="font-bold text-gray-800">{{ $pendaftaran->dataPribadi->nama_lengkap ?? $pendaftaran->user->name }}</p>
                                            <p class="text-xs text-gray-500 mt-1">{{ $pendaftaran->no_pendaftaran }}</p>
                                            <p class="text-xs text-gray-500">No. Kartu: {{ $kartu->nomor_peserta_ujian ?? '-' }}</p>
                                        </td>
                                        <td class="p-4 text-gray-600">
                                            {{ $pendaftaran->jalur->nama_jalur }}<br>
                                            <span class="text-xs">{{ $pendaftaran->kampus }}</span>
                                        </td>
                                        <td class="p-4">
                                            <select name="ruangan_id" class="w-36 rounded-md border-gray-300 text-sm" required>
                                                <option value="">Pilih</option>
                                                @foreach($ruangans as $ruangan)
                                                    <option value="{{ $ruangan->id }}" {{ optional($kartu)->ruangan_id == $ruangan->id ? 'selected' : '' }}>
                                                        {{ $ruangan->nama_ruangan }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td class="p-4">
                                            <select name="jadwal_ujian_id" class="w-52 rounded-md border-gray-300 text-sm" required>
                                                <option value="">Pilih jadwal</option>
                                                @foreach($jadwalUjians->where('jalur_id', $pendaftaran->jalur_id) as $jadwal)
                                                    <option value="{{ $jadwal->id }}" {{ optional($kartu)->jadwal_ujian_id == $jadwal->id ? 'selected' : '' }}>
                                                        {{ $jadwal->tanggal_ujian->format('d-m-Y') }} {{ \Illuminate\Support\Str::of($jadwal->waktu_mulai)->substr(0, 5) }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td class="p-4">
                                            <div class="space-y-2">
                                                <input type="text" name="username_ujian" value="{{ $kartu->username_ujian ?? $defaultAkun }}"
                                                    class="w-36 rounded-md border-gray-300 text-sm" required>
                                                <input type="text" name="password_ujian" value="{{ $kartu->password_ujian ?? $defaultAkun }}"
                                                    class="w-36 rounded-md border-gray-300 text-sm" required>
                                            </div>
                                        </td>
                                        <td class="p-4 text-right">
                                            <div class="flex justify-end gap-2">
                                                <button type="submit"
                                                    class="inline-flex items-center justify-center bg-white hover:bg-gray-50 text-emerald-600 font-medium border border-gray-200 px-3 py-1.5 rounded-md shadow-sm transition-colors text-xs">
                                                    Simpan
                                                </button>
                                                @if($kartu && $kartu->ruangan_id && $kartu->jadwal_ujian_id)
                                                    <a href="{{ route('admin.seleksi-ujian.kartu.cetak', $pendaftaran->id) }}" target="_blank"
                                                        class="inline-flex items-center justify-center bg-white hover:bg-gray-50 text-blue-600 font-medium border border-gray-200 px-3 py-1.5 rounded-md shadow-sm transition-colors text-xs">
                                                        Cetak
                                                    </a>
                                                @endif
                                            </div>
                                        </td>
                                    </form>
                                </tr>
                            @empty
                                <tr class="bg-white text-gray-500">
                                    <td class="p-8 text-center font-medium" colspan="6">Belum ada peserta dengan berkas diterima.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-6">
                    {{ $pendaftarans->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
