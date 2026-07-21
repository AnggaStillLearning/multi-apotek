@extends('layouts.shop')

@section('content')

<!-- ================= HERO ================= -->
<section class="relative overflow-hidden bg-gradient-to-br from-slate-50 via-white to-blue-50">

    <!-- Background Blur -->
    <div class="absolute -top-40 -left-32 w-[450px] h-[450px] bg-blue-200 rounded-full blur-3xl opacity-30"></div>
    <div class="absolute -bottom-40 right-0 w-[500px] h-[500px] bg-cyan-200 rounded-full blur-3xl opacity-30"></div>

    <div class="relative max-w-7xl mx-auto px-6 lg:px-8 py-24">

        <div class="grid lg:grid-cols-2 gap-16 items-center">

            <!-- LEFT -->
            <div>

                <span class="inline-flex items-center gap-2 rounded-full bg-blue-100 text-blue-700 px-5 py-2 text-sm font-semibold">

                    <span class="w-2 h-2 rounded-full bg-green-500 animate-pulse"></span>

                    SIMA • Multi Pharmacy Platform

                </span>

                <h1 class="mt-8 text-5xl lg:text-6xl font-extrabold leading-tight text-slate-900">

                    Modern Pharmacy

                    <span class="text-blue-600">

                        Management

                    </span>

                    Made Simple.

                </h1>

                <p class="mt-8 text-lg leading-8 text-slate-600 max-w-xl">

                    Kelola banyak apotek dalam satu sistem.
                    Pantau stok kritis, obat kadaluarsa,
                    transaksi penjualan, dan laporan secara
                    real-time melalui SIMA.

                </p>

                <!-- Search -->

                <div class="mt-10">

                    <form>

                        <div class="bg-white rounded-2xl border border-slate-200 shadow-xl flex overflow-hidden">

                            <div class="flex items-center px-5 text-slate-400">

                                <svg xmlns="http://www.w3.org/2000/svg"
                                     class="w-5 h-5"
                                     fill="none"
                                     viewBox="0 0 24 24"
                                     stroke="currentColor">

                                    <path stroke-linecap="round"
                                          stroke-linejoin="round"
                                          stroke-width="2"
                                          d="M21 21l-4.35-4.35M11 18a7 7 0 100-14 7 7 0 000 14z"/>

                                </svg>

                            </div>

                            <input
                                type="text"
                                placeholder="Cari nama obat..."
                                class="flex-1 py-4 outline-none">

                            <button
                                class="bg-blue-600 hover:bg-blue-700 transition text-white px-8">

                                Cari

                            </button>

                        </div>

                    </form>

                </div>

                <!-- Feature Badge -->

                <div class="mt-10 flex flex-wrap gap-3">

                    <span class="px-4 py-2 rounded-full bg-white border shadow-sm text-sm">

                        ✅ Multi Apotek

                    </span>

                    <span class="px-4 py-2 rounded-full bg-white border shadow-sm text-sm">

                        📦 Monitoring Stok

                    </span>

                    <span class="px-4 py-2 rounded-full bg-white border shadow-sm text-sm">

                        ⏰ Kadaluarsa

                    </span>

                    <span class="px-4 py-2 rounded-full bg-white border shadow-sm text-sm">

                        ⚡ Real Time

                    </span>

                </div>

            </div>

            <!-- RIGHT -->

            <div class="relative">

                <!-- Main Image -->

                <div class="rounded-3xl overflow-hidden shadow-2xl border-8 border-white">

                    <img
                        src="https://images.unsplash.com/photo-1587854692152-cbe660dbde88?w=900"
                        class="w-full h-[520px] object-cover">

                </div>

                <!-- Floating Card -->

                <div
                    class="absolute -left-8 top-10 bg-white rounded-2xl shadow-xl p-5 w-60">

                    <div class="flex items-center gap-3">

                        <div class="w-12 h-12 rounded-xl bg-green-100 flex items-center justify-center">

                            💊

                        </div>

                        <div>

                            <div class="text-sm text-slate-500">

                                Total Obat

                            </div>

                            <div class="text-2xl font-bold">

                                2.560

                            </div>

                        </div>

                    </div>

                </div>

                <!-- Floating Card -->

                <div
                    class="absolute -right-8 bottom-8 bg-white rounded-2xl shadow-xl p-5 w-64">

                    <div class="text-sm text-slate-500">

                        Status Sistem

                    </div>

                    <div class="mt-3 flex items-center justify-between">

                        <span class="text-green-600 font-semibold">

                            Semua Apotek Online

                        </span>

                        <span class="w-3 h-3 rounded-full bg-green-500 animate-pulse"></span>

                    </div>

                    <div class="mt-5 h-2 rounded-full bg-slate-200 overflow-hidden">

                        <div class="w-full h-full bg-blue-600"></div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</section>
<!-- =================== STATISTIC =================== -->

<section class="py-24 bg-white">

    <div class="max-w-7xl mx-auto px-6">

        <div class="text-center">

            <span class="text-blue-600 font-semibold uppercase tracking-widest">

                SIMA Statistics

            </span>

            <h2 class="mt-4 text-5xl font-bold text-slate-900">

                Trusted by Modern Pharmacies

            </h2>

            <p class="mt-5 text-slate-500 text-lg">

                Semua data ditampilkan secara real-time dari sistem SIMA.

            </p>

        </div>

        <div class="grid lg:grid-cols-4 md:grid-cols-2 gap-8 mt-16">

            <!-- CARD -->

            <div
                class="group bg-white border rounded-3xl p-8 shadow-sm hover:shadow-2xl transition duration-300 hover:-translate-y-2">

                <div
                    class="w-16 h-16 rounded-2xl bg-blue-100 flex items-center justify-center">

                    <svg xmlns="http://www.w3.org/2000/svg"
                        class="w-8 h-8 text-blue-600"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor">

                        <path stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M3 21h18M5 21V7l7-4 7 4v14"/>

                    </svg>

                </div>

                <h3 class="mt-8 text-5xl font-bold text-slate-900">

                    15

                </h3>

                <p class="mt-3 text-slate-500">

                    Apotek Terdaftar

                </p>

                <div class="mt-6">

                    <div class="h-2 bg-slate-100 rounded-full overflow-hidden">

                        <div class="w-full h-full bg-blue-600 rounded-full"></div>

                    </div>

                </div>

            </div>

            <!-- CARD -->

            <div
                class="group bg-white border rounded-3xl p-8 shadow-sm hover:shadow-2xl transition duration-300 hover:-translate-y-2">

                <div
                    class="w-16 h-16 rounded-2xl bg-green-100 flex items-center justify-center">

                    <svg xmlns="http://www.w3.org/2000/svg"
                        class="w-8 h-8 text-green-600"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor">

                        <path stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M4.5 12.75l6.75-6.75a3 3 0 014.243 0l4.5 4.5a3 3 0 010 4.243l-6.75 6.75a3 3 0 01-4.243 0"/>

                    </svg>

                </div>

                <h3 class="mt-8 text-5xl font-bold text-slate-900">

                    2.560

                </h3>

                <p class="mt-3 text-slate-500">

                    Jenis Obat

                </p>

                <div class="mt-6">

                    <div class="h-2 bg-slate-100 rounded-full overflow-hidden">

                        <div class="w-4/5 h-full bg-green-500 rounded-full"></div>

                    </div>

                </div>

            </div>

            <!-- CARD -->

            <div
                class="group bg-white border rounded-3xl p-8 shadow-sm hover:shadow-2xl transition duration-300 hover:-translate-y-2">

                <div
                    class="w-16 h-16 rounded-2xl bg-yellow-100 flex items-center justify-center">

                    <svg xmlns="http://www.w3.org/2000/svg"
                        class="w-8 h-8 text-yellow-600"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor">

                        <path stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M20 13V7a2 2 0 00-2-2H6a2 2 0 00-2 2v6"/>

                    </svg>

                </div>

                <h3 class="mt-8 text-5xl font-bold text-slate-900">

                    18K

                </h3>

                <p class="mt-3 text-slate-500">

                    Total Stok

                </p>

                <div class="mt-6">

                    <div class="h-2 bg-slate-100 rounded-full overflow-hidden">

                        <div class="w-5/6 h-full bg-yellow-500 rounded-full"></div>

                    </div>

                </div>

            </div>

            <!-- CARD -->

            <div
                class="group bg-gradient-to-br from-blue-600 to-blue-700 text-white rounded-3xl p-8 shadow-xl hover:scale-105 transition">

                <div
                    class="w-16 h-16 rounded-2xl bg-white/20 flex items-center justify-center">

                    <svg xmlns="http://www.w3.org/2000/svg"
                        class="w-8 h-8"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor">

                        <path stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M3 3h2l.4 2M7 13h10l4-8"/>

                    </svg>

                </div>

                <h3 class="mt-8 text-5xl font-bold">

                    12K

                </h3>

                <p class="mt-3 text-blue-100">

                    Total Transaksi

                </p>

                <button
                    class="mt-8 w-full rounded-xl bg-white text-blue-600 py-3 font-semibold hover:bg-slate-100 transition">

                    Lihat Statistik

                </button>

            </div>

        </div>

    </div>

</section>

<!-- ================= FEATURES ================= -->

<section class="py-24 bg-slate-50">

    <div class="max-w-7xl mx-auto px-6">

        <div class="text-center">

            <span class="text-blue-600 uppercase tracking-widest font-semibold">

                Features

            </span>

            <h2 class="mt-4 text-5xl font-bold">

                Engineered for Modern Pharmacy

            </h2>

            <p class="mt-5 text-slate-500 text-lg">

                Semua kebutuhan operasional apotek dalam satu platform.

            </p>

        </div>

        <div class="grid lg:grid-cols-2 gap-8 mt-20">

            <div class="bg-white rounded-3xl p-10 border shadow-sm hover:shadow-xl transition">

                <div class="text-red-500 text-4xl">

                    🚨

                </div>

                <h3 class="mt-8 text-3xl font-bold">

                    Monitoring Stok Kritis

                </h3>

                <p class="mt-5 text-slate-500 leading-8">

                    Sistem otomatis mendeteksi stok obat yang berada di bawah batas minimum sehingga tidak terjadi kekosongan stok.

                </p>

            </div>

            <div class="bg-white rounded-3xl p-10 border shadow-sm hover:shadow-xl transition">

                <div class="text-yellow-500 text-4xl">

                    ⏰

                </div>

                <h3 class="mt-8 text-3xl font-bold">

                    Monitoring Kadaluarsa

                </h3>

                <p class="mt-5 text-slate-500 leading-8">

                    Pantau obat yang mendekati tanggal kadaluarsa secara real-time agar pengelolaan stok lebih aman.

                </p>

            </div>

            <div class="bg-gradient-to-br from-blue-600 to-blue-700 rounded-3xl p-10 text-white">

                <h3 class="text-3xl font-bold">

                    Multi Pharmacy Support

                </h3>

                <p class="mt-6 text-blue-100 leading-8">

                    Kelola banyak cabang apotek hanya dalam satu dashboard dengan data yang selalu sinkron.

                </p>

                <button
                    class="mt-8 bg-white text-blue-600 px-6 py-3 rounded-xl font-semibold">

                    Pelajari Selengkapnya

                </button>

            </div>

            <div class="bg-white rounded-3xl p-10 border shadow-sm hover:shadow-xl transition">

                <div class="text-green-500 text-4xl">

                    📈

                </div>

                <h3 class="mt-8 text-3xl font-bold">

                    Dashboard Analytics

                </h3>

                <p class="mt-5 text-slate-500 leading-8">

                    Laporan penjualan, stok, transaksi, dan performa apotek ditampilkan dalam dashboard yang modern.

                </p>

            </div>

        </div>

    </div>

</section>
<!-- ================= PARTNER APOTEK ================= -->

<section class="py-24 bg-white">

    <div class="max-w-7xl mx-auto px-6">

        <div class="flex flex-col lg:flex-row justify-between items-end gap-8">

            <div>

                <span class="text-blue-600 uppercase tracking-widest font-semibold">

                    Partner Pharmacy

                </span>

                <h2 class="mt-4 text-5xl font-bold text-slate-900">

                    Temukan Apotek Terdekat

                </h2>

                <p class="mt-5 text-slate-500 text-lg max-w-2xl">

                    Semua apotek partner SIMA dapat dicari berdasarkan lokasi
                    dan ketersediaan obat secara real-time.

                </p>

            </div>

            <button
                class="px-8 py-4 rounded-2xl bg-blue-600 hover:bg-blue-700 text-white font-semibold transition">

                Lihat Semua

            </button>

        </div>

        <div class="grid lg:grid-cols-3 gap-8 mt-16">

            <!-- CARD -->

            <div
                class="bg-white rounded-3xl border shadow-sm hover:shadow-xl hover:-translate-y-2 transition overflow-hidden">

                <div class="h-52 bg-gradient-to-r from-blue-500 to-cyan-500"></div>

                <div class="p-8">

                    <div
                        class="inline-flex px-4 py-2 rounded-full bg-green-100 text-green-600 text-sm font-semibold">

                        Buka

                    </div>

                    <h3 class="mt-6 text-2xl font-bold">

                        Apotek Sehat Sentosa

                    </h3>

                    <p class="mt-4 text-slate-500">

                        Jl. Ahmad Yani No. 25

                    </p>

                    <div class="flex justify-between mt-8">

                        <span class="text-blue-600 font-semibold">

                            560 Obat

                        </span>

                        <a href="#"
                            class="font-semibold text-slate-700">

                            Detail →

                        </a>

                    </div>

                </div>

            </div>

            <!-- CARD -->

            <div
                class="bg-white rounded-3xl border shadow-sm hover:shadow-xl hover:-translate-y-2 transition overflow-hidden">

                <div class="h-52 bg-gradient-to-r from-green-500 to-emerald-500"></div>

                <div class="p-8">

                    <div
                        class="inline-flex px-4 py-2 rounded-full bg-green-100 text-green-600 text-sm font-semibold">

                        Buka

                    </div>

                    <h3 class="mt-6 text-2xl font-bold">

                        Apotek Medika Farma

                    </h3>

                    <p class="mt-4 text-slate-500">

                        Jl. Veteran No. 12

                    </p>

                    <div class="flex justify-between mt-8">

                        <span class="text-blue-600 font-semibold">

                            735 Obat

                        </span>

                        <a href="#"
                            class="font-semibold text-slate-700">

                            Detail →

                        </a>

                    </div>

                </div>

            </div>

            <!-- CARD -->

            <div
                class="bg-white rounded-3xl border shadow-sm hover:shadow-xl hover:-translate-y-2 transition overflow-hidden">

                <div class="h-52 bg-gradient-to-r from-purple-500 to-blue-500"></div>

                <div class="p-8">

                    <div
                        class="inline-flex px-4 py-2 rounded-full bg-red-100 text-red-600 text-sm font-semibold">

                        Tutup

                    </div>

                    <h3 class="mt-6 text-2xl font-bold">

                        Apotek Keluarga

                    </h3>

                    <p class="mt-4 text-slate-500">

                        Jl. Gatot Subroto No. 89

                    </p>

                    <div class="flex justify-between mt-8">

                        <span class="text-blue-600 font-semibold">

                            490 Obat

                        </span>

                        <a href="#"
                            class="font-semibold text-slate-700">

                            Detail →

                        </a>

                    </div>

                </div>

            </div>

        </div>

    </div>

</section>

<!-- ================= CTA ================= -->

<section class="py-28 bg-gradient-to-r from-blue-700 via-blue-600 to-cyan-600">

    <div class="max-w-5xl mx-auto text-center px-6">

        <span
            class="inline-flex px-5 py-2 rounded-full bg-white/20 text-white font-semibold">

            SIMA Platform

        </span>

        <h2 class="mt-8 text-5xl font-extrabold text-white leading-tight">

            Kelola Apotek Lebih Mudah,
            Cepat, dan Modern.

        </h2>

        <p class="mt-8 text-xl text-blue-100">

            Monitoring stok, kadaluarsa, transaksi,
            hingga laporan penjualan dalam satu sistem.

        </p>

        <div class="flex justify-center gap-5 mt-12">

            <a href="#"
                class="px-8 py-4 rounded-2xl bg-white text-blue-600 font-semibold hover:scale-105 transition">

                Mulai Sekarang

            </a>

            <a href="#"
                class="px-8 py-4 rounded-2xl border border-white text-white hover:bg-white hover:text-blue-600 transition">

                Pelajari SIMA

            </a>

        </div>

    </div>

</section>

<!-- ================= FOOTER ================= -->

<footer class="bg-slate-900 text-white">

    <div class="max-w-7xl mx-auto px-6 py-20">

        <div class="grid lg:grid-cols-4 gap-12">

            <div>

                <h2 class="text-3xl font-bold">

                    SIMA

                </h2>

                <p class="mt-5 text-slate-400 leading-8">

                    Sistem Informasi Multi Apotek
                    untuk monitoring stok,
                    obat kadaluarsa,
                    dan transaksi secara real-time.

                </p>

            </div>

            <div>

                <h4 class="font-bold text-lg">

                    Menu

                </h4>

                <div class="mt-6 space-y-3 text-slate-400">

                    <a href="#" class="block hover:text-white">

                        Beranda

                    </a>

                    <a href="#" class="block hover:text-white">

                        Cari Obat

                    </a>

                    <a href="#" class="block hover:text-white">

                        Apotek

                    </a>

                </div>

            </div>

            <div>

                <h4 class="font-bold text-lg">

                    Layanan

                </h4>

                <div class="mt-6 space-y-3 text-slate-400">

                    <div>Monitoring Stok</div>

                    <div>Monitoring Kadaluarsa</div>

                    <div>Dashboard</div>

                </div>

            </div>

            <div>

                <h4 class="font-bold text-lg">

                    Kontak

                </h4>

                <div class="mt-6 space-y-3 text-slate-400">

                    <div>Banjarmasin</div>

                    <div>info@sima.id</div>

                    <div>+62 812 xxxx xxxx</div>

                </div>

            </div>

        </div>

        <div class="border-t border-slate-700 mt-16 pt-8 flex flex-col lg:flex-row justify-between items-center">

            <p class="text-slate-500">

                © {{ date('Y') }} SIMA - Sistem Informasi Multi Apotek.

            </p>

            <div class="flex gap-6 mt-5 lg:mt-0 text-slate-400">

                <a href="#" class="hover:text-white">

                    Facebook

                </a>

                <a href="#" class="hover:text-white">

                    Instagram

                </a>

                <a href="#" class="hover:text-white">

                    LinkedIn

                </a>

            </div>

        </div>

    </div>

</footer>

@endsection
