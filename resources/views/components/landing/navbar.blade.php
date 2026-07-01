<nav class="fixed top-0 left-0 w-full z-50 bg-white/90 backdrop-blur-lg shadow-sm border-b border-gray-100">

    <div class="max-w-7xl mx-auto px-6 py-4 flex items-center justify-between">

        <!-- Logo -->
        <a href="/" class="flex items-center gap-4">

            <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-green-500 to-blue-600 flex items-center justify-center shadow-lg">

                <span class="text-white text-2xl">💊</span>

            </div>

            <div>

                <h1 class="text-2xl font-extrabold text-gray-800 tracking-wide">

                    SIMPATI

                </h1>

                <p class="text-xs text-gray-500">

                    Sistem Manajemen Multi Apotek Terintegrasi

                </p>

            </div>

        </a>

        <!-- Menu -->
        <div class="hidden lg:flex items-center gap-10">

            <a href="#home"
               class="font-medium text-gray-600 hover:text-green-600 transition relative group">

                Beranda

                <span class="absolute left-0 -bottom-1 w-0 h-0.5 bg-green-600 transition-all duration-300 group-hover:w-full"></span>

            </a>

            <a href="#obat"
               class="font-medium text-gray-600 hover:text-green-600 transition relative group">

                Cari Obat

                <span class="absolute left-0 -bottom-1 w-0 h-0.5 bg-green-600 transition-all duration-300 group-hover:w-full"></span>

            </a>

            <a href="#apotek"
               class="font-medium text-gray-600 hover:text-green-600 transition relative group">

                Apotek

                <span class="absolute left-0 -bottom-1 w-0 h-0.5 bg-green-600 transition-all duration-300 group-hover:w-full"></span>

            </a>

            <a href="#fitur"
               class="font-medium text-gray-600 hover:text-green-600 transition relative group">

                Fitur

                <span class="absolute left-0 -bottom-1 w-0 h-0.5 bg-green-600 transition-all duration-300 group-hover:w-full"></span>

            </a>

            <a href="#tentang"
               class="font-medium text-gray-600 hover:text-green-600 transition relative group">

                Tentang

                <span class="absolute left-0 -bottom-1 w-0 h-0.5 bg-green-600 transition-all duration-300 group-hover:w-full"></span>

            </a>

        </div>

        <!-- Button -->
        <div class="flex items-center gap-3">

            <a href="{{ route('login') }}"
               class="px-6 py-2.5 rounded-xl border border-green-600 text-green-600 hover:bg-green-50 transition font-medium">

                Masuk

            </a>

            <a href="{{ route('register') }}"
               class="px-6 py-2.5 rounded-xl bg-gradient-to-r from-green-600 to-blue-600 text-white shadow-lg hover:shadow-xl hover:scale-105 transition">

                Daftar

            </a>

        </div>

    </div>

</nav>
