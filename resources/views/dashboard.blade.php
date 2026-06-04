@extends('layouts.app')

@section('content')

<h1 class="text-3xl font-bold mb-6">
    Dashboard
</h1>

<div class="grid grid-cols-1 md:grid-cols-3 gap-6">

<div class="bg-white p-6 rounded-lg shadow">

    <h2 class="text-gray-500">
        Total Obat
    </h2>

    <p class="text-4xl font-bold mt-3">
        {{ $totalObat }}
    </p>

</div>

<div class="bg-red-500 text-white p-6 rounded-lg shadow">
    <h2>Stok Kritis</h2>

    <p class="text-4xl font-bold mt-2">
        {{ $totalStokKritis }}
    </p>
</div>

<div class="bg-yellow-500 text-white p-6 rounded-lg shadow">
    <h2>Mendekati Kadaluarsa</h2>

    <p class="text-4xl font-bold mt-2">
        {{ $totalKadaluarsa }}
    </p>
</div>


</div>

@endsection
