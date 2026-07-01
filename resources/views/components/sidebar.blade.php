<aside class="w-72 min-h-screen bg-gradient-to-b from-blue-800 via-blue-700 to-blue-900 text-white flex flex-col shadow-2xl">

    <!-- Logo -->
    <div class="px-6 py-8 border-b border-blue-600">

        <h1 class="text-3xl font-extrabold tracking-wide">

            SIMPATI

        </h1>

        <p class="text-sm text-blue-200 mt-1">

            Sistem Manajemen Multi Apotek Terintegrasi

        </p>

    </div>

    <!-- Menu -->
    <nav class="flex-1 px-4 py-6 space-y-2">

        {{-- ================= SUPER ADMIN ================= --}}

        @if(auth()->user()->role == 'super_admin')

            <p class="text-xs uppercase text-blue-300 font-semibold px-3 mb-2">
                Super Admin
            </p>

            <a href="{{ route('dashboard') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-blue-600 transition">

                📊 <span>Dashboard</span>

            </a>

            <a href="{{ route('apoteks.index') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-blue-600 transition">

                🏥 <span>Data Apotek</span>

            </a>

            <a href="{{ route('users.index') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-blue-600 transition">

                👤 <span>Data Akun</span>

            </a>

        @endif


        {{-- ================= ADMIN APOTEK ================= --}}

        @if(auth()->user()->role == 'admin_apotek')

            <p class="text-xs uppercase text-blue-300 font-semibold px-3 mt-4 mb-2">
                Admin Apotek
            </p>

            <a href="{{ route('dashboard') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-blue-600 transition">

                📊 <span>Dashboard</span>

            </a>

            <a href="{{ route('obats.index') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-blue-600 transition">

                💊 <span>Data Obat</span>

            </a>

            <a href="{{ route('monitoring.stok-kritis') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-blue-600 transition">

                ⚠ <span>Monitoring Stok</span>

            </a>

            <a href="{{ route('monitoring.kadaluarsa') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-blue-600 transition">

                ⏳ <span>Monitoring Kadaluarsa</span>

            </a>

            <a href="{{ route('penjualans.index') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-blue-600 transition">

                🛒 <span>Transaksi</span>

            </a>

        @endif


        {{-- ================= KASIR ================= --}}

        @if(auth()->user()->role == 'kasir')

            <p class="text-xs uppercase text-blue-300 font-semibold px-3 mt-4 mb-2">
                Kasir
            </p>

            <a href="{{ route('dashboard') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-blue-600 transition">

                📊 <span>Dashboard</span>

            </a>

            <a href="{{ route('penjualans.index') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-blue-600 transition">

                🛒 <span>Transaksi</span>

            </a>

        @endif

    </nav>

</aside>
