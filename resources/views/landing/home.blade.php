@extends('layouts.landing')

@section('content')

<!-- HERO -->
<section class="relative overflow-hidden bg-gradient-to-br from-blue-50 via-white to-green-50">

    <div class="absolute -top-24 -left-24 w-96 h-96 bg-green-200 rounded-full blur-3xl opacity-40"></div>

    <div class="absolute bottom-0 right-0 w-96 h-96 bg-blue-200 rounded-full blur-3xl opacity-40"></div>

    <div class="relative max-w-7xl mx-auto px-6 py-24">

        <div class="grid lg:grid-cols-2 gap-16 items-center">

            <div>

                <span class="inline-flex items-center gap-2 bg-green-100 text-green-700 px-5 py-2 rounded-full font-semibold">

                    💊 SIMPATI

                </span>

                <h1 class="mt-8 text-6xl font-extrabold leading-tight text-gray-800">

                    Temukan Obat

                    <span class="text-green-600">

                        Dengan Cepat

                    </span>

                    di Berbagai Apotek

                </h1>

                <p class="mt-8 text-xl text-gray-600 leading-9">

                    SIMPATI membantu masyarakat mencari obat yang tersedia
                    pada berbagai apotek secara cepat, mudah,
                    dan akurat.

                </p>

                <form class="mt-10">

                    <div class="bg-white rounded-2xl shadow-2xl p-2 flex">

                        <input
                            type="text"
                            placeholder="Cari nama obat..."
                            class="flex-1 px-6 outline-none">

                        <button
                            class="bg-green-600 hover:bg-green-700 transition text-white rounded-xl px-8 py-4">

                            Cari

                        </button>

                    </div>

                </form>

                <div class="flex gap-8 mt-10">

                    <div>

                        ✅ Multi Apotek

                    </div>

                    <div>

                        ⚡ Real Time

                    </div>

                    <div>

                        🔍 Pencarian Cepat

                    </div>

                </div>

            </div>


        </div>

    </div>

</section>
<!-- ================= STATISTIK ================= -->

<section class="bg-gray-50 py-24">

<div class="max-w-7xl mx-auto px-6">

<div class="text-center mb-16">

<h2 class="text-4xl font-bold">

Mengapa Menggunakan SIMPATI?

</h2>

<p class="mt-4 text-gray-500">

Platform pencarian obat berbasis multi apotek.

</p>

</div>

<div class="grid md:grid-cols-2 lg:grid-cols-4 gap-8">

<div class="bg-white rounded-3xl p-8 shadow hover:-translate-y-2 hover:shadow-2xl transition">

<div class="w-16 h-16 rounded-2xl bg-green-100 flex items-center justify-center text-3xl">

🏥

</div>

<h3 class="mt-6 text-5xl font-bold text-green-600">

15

</h3>

<p class="mt-2 text-gray-600">

Apotek Terdaftar

</p>

</div>

<div class="bg-white rounded-3xl p-8 shadow hover:-translate-y-2 hover:shadow-2xl transition">

<div class="w-16 h-16 rounded-2xl bg-blue-100 flex items-center justify-center text-3xl">

💊

</div>

<h3 class="mt-6 text-5xl font-bold text-blue-600">

2.560

</h3>

<p class="mt-2 text-gray-600">

Jenis Obat

</p>

</div>

<div class="bg-white rounded-3xl p-8 shadow hover:-translate-y-2 hover:shadow-2xl transition">

<div class="w-16 h-16 rounded-2xl bg-yellow-100 flex items-center justify-center text-3xl">

📦

</div>

<h3 class="mt-6 text-5xl font-bold text-yellow-500">

18K

</h3>

<p class="mt-2 text-gray-600">

Total Stok

</p>

</div>

<div class="bg-white rounded-3xl p-8 shadow hover:-translate-y-2 hover:shadow-2xl transition">

<div class="w-16 h-16 rounded-2xl bg-purple-100 flex items-center justify-center text-3xl">

🛒

</div>

<h3 class="mt-6 text-5xl font-bold text-purple-600">

12K

</h3>

<p class="mt-2 text-gray-600">

Transaksi

</p>

</div>

</div>

</div>

</section>

@endsection
