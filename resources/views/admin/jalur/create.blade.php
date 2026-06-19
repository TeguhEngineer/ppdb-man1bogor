<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-bold text-xl text-gray-800 leading-tight">
                {{ __('Tambah Jalur Pendaftaran') }}
            </h2>
            <a href="{{ route('admin.pengaturan-sistem.index') }}"
                class="text-sm text-emerald-600 hover:text-emerald-900 font-semibold">
                &larr; Kembali
            </a>
        </div>
    </x-slot>

    <div class="bg-white overflow-hidden shadow-sm rounded-xl border border-gray-100 mb-6">
        <form action="{{ route('admin.jalur.store') }}" method="POST" class="p-6 md:p-8">
            @include('admin.jalur._form')
        </form>
    </div>
</x-app-layout>
