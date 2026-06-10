@extends('layouts.app')

@section('content')

<h1 class="text-3xl font-bold mb-6">
    Tambah Transaksi
</h1>

<div class="bg-white rounded-xl shadow p-6">

@if(session('error'))

<div
    class="bg-red-100 border border-red-400
           text-red-700 px-4 py-3 rounded mb-4">

    {{ session('error') }}

</div>

@endif

<form action="{{ route('penjualans.store') }}"
      method="POST">

    @csrf

    <div class="mb-4">

        <label class="block mb-2">
            Pilih Obat
        </label>

        <select
            name="obat_id"
            id="obat_id"
            class="w-full border rounded p-2">

            <option value="">
                Pilih Obat
            </option>

            @foreach($obats as $obat)

            <option
                value="{{ $obat->id }}"
                data-stok="{{ $obat->stok }}">

                {{ $obat->nama_obat }}
                (Stok: {{ $obat->stok }})

            </option>

            @endforeach

        </select>

    </div>

    <div class="mb-4">

        <label class="block mb-2">
            Jumlah
        </label>

        <input
            type="number"
            name="qty"
            id="qty"
            min="1"
            class="w-full border rounded p-2">

        <small
            id="infoStok"
            class="text-gray-500">
        </small>

    </div>

    <button
        type="submit"
        class="bg-blue-600 text-white px-4 py-2 rounded">

        Simpan

    </button>

</form>

</div>

<script>

const obatSelect =
document.getElementById('obat_id');

const qtyInput =
document.getElementById('qty');

const infoStok =
document.getElementById('infoStok');

obatSelect.addEventListener('change', function () {

    const stok =
    this.options[this.selectedIndex]
        .dataset.stok;

    qtyInput.max = stok;

    infoStok.innerText =
        'Stok tersedia : ' + stok;

});

qtyInput.addEventListener('input', function () {

    const max =
    parseInt(this.max);

    if(this.value > max)
    {
        this.value = max;
    }

});

</script>

@endsection
