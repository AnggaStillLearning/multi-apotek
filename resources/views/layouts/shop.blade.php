<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>SIMA</title>

    @vite([
        'resources/css/app.css',
        'resources/js/app.js'
    ])
</head>

<body class="bg-gray-100">

    {{-- ================= NAVBAR ================= --}}

    <nav class="bg-white shadow">
        <div class="max-w-7xl mx-auto px-6">
            <div class="flex justify-between items-center h-16">

                {{-- Logo --}}
                <a href="{{ url('/') }}"
                    class="text-2xl font-bold text-blue-700">
                    SIMA
                </a>

                {{-- Menu --}}
                <div class="flex items-center gap-8">

                    <a href="{{ url('/') }}"
                        class="hover:text-blue-600 transition">
                        Home
                    </a>

                    <a href="{{ route('shop.apoteks') }}"
                        class="hover:text-blue-600 transition">
                        Apotek
                    </a>

                    @auth

                        @if(auth()->user()->role == 'pembeli')

                            <a href="{{ route('pemesanan.index') }}"
                                class="relative hover:text-blue-600 transition">

                                Keranjang

                                @php
                                    $jumlahItemKeranjang = \App\Models\PemesananDetail::whereHas(
                                        'pemesanan',
                                        fn($q) => $q->where('user_id', auth()->id())->where('status', 'draft')
                                    )->count();
                                @endphp

                                @if($jumlahItemKeranjang)
                                    <span
                                        class="absolute -top-2 -right-4 bg-red-500 text-white text-xs rounded-full px-2 py-0.5">
                                        {{ $jumlahItemKeranjang }}
                                    </span>
                                @endif

                            </a>

                            <a href="{{ route('pembelian.online.index') }}"
                                class="hover:text-blue-600 transition">
                                Pesanan Saya
                            </a>

                            <span class="text-gray-500">
                                {{ auth()->user()->name }}
                            </span>

                            <form method="POST"
                                action="{{ route('logout') }}">
                                @csrf

                                <button
                                    type="submit"
                                    class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg">
                                    Logout
                                </button>
                            </form>

                        @endif

                    @else

                        <a href="{{ route('login') }}"
                            class="hover:text-blue-600 transition">
                            Login
                        </a>

                        <a href="{{ route('register') }}"
                            class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-lg">
                            Register
                        </a>

                    @endauth

                </div>

            </div>
        </div>
    </nav>

    {{-- ================= ALERT ================= --}}

    <div class="max-w-7xl mx-auto mt-5">

        @if(session('success'))
            <div class="bg-green-100 border border-green-300 text-green-700 px-5 py-3 rounded-lg mb-4">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-100 border border-red-300 text-red-700 px-5 py-3 rounded-lg mb-4">
                {{ session('error') }}
            </div>
        @endif

    </div>

    {{-- ================= CONTENT ================= --}}

    <main class="max-w-7xl mx-auto py-8 px-6">
        @yield('content')
    </main>

    {{-- ================= FOOTER ================= --}}

    <footer class="bg-white border-t mt-16">
        <div class="max-w-7xl mx-auto py-6 text-center text-gray-500">
            © {{ date('Y') }} SIMA - Sistem Informasi Multi Apotek
        </div>
    </footer>

</body>

</html>
