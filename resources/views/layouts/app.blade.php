<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIMA - Sistem Informasi Manajemen Apotek</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-slate-100 text-gray-800">

    <div class="min-h-screen flex">
        {{-- Sidebar --}}
        <aside class="w-72 bg-white border-r border-gray-200 shadow-sm">
            @include('components.sidebar')
        </aside>

        {{-- Content --}}
        <div class="flex-1 flex flex-col overflow-hidden">
            {{-- Navbar --}}
            <header class="bg-white border-b border-gray-200 shadow-sm sticky top-0 z-30">
                @include('components.navbar')
            </header>

            {{-- Main --}}
            <main class="flex-1 overflow-y-auto">
                <div class="p-8">
                    @yield('content')
                </div>
            </main>
        </div>
    </div>

    {{-- Script dari setiap halaman --}}
    @stack('scripts')

</body>

</html>
