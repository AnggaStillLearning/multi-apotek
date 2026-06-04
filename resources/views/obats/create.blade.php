@extends('layouts.app')

@section('content')

<div class="bg-white p-6 rounded-lg shadow">

    <h1 class="text-2xl font-bold mb-6">
        Tambah Obat
    </h1>

    <form action="{{ route('obats.store') }}" method="POST">

        @csrf

        <div class="mb-4">
            <label>Nama Obat</label>
            <input type="text"
                   name="nama_obat"
                   class="w-full border rounded p-2">
        </div>

        <div class="mb-4">
            <label>Harga Beli</label>
            <input type="number"
                   name="harga_beli"
                   class="w-full border rounded p-2">
        </div>

        <div class="mb-4">
            <label>Harga Jual</label>
            <input type="number"
                   name="harga_jual"
                   class="w-full border rounded p-2">
        </div>

        <div class="mb-4">
            <label>Stok</label>
            <input type="number"
                   name="stok"
                   class="w-full border rounded p-2">
        </div>

        <div class="mb-4">
            <label>Stok Minimum</label>
            <input type="number"
                   name="stok_minimum"
                   class="w-full border rounded p-2">
        </div>

        <div class="mb-4">
            <label>Tanggal Kadaluarsa</label>
            <input type="date"
                   name="tanggal_kadaluarsa"
                   class="w-full border rounded p-2">
        </div>

        <button
            class="bg-blue-600 text-white px-4 py-2 rounded">

            Simpan

        </button>

    </form>

</div>

@endsection
