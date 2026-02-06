<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-2">

            <i class="fi fi-rs-users text-2xl leading-none relative"></i>
            <h2 class="text-2xl font-semibold text-gray-800">User Manajemen</h2>
        </div>

        {{-- Breadcumb --}}
        <div class="flex gap-2 items-center">
            <i class="fi fi-rs-home text-sm"></i>
            <a href="" class="text-gray-800 text-sm gap-2">Index</a>
            {{-- <span class="text-xs">/</span>
            <i class="fi fi-rs-home"></i>
            <a href="" class="text-gray-800 text-sm">Index</a> --}}
        </div>
    </x-slot>

    <div class="my-4 bg-white border border-gray-200 rounded-lg shadow-sm">
        <!-- Header with controls -->
        <div class="p-4 border-b border-gray-200">
            <div class="flex items-center justify-between gap-4">

                <div class="flex items-center gap-2">
                    <form action="{{ route('user-manajemen.index') }}" method="GET" class="flex items-center gap-2">
                        <!-- Select per page -->
                        <div>
                            <x-select-input name="per_page" id="per_page" onchange="this.form.submit()">
                                <option value="10" {{ request('per_page') == 10 ? 'selected' : '' }}>10</option>
                                <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>25</option>
                                <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50</option>
                                <option value="100" {{ request('per_page') == 100 ? 'selected' : '' }}>100</option>
                            </x-select-input>
                        </div>

                        <!-- Search input using Laravel Breeze component -->
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                            </div>
                            <x-text-input type="text" name="search" value="{{ request('search') }}"
                                placeholder="Cari..." class="pl-10 w-60" />
                        </div>

                        <!-- Submit button -->
                        <x-btn-primary type="submit" class="md:hidden">
                            <i class="fi fi-rs-search relative top-0.5"></i>
                        </x-btn-primary>
                    </form>
                </div>

                <!-- Button Add User -->
                <div class="flex gap-2">
                    <button data-modal-target="addModal"
                        class="flex items-center py-2.5 px-2 md:py-2 border border-blue-600 text-blue-600 hover:bg-blue-600 hover:text-white transition-colors duration-300 rounded-md">
                        <i class="fi fi-rs-plus md:mr-2 leading-none relative top-0.5"></i>
                        <span class="hidden md:block">
                            Add User
                        </span>
                    </button>
                    <a href="{{ route('user.export-xls') }}"
                        class="flex items-center py-2.5 px-2 md:py-2 border border-green-600 text-green-600 hover:bg-green-600 hover:text-white transition-colors duration-300 rounded-md">
                        <i class="fi fi-rs-file-excel md:mr-2 leading-none relative top-0.5"></i>
                        <span class="hidden md:block">
                            Export Excel
                        </span>
                    </a>
                </div>
            </div>
        </div>

        <!-- Modal Add User-->
        <div id="addModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
            <!-- Backdrop -->
            <div class="fixed inset-0 bg-black bg-opacity-60"></div>

            <div class="flex items-center justify-center min-h-screen p-4">
                <div id="modalContent"
                    class="relative bg-white rounded-lg shadow-xl w-full max-w-md md:max-w-xl lg:max-w-2xl mx-auto transition-all duration-300 transform">
                    <!-- Modal Header -->
                    <div class="flex justify-between items-center p-4 border-b">
                        <h3 class="text-xl font-semibold text-gray-900"> <i
                                class="fi fi-rs-plus text-sm mr-2"></i>Tambah
                            User</h3>
                        <button type="button" class="text-gray-400 hover:text-gray-500 focus:outline-none"
                            data-modal-hide="addModal">
                            <i class="fi fi-rs-cross-small text-xl"></i>
                        </button>
                    </div>

                    <!-- Modal Body with Form -->
                    <form action="{{ route('user-manajemen.store') }}" method="POST">
                        @csrf
                        <div class="p-4 space-y-4">
                            <!-- Nama -->
                            <div>
                                <x-label for="name" required>Nama</x-label>
                                <x-text-input class="w-full" id="name" name="name" type="text"
                                    placeholder="Masukkan nama lengkap" value="{{ old('name') }}" />
                                <x-error-message for="name" />
                            </div>

                            <!-- Email -->
                            <div>
                                <x-label for="email" required>Email</x-label>
                                <x-text-input class="w-full" id="email" name="email" type="email"
                                    placeholder="Masukkan alamat email" value="{{ old('email') }}" />
                                <x-error-message for="email" />
                            </div>

                            <!-- Password -->
                            <div>
                                <x-label for="password" required>Password</x-label>
                                <x-text-input class="w-full" id="password" name="password" type="password"
                                    placeholder="Masukkan password" />
                                <x-error-message for="password" />
                            </div>

                            <!-- Konfirmasi Password -->
                            <div>
                                <x-label for="password_confirmation" required>Konfirmasi Password</x-label>
                                <x-text-input class="w-full" id="password_confirmation" name="password_confirmation"
                                    type="password" placeholder="Masukkan password" />
                            </div>

                            <!-- Telepon -->
                            <div>
                                <x-label for="telepon">Nomor Telepon</x-label>
                                <x-text-input class="w-full" id="telepon" name="telepon" type="tel"
                                    placeholder="Masukkan nomor telepon" value="{{ old('telepon') }}" />
                                <x-error-message for="telepon" />
                            </div>

                            <!-- Role -->
                            <div>
                                <x-label for="role" required>Role</x-label>
                                <x-select-input id="role" class="w-full" name="role">
                                    <option selected disabled>-- Pilih Role --</option>
                                    <option value="administrator"
                                        {{ old('role') == 'administrator' ? 'selected' : '' }}>Administrator</option>
                                    <option value="operator" {{ old('role') == 'operator' ? 'selected' : '' }}>
                                        Operator
                                    </option>
                                </x-select-input>
                                <x-error-message for="role" />
                            </div>
                        </div>

                        <!-- Modal Footer -->
                        <div class="p-4 border-t flex justify-end space-x-3">
                            <x-btn-secondary type="button" data-modal-hide="addModal">
                                Batal
                            </x-btn-secondary>

                            <x-btn-primary type="submit">
                                Simpan
                            </x-btn-primary>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Table container -->
        <div class="p-4">
            <div class="overflow-x-auto rounded-md">
                <table class="min-w-full text-left text-gray-500">
                    <thead class="bg-gray-100 text-sm text-gray-700 uppercase">
                        <tr>
                            <th scope="col" class="px-2 py-3 w-12 text-center">No.</th>
                            <th scope="col" class="p-3">Nama</th>
                            <th scope="col" class="p-3">No. Telepon</th>
                            <th scope="col" class="p-3">Email</th>
                            <th scope="col" class="p-3">Role</th>
                            <th scope="col" class="p-3">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($users as $data)
                            <tr class="bg-white text-gray-900 border-b hover:bg-gray-100">
                                <td class="px-2 py-3 text-center">{{ ++$i }}</td>
                                <td class="p-3 ">{{ $data->name }}</td>
                                <td class="p-3 ">{{ $data->telepon ?? 'Belum ada nomor telepon.' }} </td>
                                <td class="p-3">{{ $data->email }}</td>
                                <td class="p-3">
                                    @if ($data->role == 'administrator')
                                        <span
                                            class="px-2.5 py-0.5 text-xs rounded-full bg-yellow-100 text-yellow-800">{{ $data->role }}</span>
                                    @else
                                        <span
                                            class="px-2.5 py-0.5 text-xs rounded-full bg-blue-100 text-blue-800">{{ $data->role }}</span>
                                    @endif
                                </td>
                                <td class="p-3">
                                    <div class="flex items-center gap-2">
                                        <x-btn-warning data-modal-target="editModal{{ $data->id }}"><i
                                                class="fi fi-rs-pencil leading-none relative top-0.5"></i></x-btn-warning>
                                        <x-btn-danger data-modal-target="deleteModal{{ $data->id }}"><i
                                                class="fi fi-rs-trash leading-none relative top-0.5"></i></x-btn-danger>
                                    </div>
                                </td>
                            </tr>

                            <!-- Modal Edit User-->
                            <div id="editModal{{ $data->id }}" class="fixed inset-0 z-50 hidden overflow-y-auto">
                                <!-- Backdrop -->
                                <div class="fixed inset-0 bg-black bg-opacity-60"></div>

                                <div class="flex items-center justify-center min-h-screen p-4">
                                    <div id="modalContent"
                                        class="relative bg-white rounded-lg shadow-xl w-full max-w-md md:max-w-xl lg:max-w-2xl mx-auto transition-all duration-300 transform">
                                        <!-- Modal Header -->
                                        <div class="flex justify-between items-center p-4 border-b">
                                            <h3 class="text-xl font-semibold text-gray-900"> <i
                                                    class="fi fi-rs-pencil text-sm mr-2"></i>Edit
                                                User</h3>
                                            <button type="button"
                                                class="text-gray-400 hover:text-gray-500 focus:outline-none"
                                                data-modal-hide="editModal{{ $data->id }}">
                                                <i class="fi fi-rs-cross-small text-xl"></i>
                                            </button>
                                        </div>

                                        <!-- Modal Body with Form -->
                                        <form action="{{ route('user-manajemen.update', $data->id) }}"
                                            method="POST">
                                            @csrf
                                            @method('PUT')
                                            <div class="p-4 space-y-4">
                                                <!-- Nama -->
                                                <div>
                                                    <x-label for="name" required>Nama</x-label>
                                                    <x-text-input class="w-full" id="name" name="name"
                                                        type="text" placeholder="Masukkan nama lengkap"
                                                        value="{{ old('name', $data->name) }}" />
                                                    <x-error-message for="name" />
                                                </div>

                                                <!-- Email -->
                                                <div>
                                                    <x-label for="email" required>Email</x-label>
                                                    <x-text-input class="w-full" id="email" name="email"
                                                        type="email" placeholder="Masukkan alamat email"
                                                        value="{{ old('email', $data->email) }}" />
                                                    <x-error-message for="email" />
                                                </div>

                                                <!-- Password -->
                                                {{-- <div>
                                                    <x-label for="password" required>Password</x-label>
                                                    <x-text-input class="w-full" id="password" name="password"
                                                        type="password" placeholder="Masukkan password" />
                                                    <x-error-message for="password" />
                                                </div> --}}

                                                <!-- Konfirmasi Password -->
                                                {{-- <div>
                                                    <x-label for="password_confirmation" required>Konfirmasi
                                                        Password</x-label>
                                                    <x-text-input class="w-full" id="password_confirmation"
                                                        name="password_confirmation" type="password"
                                                        placeholder="Masukkan password" />
                                                </div> --}}

                                                <!-- Telepon -->
                                                <div>
                                                    <x-label for="telepon">Nomor Telepon</x-label>
                                                    <x-text-input class="w-full" id="telepon" name="telepon"
                                                        type="number" placeholder="Masukkan nomor telepon"
                                                        value="{{ old('telepon', $data->telepon) }}" />
                                                    <x-error-message for="telepon" />
                                                </div>

                                                <!-- Role -->
                                                <div>
                                                    <x-label for="role" required>Role</x-label>
                                                    <x-select-input id="role" class="w-full" name="role">
                                                        <option selected disabled>-- Pilih Role --</option>
                                                        <option value="administrator"
                                                            {{ old('role') == 'administrator' || $data->role == 'administrator' ? 'selected' : '' }}>
                                                            Administrator
                                                        </option>
                                                        <option value="operator"
                                                            {{ old('role') == 'operator' || $data->role == 'operator' ? 'selected' : '' }}>
                                                            Operator
                                                        </option>
                                                    </x-select-input>
                                                    <x-error-message for="role" />
                                                </div>
                                            </div>

                                            <!-- Modal Footer -->
                                            <div class="p-4 border-t flex justify-end space-x-3">
                                                <x-btn-secondary type="button"
                                                    data-modal-hide="editModal{{ $data->id }}">
                                                    Batal
                                                </x-btn-secondary>

                                                <x-btn-primary type="submit">
                                                    Simpan
                                                </x-btn-primary>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <!-- Modal Delete User-->
                            <div id="deleteModal{{ $data->id }}"
                                class="fixed inset-0 z-50 hidden overflow-y-auto">
                                <!-- Backdrop -->
                                <div class="fixed inset-0 bg-black bg-opacity-60"></div>

                                <div class="flex items-center justify-center min-h-screen p-4">
                                    <div id="modalContent"
                                        class="relative bg-white rounded-lg shadow-xl w-full max-w-sm md:max-w-md lg:max-w-md mx-auto transition-all duration-300 transform">
                                        <!-- Modal Header -->
                                        <div class="flex justify-between items-center p-4 border-b">
                                            <h3 class="text-lg font-semibold text-gray-900"> <i
                                                    class="fi fi-rs-trash text-sm mr-2"></i>Delete
                                                User "{{ $data->name }}"</h3>
                                            <button type="button"
                                                class="text-gray-400 hover:text-gray-500 focus:outline-none"
                                                data-modal-hide="deleteModal{{ $data->id }}">
                                                <i class="fi fi-rs-cross-small text-xl"></i>
                                            </button>
                                        </div>

                                        <!-- Modal Body with Form -->
                                        <form action="{{ route('user-manajemen.destroy', $data->id) }}"
                                            method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <div class="p-4 space-y-4">
                                                <p class="text-center text-gray-900">
                                                    Apakah anda yakin ingin menghapus user ini?
                                                </p>
                                            </div>

                                            <!-- Modal Footer -->
                                            <div class="p-4 border-t flex justify-end space-x-3">
                                                <x-btn-secondary type="button"
                                                    data-modal-hide="deleteModal{{ $data->id }}">
                                                    Batal
                                                </x-btn-secondary>

                                                <x-btn-danger type="submit">
                                                    Hapus
                                                </x-btn-danger>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <tr>
                                <td colspan="6" class="p-4 text-center text-gray-500">Data tidak ditemukan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Pagination would go here -->
        <div class="p-4 border-t border-gray-200">
            {{ $users->links() }}
        </div>
    </div>

    @push('js')
        @if (session('edit_id') == $data->id)
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const editModal = document.getElementById('editModal{{ $data->id }}');
                    if (editModal) {
                        editModal.classList.remove('hidden');

                        // Tambahkan ini untuk scroll ke modal jika perlu
                        editModal.scrollIntoView({
                            behavior: 'smooth'
                        });
                    }
                });
            </script>
        @endif
        @if (session('add'))
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const editModal = document.getElementById('addModal');
                    if (editModal) {
                        editModal.classList.remove('hidden');

                        // Tambahkan ini untuk scroll ke modal jika perlu
                        editModal.scrollIntoView({
                            behavior: 'smooth'
                        });
                    }
                });
            </script>
        @endif
    @endpush

</x-app-layout>
