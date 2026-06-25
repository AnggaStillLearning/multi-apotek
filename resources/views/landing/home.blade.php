@extends('layouts.landing')

@section('content')

<!-- HERO -->
<section class="bg-gradient-to-br from-green-50 to-white">

    <div class="max-w-7xl mx-auto px-6 py-20">

        <div class="grid lg:grid-cols-2 gap-12 items-center">

            <!-- Kiri -->
            <div>

                <span class="inline-block bg-green-100 text-green-700 px-4 py-2 rounded-full text-sm font-semibold mb-6">

                    💊 Sistem Monitoring Multi Apotek

                </span>

                <h1 class="text-5xl font-extrabold text-gray-800 leading-tight">

                    Temukan Obat

                    <span class="text-green-600">

                        Lebih Cepat

                    </span>

                    di Berbagai Apotek

                </h1>

                <p class="mt-6 text-lg text-gray-600 leading-relaxed">

                    Cari obat yang Anda butuhkan dan lihat apotek mana yang
                    memiliki stok tersedia secara cepat dan akurat.

                </p>

                <!-- Search -->
                <div class="mt-10">

                    <form>

                        <div class="flex bg-white rounded-2xl shadow-lg overflow-hidden">

                            <input
                                type="text"
                                placeholder="Cari Paracetamol, Amoxicillin, Vitamin..."
                                class="w-full px-6 py-4 outline-none">

                            <button
                                class="bg-green-600 hover:bg-green-700 transition text-white px-8">

                                Cari

                            </button>

                        </div>

                    </form>

                </div>

                <!-- Feature -->
                <div class="flex flex-wrap gap-6 mt-8 text-gray-600">

                    <div>

                        ✅ Update Stok

                    </div>

                    <div>

                        🏥 Multi Apotek

                    </div>

                    <div>

                        ⚡ Cepat & Akurat

                    </div>

                </div>

            </div>

            <!-- Kanan -->
            <div class="flex justify-center">

                <img
                    src="{{ asset('images/hero-pharmacy.png') }}"
                    class="max-w-lg w-full"
                    alt="Hero">

            </div>

        </div>

    </div>

</section>
<!-- ================= STATISTIK ================= -->

<section class="py-20 bg-white">

    <div class="max-w-7xl mx-auto px-6">

        <div class="text-center mb-14">

            <h2 class="text-4xl font-bold text-gray-800">

                Sistem Multi Apotek dalam Angka

            </h2>

            <p class="mt-4 text-gray-500">

                Informasi terbaru mengenai jaringan apotek yang tergabung.

            </p>

        </div>

        <div class="grid grid-cols-2 lg:grid-cols-4 gap-8">

            <!-- Apotek -->

            <div
                class="bg-white border rounded-3xl p-8 text-center
                       shadow-sm hover:shadow-xl transition duration-300">

                <div
                    class="w-20 h-20 mx-auto rounded-full
                           bg-green-100 flex items-center justify-center
                           text-4xl">

                    🏥

                </div>

                <h3 class="text-5xl font-bold mt-6 text-green-600">

                    15

                </h3>

                <p class="mt-3 text-gray-600">

                    Apotek

                </p>

            </div>

            <!-- Obat -->

            <div
                class="bg-white border rounded-3xl p-8 text-center
                       shadow-sm hover:shadow-xl transition duration-300">

                <div
                    class="w-20 h-20 mx-auto rounded-full
                           bg-blue-100 flex items-center justify-center
                           text-4xl">

                    💊

                </div>

                <h3 class="text-5xl font-bold mt-6 text-blue-600">

                    2.560

                </h3>

                <p class="mt-3 text-gray-600">

                    Jenis Obat

                </p>

            </div>

            <!-- Stok -->

            <div
                class="bg-white border rounded-3xl p-8 text-center
                       shadow-sm hover:shadow-xl transition duration-300">

                <div
                    class="w-20 h-20 mx-auto rounded-full
                           bg-yellow-100 flex items-center justify-center
                           text-4xl">

                    📦

                </div>

                <h3 class="text-5xl font-bold mt-6 text-yellow-600">

                    18K

                </h3>

                <p class="mt-3 text-gray-600">

                    Total Stok

                </p>

            </div>

            <!-- User -->

            <div
                class="bg-white border rounded-3xl p-8 text-center
                       shadow-sm hover:shadow-xl transition duration-300">

                <div
                    class="w-20 h-20 mx-auto rounded-full
                           bg-purple-100 flex items-center justify-center
                           text-4xl">

                    👥

                </div>

                <h3 class="text-5xl font-bold mt-6 text-purple-600">

                    500+

                </h3>

                <p class="mt-3 text-gray-600">

                    Pengguna

                </p>

            </div>

        </div>

    </div>

</section>

@endsection
