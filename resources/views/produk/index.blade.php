<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-2">
            <i class="fi fi-rs-list text-2xl leading-none relative"></i>
            <h2 class="text-2xl font-semibold text-gray-800">Produk</h2>
        </div>

        <div class="flex gap-2 items-center">
            <i class="fi fi-rs-home text-sm"></i>
            <a href="" class="text-gray-800 text-sm gap-2">Index</a>
        </div>
    </x-slot>

    <div class="my-4 bg-white border border-gray-200 rounded-lg shadow-sm">
        <!-- Header with controls -->
        <div class="p-4 border-b border-gray-200">
            <div class="flex items-center justify-between gap-4">
                <div class="flex items-center gap-2">
                    <form action="{{ route('produk.index') }}" method="GET" class="flex items-center gap-2">
                        <div>
                            <x-select-input name="per_page" id="per_page" onchange="this.form.submit()">
                                <option value="10" {{ request('per_page') == 10 ? 'selected' : '' }}>10</option>
                                <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>25</option>
                                <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50</option>
                                <option value="100" {{ request('per_page') == 100 ? 'selected' : '' }}>100</option>
                            </x-select-input>
                        </div>

                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                            </div>
                            <x-text-input type="text" name="search" value="{{ request('search') }}"
                                placeholder="Cari produk..." class="pl-10 w-60" />
                        </div>

                        <x-btn-primary type="submit" class="md:hidden">
                            <i class="fi fi-rs-search relative top-0.5"></i>
                        </x-btn-primary>
                    </form>
                </div>

                <button data-modal-target="addModal"
                    class="flex items-center py-2.5 px-2 md:py-2 border border-blue-600 text-blue-600 hover:bg-blue-600 hover:text-white transition-colors duration-300 rounded-md">
                    <i class="fi fi-rs-plus md:mr-2 leading-none relative top-0.5"></i>
                    <span class="hidden md:block">Add Produk</span>
                </button>
            </div>
        </div>

        <!-- Modal Add Produk-->
        <div id="addModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
            <div class="fixed inset-0 bg-black bg-opacity-60"></div>
            <div class="flex items-center justify-center min-h-screen p-4">
                <div class="relative bg-white rounded-lg shadow-xl w-full max-w-md md:max-w-xl lg:max-w-2xl mx-auto">
                    <div class="flex justify-between items-center p-4 border-b">
                        <h3 class="text-xl font-semibold text-gray-900">
                            <i class="fi fi-rs-plus text-sm mr-2"></i>Tambah Produk
                        </h3>
                        <button type="button" class="text-gray-400 hover:text-gray-500" data-modal-hide="addModal">
                            <i class="fi fi-rs-cross-small text-xl"></i>
                        </button>
                    </div>

                    <form action="{{ route('produk.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="p-4 space-y-4">
                            <div>
                                <x-label for="name" required>Nama Produk</x-label>
                                <x-text-input class="w-full" id="name" name="name" type="text"
                                    placeholder="Masukkan nama produk" value="{{ old('name') }}" />
                                <x-error-message for="name" />
                            </div>

                            <div>
                                <x-label for="description">Deskripsi</x-label>
                                <textarea id="description" name="description" rows="3"
                                    class="w-full border-gray-300 focus:border-emerald-500 focus:ring-emerald-500 rounded-md shadow-sm"
                                    placeholder="Masukkan deskripsi produk">{{ old('description') }}</textarea>
                                <x-error-message for="description" />
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <x-label for="price" required>Harga</x-label>
                                    <x-text-input class="w-full" id="price" name="price" type="number"
                                        step="0.01" placeholder="0" value="{{ old('price') }}" />
                                    <x-error-message for="price" />
                                </div>

                                <div>
                                    <x-label for="stock" required>Stok</x-label>
                                    <x-text-input class="w-full" id="stock" name="stock" type="number"
                                        placeholder="0" value="{{ old('stock') }}" />
                                    <x-error-message for="stock" />
                                </div>
                            </div>

                            <div>
                                <x-label for="image">Gambar Produk</x-label>
                                <input type="file" id="image" name="image" accept="image/*"
                                    class="w-full border-gray-300 focus:border-emerald-500 focus:ring-emerald-500 rounded-md shadow-sm" />
                                <x-error-message for="image" />
                                <p class="text-xs text-gray-500 mt-1">Format: JPG, PNG, GIF. Maksimal 2MB</p>
                            </div>
                        </div>

                        <div class="p-4 border-t flex justify-end space-x-3">
                            <x-btn-secondary type="button" data-modal-hide="addModal">Batal</x-btn-secondary>
                            <x-btn-primary type="submit">Simpan</x-btn-primary>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Table -->
        <div class="p-4">
            <div class="overflow-x-auto rounded-md">
                <table class="min-w-full text-left text-gray-500">
                    <thead class="bg-gray-100 text-sm text-gray-700 uppercase">
                        <tr>
                            <th scope="col" class="px-2 py-3 w-12 text-center">No.</th>
                            <th scope="col" class="p-3">Gambar</th>
                            <th scope="col" class="p-3">Nama Produk</th>
                            <th scope="col" class="p-3">Harga</th>
                            <th scope="col" class="p-3">Stok</th>
                            <th scope="col" class="p-3">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($produks as $data)
                            <tr class="bg-white text-gray-900 border-b hover:bg-gray-100">
                                <td class="px-2 py-3 text-center">{{ ++$i }}</td>
                                <td class="p-3">
                                    @if ($data->image)
                                        <img src="{{ asset('storage/' . $data->image) }}" alt="{{ $data->name }}"
                                            class="w-16 h-16 object-cover rounded">
                                    @else
                                        <div class="w-16 h-16 bg-gray-200 rounded flex items-center justify-center">
                                            <i class="fi fi-rs-image text-gray-400 text-2xl"></i>
                                        </div>
                                    @endif
                                </td>
                                <td class="p-3">
                                    <div class="font-medium">{{ $data->name }}</div>
                                    @if ($data->description)
                                        <div class="text-sm text-gray-500">{{ Str::limit($data->description, 50) }}
                                        </div>
                                    @endif
                                </td>
                                <td class="p-3">Rp {{ number_format($data->price, 0, ',', '.') }}</td>
                                <td class="p-3">
                                    <span
                                        class="px-2.5 py-0.5 text-xs rounded-full {{ $data->stock > 0 ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ $data->stock }}
                                    </span>
                                </td>
                                <td class="p-3">
                                    <div class="flex items-center gap-2">
                                        <x-btn-warning data-modal-target="editModal{{ $data->id }}">
                                            <i class="fi fi-rs-pencil leading-none relative top-0.5"></i>
                                        </x-btn-warning>
                                        <x-btn-danger data-modal-target="deleteModal{{ $data->id }}">
                                            <i class="fi fi-rs-trash leading-none relative top-0.5"></i>
                                        </x-btn-danger>
                                    </div>
                                </td>
                            </tr>

                            <!-- Modal Edit -->
                            <div id="editModal{{ $data->id }}" class="fixed inset-0 z-50 hidden overflow-y-auto">
                                <div class="fixed inset-0 bg-black bg-opacity-60"></div>
                                <div class="flex items-center justify-center min-h-screen p-4">
                                    <div
                                        class="relative bg-white rounded-lg shadow-xl w-full max-w-md md:max-w-xl lg:max-w-2xl mx-auto">
                                        <div class="flex justify-between items-center p-4 border-b">
                                            <h3 class="text-xl font-semibold text-gray-900">
                                                <i class="fi fi-rs-pencil text-sm mr-2"></i>Edit Produk
                                            </h3>
                                            <button type="button" class="text-gray-400 hover:text-gray-500"
                                                data-modal-hide="editModal{{ $data->id }}">
                                                <i class="fi fi-rs-cross-small text-xl"></i>
                                            </button>
                                        </div>

                                        <form action="{{ route('produk.update', $data->id) }}" method="POST"
                                            enctype="multipart/form-data">
                                            @csrf
                                            @method('PUT')
                                            <div class="p-4 space-y-4">
                                                <div>
                                                    <x-label for="name" required>Nama Produk</x-label>
                                                    <x-text-input class="w-full" id="name" name="name"
                                                        type="text" value="{{ old('name', $data->name) }}" />
                                                    <x-error-message for="name" />
                                                </div>

                                                <div>
                                                    <x-label for="description">Deskripsi</x-label>
                                                    <textarea id="description" name="description" rows="3"
                                                        class="w-full border-gray-300 focus:border-emerald-500 focus:ring-emerald-500 rounded-md shadow-sm">{{ old('description', $data->description) }}</textarea>
                                                    <x-error-message for="description" />
                                                </div>

                                                <div class="grid grid-cols-2 gap-4">
                                                    <div>
                                                        <x-label for="price" required>Harga</x-label>
                                                        <x-text-input class="w-full" id="price" name="price"
                                                            type="number" step="0.01"
                                                            value="{{ old('price', $data->price) }}" />
                                                        <x-error-message for="price" />
                                                    </div>

                                                    <div>
                                                        <x-label for="stock" required>Stok</x-label>
                                                        <x-text-input class="w-full" id="stock" name="stock"
                                                            type="number" value="{{ old('stock', $data->stock) }}" />
                                                        <x-error-message for="stock" />
                                                    </div>
                                                </div>

                                                <div>
                                                    <x-label for="image">Gambar Produk</x-label>
                                                    @if ($data->image)
                                                        <img src="{{ asset('storage/' . $data->image) }}"
                                                            alt="{{ $data->name }}"
                                                            class="w-32 h-32 object-cover rounded mb-2">
                                                    @endif
                                                    <input type="file" id="image" name="image" accept="image/*"
                                                        class="w-full border-gray-300 focus:border-emerald-500 focus:ring-emerald-500 rounded-md shadow-sm" />
                                                    <x-error-message for="image" />
                                                    <p class="text-xs text-gray-500 mt-1">Kosongkan jika tidak ingin
                                                        mengubah gambar</p>
                                                </div>
                                            </div>

                                            <div class="p-4 border-t flex justify-end space-x-3">
                                                <x-btn-secondary type="button"
                                                    data-modal-hide="editModal{{ $data->id }}">
                                                    Batal
                                                </x-btn-secondary>
                                                <x-btn-primary type="submit">Simpan</x-btn-primary>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <!-- Modal Delete -->
                            <div id="deleteModal{{ $data->id }}" class="fixed inset-0 z-50 hidden overflow-y-auto">
                                <div class="fixed inset-0 bg-black bg-opacity-60"></div>
                                <div class="flex items-center justify-center min-h-screen p-4">
                                    <div
                                        class="relative bg-white rounded-lg shadow-xl w-full max-w-sm md:max-w-md mx-auto">
                                        <div class="flex justify-between items-center p-4 border-b">
                                            <h3 class="text-lg font-semibold text-gray-900">
                                                <i class="fi fi-rs-trash text-sm mr-2"></i>Hapus Produk
                                            </h3>
                                            <button type="button" class="text-gray-400 hover:text-gray-500"
                                                data-modal-hide="deleteModal{{ $data->id }}">
                                                <i class="fi fi-rs-cross-small text-xl"></i>
                                            </button>
                                        </div>

                                        <form action="{{ route('produk.destroy', $data->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <div class="p-4">
                                                <p class="text-center text-gray-900">
                                                    Apakah anda yakin ingin menghapus produk
                                                    <strong>"{{ $data->name }}"</strong>?
                                                </p>
                                            </div>

                                            <div class="p-4 border-t flex justify-end space-x-3">
                                                <x-btn-secondary type="button"
                                                    data-modal-hide="deleteModal{{ $data->id }}">
                                                    Batal
                                                </x-btn-secondary>
                                                <x-btn-danger type="submit">Hapus</x-btn-danger>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <tr>
                                <td colspan="6" class="p-4 text-center text-gray-500">Data produk tidak ditemukan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="p-4 border-t border-gray-200">
            {{ $produks->links() }}
        </div>
    </div>

    @push('js')
        @if (session('edit_id'))
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const editModal = document.getElementById('editModal{{ session('edit_id') }}');
                    if (editModal) {
                        editModal.classList.remove('hidden');
                    }
                });
            </script>
        @endif
        @if (session('add'))
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const addModal = document.getElementById('addModal');
                    if (addModal) {
                        addModal.classList.remove('hidden');
                    }
                });
            </script>
        @endif
    @endpush
</x-app-layout>
