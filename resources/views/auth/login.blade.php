<x-guest-layout>
    <div class="mb-8 text-center">
        <h2 class="text-2xl font-bold text-gray-900">Masuk ke Akun</h2>
        <p class="text-sm text-gray-500 mt-2">Masukkan email dan password yang terdaftar.</p>
    </div>

    <!-- Session Status -->
    @if (session('status'))
        <div class="mb-4 font-medium text-sm text-green-600">
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}" class="space-y-5">
        @csrf

        <!-- Email -->
        <div>
            <label for="email" class="block font-medium text-sm text-gray-700 mb-1">Email</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                autocomplete="username"
                class="w-full border border-gray-300 focus:border-[#22690f] focus:ring focus:ring-[#22690f] focus:ring-opacity-20 rounded-xl shadow-sm px-4 py-3 text-sm transition-all bg-gray-50 hover:bg-white"
                placeholder="Masukkan email aktif" />
            @error('email')
                <p class="mt-2 text-sm text-red-600 font-medium">{{ $message }}</p>
            @enderror
        </div>

        <!-- Password -->
        <div>
            <label for="password" class="block font-medium text-sm text-gray-700 mb-1">Password</label>
            <input id="password" type="password" name="password" required autocomplete="current-password"
                class="w-full border border-gray-300 focus:border-[#22690f] focus:ring focus:ring-[#22690f] focus:ring-opacity-20 rounded-xl shadow-sm px-4 py-3 text-sm transition-all bg-gray-50 hover:bg-white"
                placeholder="Peserta gunakan NISN saat daftar" />
            @error('password')
                <p class="mt-2 text-sm text-red-600 font-medium">{{ $message }}</p>
            @enderror
        </div>

        <div class="pt-4 flex flex-col gap-4">
            <button type="submit"
                class="w-full bg-[#22690f] hover:bg-[#1a500b] text-white px-6 py-3.5 rounded-xl font-bold transition-all shadow-md hover:shadow-lg transform hover:-translate-y-0.5">
                Masuk Sekarang
            </button>
            <p class="text-center text-sm text-gray-500">
                Belum punya akun?
                <a href="/#jalur-pendaftaran-section"
                    class="font-bold text-[#22690f] hover:text-[#fdce06] transition-colors">Daftar di sini</a>
            </p>
        </div>
    </form>
</x-guest-layout>
