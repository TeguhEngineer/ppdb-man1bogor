<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <link rel="icon" type="image/png" href="{{ asset('logo.png') }}">
    {{-- Icon FlatIcon --}}
    <link rel='stylesheet'
        href='https://cdn-uicons.flaticon.com/2.6.0/uicons-regular-straight/css/uicons-regular-straight.css'>
    <link rel='stylesheet'
        href='https://cdn-uicons.flaticon.com/2.6.0/uicons-solid-straight/css/uicons-solid-straight.css'>
    <style>[x-cloak]{display:none!important;}</style>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-emerald-50 antialiased">
    <div class="flex h-screen overflow-hidden">
        <!-- Mobile Overlay -->
        <div id="overlay" onclick="toggleSidebar()"
            class="fixed inset-0 bg-gray-900 bg-opacity-50 z-20 hidden md:hidden"></div>

        <!-- Sidebar -->
        <div id="sidebar"
            class="fixed md:static w-64 bg-white h-full border-r border-gray-200 z-30 transition-transform duration-300 ease-in-out -translate-x-full md:translate-x-0">


            <!-- Sidebar -->
            @include('layouts.sidebar')
        </div>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden">

            @if (session('success'))
                <x-toast-success>{{ session('success') }}</x-toast-success>
            @elseif (session('error'))
                <x-toast-danger>{{ session('error') }}</x-toast-danger>
            @elseif (session('warning'))
                <x-toast-warning>{{ session('warning') }}</x-toast-warning>
            @endif

            <!-- Navigation -->
            @include('layouts.navigation')

            <!-- Content Area -->
            <div class="flex-1 overflow-auto p-4 md:p-8">
                <!-- Content would go here -->
                @isset($header)
                    <div class="mb-6 flex justify-between items-center">
                        {{ $header }}
                    </div>
                @endisset

                {{ $slot }}
            </div>
        </div>
    </div>

    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('overlay');

            // Toggle sidebar visibility
            sidebar.classList.toggle('translate-x-0');
            sidebar.classList.toggle('-translate-x-full');

            // Toggle overlay visibility
            if (sidebar.classList.contains('translate-x-full')) {
                overlay.classList.remove('hidden');
            } else {
                overlay.classList.add('hidden');
            }
        }

        // Modal
        document.addEventListener('DOMContentLoaded', function() {
            // Buka modal
            document.querySelectorAll('[data-modal-target]').forEach(button => {
                button.addEventListener('click', function() {
                    const modalId = this.getAttribute('data-modal-target');
                    const modal = document.getElementById(modalId);
                    modal.classList.remove('hidden');
                    document.body.classList.add('overflow-hidden');
                });
            });

            // Tutup modal
            document.querySelectorAll('[data-modal-hide]').forEach(button => {
                button.addEventListener('click', function() {
                    const modalId = this.getAttribute('data-modal-hide');
                    const modal = document.getElementById(modalId);
                    modal.classList.add('hidden');
                    document.body.classList.remove('overflow-hidden');
                });
            });

            // Tutup saat klik backdrop
            document.querySelectorAll('.modal').forEach(modal => {
                modal.addEventListener('click', function(e) {
                    if (e.target === this) {
                        this.classList.add('hidden');
                        document.body.classList.remove('overflow-hidden');
                    }
                });
            });
        });
    </script>

    @stack('js')

</body>

</html>
