@extends('layouts.app')

@section('content')

<h1 class="text-3xl font-bold mb-6">

Dashboard Super Admin

</h1>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">

<div class="bg-white shadow rounded-xl p-5">

<p class="text-gray-500">

Total Apotek

</p>

<h2 class="text-3xl font-bold text-blue-600">

{{ $totalApotek }}

</h2>

</div>

<div class="bg-white shadow rounded-xl p-5">

<p class="text-gray-500">

Admin Apotek

</p>

<h2 class="text-3xl font-bold text-green-600">

{{ $totalAdmin }}

</h2>

</div>

<div class="bg-white shadow rounded-xl p-5">

<p class="text-gray-500">

Kasir

</p>

<h2 class="text-3xl font-bold text-yellow-500">

{{ $totalKasir }}

</h2>

</div>

<div class="bg-white shadow rounded-xl p-5">

<p class="text-gray-500">

Total Obat

</p>

<h2 class="text-3xl font-bold text-red-500">

{{ $totalObat }}

</h2>

</div>

</div>

<div class="bg-white shadow rounded-xl mt-8">

<div class="p-5 border-b">

<h2 class="text-xl font-bold">

Data Apotek

</h2>

</div>

<table class="w-full">

<thead class="bg-gray-100">

<tr>

<th class="p-4">

Nama Apotek

</th>

<th class="p-4">

Jumlah Obat

</th>

</tr>

</thead>

<tbody>

@foreach($apoteks as $apotek)

<tr class="border-t">

<td class="p-4">

{{ $apotek->nama_apotek }}

</td>

<td class="p-4">

{{ $apotek->obats_count }}

</td>

</tr>

@endforeach

</tbody>

</table>

</div>

@endsection
