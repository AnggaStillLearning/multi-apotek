<aside class="w-64 min-h-screen bg-blue-700 text-white p-4">

    <h1 class="text-2xl font-bold mb-8">
        Multi Apotek
    </h1>

    <nav class="space-y-2">

        {{-- ================= SUPER ADMIN ================= --}}

        @if(auth()->user()->role == 'super_admin')

            <a href="{{ route('dashboard') }}"
               class="flex items-center gap-3 p-3 rounded-lg hover:bg-blue-600">

                📊 Dashboard

            </a>

            <a href="{{ route('apoteks.index') }}"
               class="flex items-center gap-3 p-3 rounded-lg hover:bg-blue-600">

                🏥 Data Apotek

            </a>

            <a href="{{ route('users.index') }}"
               class="flex items-center gap-3 p-3 rounded-lg hover:bg-blue-600">

                👤 Data Akun

            </a>

        @endif


        {{-- ================= ADMIN APOTEK ================= --}}

        @if(auth()->user()->role == 'admin_apotek')

            <a href="{{ route('dashboard') }}"
               class="flex items-center gap-3 p-3 rounded-lg hover:bg-blue-600">

                📊 Dashboard

            </a>

            <a href="{{ route('obats.index') }}"
               class="flex items-center gap-3 p-3 rounded-lg hover:bg-blue-600">

                💊 Data Obat

            </a>

            <a href="{{ route('monitoring.stok-kritis') }}"
               class="flex items-center gap-3 p-3 rounded-lg hover:bg-blue-600">

                ⚠ Monitoring Stok

            </a>

            <a href="{{ route('monitoring.kadaluarsa') }}"
               class="flex items-center gap-3 p-3 rounded-lg hover:bg-blue-600">

                ⏳ Monitoring Kadaluarsa

            </a>

            <a href="{{ route('penjualans.index') }}"
               class="flex items-center gap-3 p-3 rounded-lg hover:bg-blue-600">

                🛒 Transaksi

            </a>

        @endif


        {{-- ================= KASIR ================= --}}

        @if(auth()->user()->role == 'kasir')

            <a href="{{ route('dashboard') }}"
               class="flex items-center gap-3 p-3 rounded-lg hover:bg-blue-600">

                📊 Dashboard

            </a>

            <a href="{{ route('penjualans.index') }}"
               class="flex items-center gap-3 p-3 rounded-lg hover:bg-blue-600">

                🛒 Transaksi

            </a>

        @endif

    </nav>

</aside>
