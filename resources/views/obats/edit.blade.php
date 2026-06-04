@extends('layouts.app')

@section('content')

<div class="bg-white p-6 rounded-lg shadow">

    <h1 class="text-2xl font-bold mb-6">
        Edit Obat
    </h1>

    <form action="{{ route('obats.update',$obat->id) }}"
          method="POST">

        @csrf
        @method('PUT')

        <div class="mb-4">
            <label>Nama Obat</label>
            <input type="text"
                   name="nama_obat"
                   value="{{ $obat->nama_obat }}"
                   class="w-full border rounded p-2">
        </div>

        <div class="mb-4">
            <label>Harga Beli</label>
            <input type="number"
                   name="harga_beli"
                   value="{{ $obat->harga_beli }}"
                   class="w-full border rounded p-2">
        </div>

        <div class="mb-4">
            <label>Harga Jual</label>
            <input type="number"
                   name="harga_jual"
                   value="{{ $obat->harga_jual }}"
                   class="w-full border rounded p-2">
        </div>

        <div class="mb-4">
            <label>Stok</label>
            <input type="number"
                   name="stok"
                   value="{{ $obat->stok }}"
                   class="w-full border rounded p-2">
        </div>

        <div class="mb-4">
            <label>Stok Minimum</label>
            <input type="number"
                   name="stok_minimum"
                   value="{{ $obat->stok_minimum }}"
                   class="w-full border rounded p-2">
        </div>

        <div class="mb-4">
            <label>Tanggal Kadaluarsa</label>
            <input type="date"
                   name="tanggal_kadaluarsa"
                   value="{{ $obat->tanggal_kadaluarsa }}"
                   class="w-full border rounded p-2">
        </div>

        <button
            class="bg-yellow-500 text-white px-4 py-2 rounded">

            Update

        </button>

    </form>

</div>

@endsection
