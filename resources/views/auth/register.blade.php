<x-guest-layout>
    @php
        $jalur = request()->query('jalur');
        $namaJalur = 'Pendaftaran Siswa Baru';
        $badge = 'PORTAL RESMI';
        if ($jalur == 'reguler') {
            $namaJalur = 'Jalur Reguler';
            $badge = 'ZONASI DAN UMUM';
        } elseif ($jalur == 'prestasi') {
            $namaJalur = 'Jalur Prestasi';
            $badge = 'AKADEMIK & NON-AKADEMIK';
        } elseif ($jalur == 'afirmasi') {
            $namaJalur = 'Jalur Afirmasi';
            $badge = 'KELUARGA TIDAK MAMPU';
        }
    @endphp

    <div class="mb-8 text-center">
        <div class="inline-block px-3 py-1 bg-[#fdce06]/20 text-[#22690f] text-xs font-bold rounded-full mb-3 uppercase tracking-widest border border-[#fdce06]/30">
            {{ $badge }}
        </div>
        <h2 class="text-3xl font-extrabold text-gray-900 tracking-tight">{{ $namaJalur }}</h2>
        <p class="text-sm text-gray-500 mt-2 font-medium">Lengkapi data akun di bawah ini dengan valid.</p>
    </div>

    @if($errors->has('error'))
        <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-xl relative" role="alert">
            <span class="block sm:inline text-sm font-medium">{{ $errors->first('error') }}</span>
        </div>
    @endif

    <form method="POST" action="{{ route('register') }}" class="space-y-4">
        @csrf

        @if($jalur)
            <input type="hidden" name="jalur" value="{{ $jalur }}">
        @endif

        <!-- Name -->
        <div>
            <label for="name" class="block font-medium text-sm text-gray-700 mb-1">Nama Lengkap Sesuai Ijazah</label>
            <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name"
                class="w-full border border-gray-300 focus:border-[#22690f] focus:ring focus:ring-[#22690f] focus:ring-opacity-20 rounded-xl shadow-sm px-4 py-3 text-sm transition-all bg-gray-50 hover:bg-white" placeholder="Contoh: Budi Santoso" />
            @error('name')
                <p class="mt-1 text-sm text-red-600 font-medium">{{ $message }}</p>
            @enderror
        </div>

        <!-- NISN -->
        <div>
            <label for="nisn" class="block font-medium text-sm text-gray-700 mb-1">NISN (Nomor Induk Siswa Nasional)</label>
            <input id="nisn" type="text" name="nisn" value="{{ old('nisn') }}" required
                class="w-full border border-gray-300 focus:border-[#22690f] focus:ring focus:ring-[#22690f] focus:ring-opacity-20 rounded-xl shadow-sm px-4 py-3 text-sm transition-all bg-gray-50 hover:bg-white" placeholder="Masukkan 10 digit NISN" />
            @error('nisn')
                <p class="mt-1 text-sm text-red-600 font-medium">{{ $message }}</p>
            @enderror
        </div>

        <!-- Email Address -->
        <div>
            <label for="email" class="block font-medium text-sm text-gray-700 mb-1">Email Aktif</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="username"
                class="w-full border border-gray-300 focus:border-[#22690f] focus:ring focus:ring-[#22690f] focus:ring-opacity-20 rounded-xl shadow-sm px-4 py-3 text-sm transition-all bg-gray-50 hover:bg-white" placeholder="contoh@gmail.com" />
            @error('email')
                <p class="mt-1 text-sm text-red-600 font-medium">{{ $message }}</p>
            @enderror
        </div>

        <!-- Password -->
        <div>
            <label for="password" class="block font-medium text-sm text-gray-700 mb-1">Password (isi sama dengan NISN)</label>
            <input id="password" type="password" name="password" required autocomplete="new-password"
                class="w-full border border-gray-300 focus:border-[#22690f] focus:ring focus:ring-[#22690f] focus:ring-opacity-20 rounded-xl shadow-sm px-4 py-3 text-sm transition-all bg-gray-50 hover:bg-white" placeholder="Masukkan 10 digit NISN" />
            @error('password')
                <p class="mt-1 text-sm text-red-600 font-medium">{{ $message }}</p>
            @enderror
        </div>

        <div class="pt-6 flex flex-col gap-4">
            <button type="submit" class="w-full bg-[#22690f] hover:bg-[#1a500b] text-white px-6 py-3.5 rounded-xl font-bold transition-all shadow-md hover:shadow-lg transform hover:-translate-y-0.5">
                Daftar {{ $namaJalur }}
            </button>
            <p class="text-center text-sm text-gray-500">
                Sudah punya akun? 
                <a href="{{ route('login') }}" class="font-bold text-[#22690f] hover:text-[#fdce06] transition-colors">Masuk di sini</a>
            </p>
        </div>
    </form>
</x-guest-layout>
