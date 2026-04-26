<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-2">

            <i class="fi fi-rs-user text-2xl leading-none relative"></i>
            <h2 class="text-2xl font-semibold text-gray-800">Profil Saya</h2>
        </div>

        {{-- Breadcumb --}}
        <div class="flex gap-2 items-center">
            <i class="fi fi-rs-home text-sm"></i>
            <a href="{{ route('dashboard') }}" class="text-gray-800 text-sm gap-2">Beranda</a>
        </div>
    </x-slot>

    <div class="my-4 bg-white border border-gray-200 rounded-lg shadow-sm">
        <!-- Card 1: Profile Information -->
        <div class="p-6 border-b border-gray-200">
            <h2 class="text-lg font-medium text-gray-900">Informasi Profil</h2>
            <p class="mt-1 text-sm text-gray-600">Perbarui informasi profil akun dan alamat email Anda.</p>

            @if (session('error'))
                <div class="mt-4 bg-red-50 border border-red-200 text-red-600 px-4 py-3 rounded text-sm">
                    {{ session('error') }}
                </div>
            @endif

            <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6" enctype="multipart/form-data">
                @csrf
                @method('patch')

                <div>
                    <x-label for="foto_profil" :value="__('Foto Profil (Hanya bisa diisi jika Biodata sudah tersimpan)')" />
                    <input id="foto_profil" name="foto_profil" type="file" class="mt-1 block w-full text-sm text-gray-500
                        file:mr-4 file:py-2 file:px-4
                        file:rounded-md file:border-0
                        file:text-sm file:font-semibold
                        file:bg-indigo-50 file:text-indigo-700
                        hover:file:bg-indigo-100
                    " accept="image/jpeg, image/png, image/jpg" />
                    <x-error-message class="mt-2" :messages="$errors->get('foto_profil')" />
                    @php
                        $user = Auth::user();
                        $pendaftaran = $user->pendaftarans()->latest()->first();
                        $foto = $pendaftaran && $pendaftaran->biodata ? $pendaftaran->biodata->foto_profil : null;
                    @endphp
                    @if($foto)
                        <div class="mt-2">
                            <img src="{{ Storage::url($foto) }}" alt="Foto Profil Saat Ini" class="h-20 w-20 object-cover rounded-full border border-gray-200">
                        </div>
                    @endif
                </div>

                <div>
                    <x-label for="name" :value="__('Nama Lengkap')" />
                    <x-text-input id="name" name="name" type="text" class="mt-1 block w-full"
                        :value="old('name', $user->name)" required autofocus autocomplete="name" />
                    <x-error-message class="mt-2" :messages="$errors->get('name')" />
                </div>

                <div>
                    <x-label for="email" :value="__('Email')" />
                    <x-text-input id="email" name="email" type="email" class="mt-1 block w-full"
                        :value="old('email', $user->email)" required autocomplete="email" />
                    <x-error-message class="mt-2" :messages="$errors->get('email')" />
                </div>

                <div class="flex items-center gap-4">
                    <x-btn-primary>Simpan Profil</x-btn-primary>

                    @if (session('status') === 'profile-updated')
                        <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                            class="text-sm text-green-600 font-medium">Berhasil disimpan.</p>
                    @endif
                </div>
            </form>
        </div>

        <!-- Card 2: Update Password -->
        <div class="p-6 border-b border-gray-200">
            <h2 class="text-lg font-medium text-gray-900">Ubah Kata Sandi</h2>
            <p class="mt-1 text-sm text-gray-600">Pastikan akun Anda menggunakan kata sandi yang panjang dan acak agar tetap aman.
            </p>

            <form method="post" action="{{ route('password.update') }}" class="mt-6 space-y-6">
                @csrf
                @method('put')

                <div>
                    <x-label for="current_password" :value="__('Kata Sandi Saat Ini')" />
                    <x-text-input id="current_password" name="current_password" type="password"
                        class="mt-1 block w-full" autocomplete="current-password" />
                    <x-error-message class="mt-2" :messages="$errors->updatePassword->get('current_password')" />
                </div>

                <div>
                    <x-label for="password" :value="__('Kata Sandi Baru')" />
                    <x-text-input id="password" name="password" type="password" class="mt-1 block w-full"
                        autocomplete="new-password" />
                    <x-error-message class="mt-2" :messages="$errors->updatePassword->get('password')" />
                </div>

                <div>
                    <x-label for="password_confirmation" :value="__('Konfirmasi Kata Sandi Baru')" />
                    <x-text-input id="password_confirmation" name="password_confirmation" type="password"
                        class="mt-1 block w-full" autocomplete="new-password" />
                    <x-error-message class="mt-2" :messages="$errors->updatePassword->get('password_confirmation')" />
                </div>

                <div class="flex items-center gap-4">
                    <x-btn-primary>Simpan Kata Sandi</x-btn-primary>

                    @if (session('status') === 'password-updated')
                        <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                            class="text-sm text-green-600 font-medium">Berhasil disimpan.</p>
                    @endif
                </div>
            </form>
        </div>

        <!-- Card 3: Delete Account -->
        <div class="p-6">
            <h2 class="text-lg font-medium text-red-600">Hapus Akun</h2>
            <p class="mt-1 text-sm text-gray-600">
                Setelah akun Anda dihapus, semua data dan riwayat akan dihapus secara permanen.
            </p>

            <div class="mt-6">
                <x-btn-danger x-data=""
                    x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')">Hapus Akun</x-btn-danger>
            </div>

            <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
                <form method="post" action="{{ route('profile.destroy') }}" class="p-6">
                    @csrf
                    @method('delete')

                    <h2 class="text-lg font-medium text-gray-900">Apakah Anda yakin ingin menghapus akun ini?</h2>

                    <p class="mt-1 text-sm text-gray-600">
                        Tindakan ini bersifat permanen dan tidak dapat dibatalkan. Harap masukkan kata sandi Anda untuk mengonfirmasi.
                    </p>

                    <div class="mt-6">
                        <x-label for="password" value="Kata Sandi" class="sr-only" />

                        <x-text-input id="password" name="password" type="password" class="mt-1 block w-3/4"
                            placeholder="Kata Sandi Anda" />

                        <x-error-message class="mt-2" :messages="$errors->userDeletion->get('password')" />
                    </div>

                    <div class="mt-6 flex justify-end">
                        <x-btn-secondary x-on:click="$dispatch('close')">
                            Batal
                        </x-btn-secondary>

                        <x-btn-danger class="ml-3">
                            Ya, Hapus Akun
                        </x-btn-danger>
                    </div>
                </form>
            </x-modal>
        </div>
    </div>
</x-app-layout>
