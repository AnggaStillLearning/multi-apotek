@extends('layouts.app')

@section('content')

<div class="mb-8">


<h1 class="text-3xl font-bold text-gray-800">
    Dashboard
</h1>

<p class="text-gray-500 mt-2">
    Selamat datang di Sistem Manajemen Multi-Apotek
</p>


</div>

<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">

<div class="bg-white rounded-xl shadow p-6 border-l-4 border-blue-500">

    <div class="text-gray-500 text-sm">
        Total Obat
    </div>

    <div class="text-4xl font-bold text-gray-800 mt-2">
        {{ $totalObat }}
    </div>

</div>

<div class="bg-white rounded-xl shadow p-6 border-l-4 border-red-500">

    <div class="text-gray-500 text-sm">
        Stok Kritis
    </div>

    <div class="text-4xl font-bold text-red-600 mt-2">
        {{ $totalStokKritis }}
    </div>

</div>

<div class="bg-white rounded-xl shadow p-6 border-l-4 border-yellow-500">

    <div class="text-gray-500 text-sm">
        Mendekati Kadaluarsa
    </div>

    <div class="text-4xl font-bold text-yellow-600 mt-2">
        {{ $totalKadaluarsa }}
    </div>

</div>

</div>

<div class="grid grid-cols-1 md:grid-cols-2 gap-6">

<div class="bg-white rounded-xl shadow">

    <div class="p-4 border-b">

        <h2 class="font-semibold text-red-600">
            ⚠ Monitoring Stok Kritis
        </h2>

    </div>

    <div class="p-4">

        <p class="text-gray-600">
            Saat ini terdapat
            <strong>{{ $totalStokKritis }}</strong>
            obat dengan stok kritis yang perlu segera dilakukan restock.
        </p>

    </div>

</div>

<div class="bg-white rounded-xl shadow">

    <div class="p-4 border-b">

        <h2 class="font-semibold text-yellow-600">
            ⏳ Monitoring Kadaluarsa
        </h2>

    </div>

    <div class="p-4">

        <p class="text-gray-600">
            Saat ini terdapat
            <strong>{{ $totalKadaluarsa }}</strong>
            obat yang mendekati tanggal kadaluarsa dan memerlukan perhatian.
        </p>

    </div>

</div>

</div>

@endsection
