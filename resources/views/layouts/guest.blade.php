<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>PPDB MAN 1 BOGOR - Authentication</title>
    <link rel="icon" type="image/png" href="{{ asset('logo.png') }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
    </style>
</head>

<body class="font-sans text-gray-800 antialiased bg-gray-50 selection:bg-[#22690f] selection:text-white">
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 pb-12 relative overflow-hidden">

        <!-- Decoration background -->
        <div
            class="absolute top-0 left-0 w-full h-64 bg-[#22690f] -z-10 rounded-b-[4rem] sm:rounded-b-[10rem] shadow-lg">
        </div>

        <!-- Logo -->
        <div class="mt-8 sm:mt-12 flex flex-col items-center z-10 px-4">
            <a href="/" class="flex flex-col items-center gap-2 group">
                <img src="/logo.png" alt="Logo MAN 1 BOGOR"
                    class="h-20 w-auto object-contain drop-shadow-md transition-transform group-hover:scale-105">
                <span
                    class="font-extrabold text-2xl tracking-tight text-white mb-2 shadow-sm drop-shadow-sm text-center">PPDB
                    <span class="text-[#fdce06]">MAN 1 BOGOR</span></span>
            </a>
        </div>

        <!-- Content Box -->
        <div
            class="w-full sm:max-w-md mt-6 px-8 py-10 bg-white shadow-xl overflow-hidden sm:rounded-3xl border border-gray-100 z-10">
            {{ $slot }}
        </div>

        <!-- Footer Info -->
        <div class="mt-12 text-center text-sm text-gray-500 z-10 font-medium">
            &copy; {{ date('Y') }} PPDB MAN 1 BOGOR System
        </div>
    </div>
</body>

</html>