@extends('layouts.app')

@section('content')

<div class="max-w-5xl mx-auto">

    <div class="mb-8">

        <h1 class="text-3xl font-bold text-gray-800">
            Edit Obat
        </h1>

        <p class="text-gray-500 mt-1">
            Perbarui informasi obat.
        </p>

    </div>

    @if ($errors->any())

    <div
        id="errorAlert"
        class="mb-6 rounded-xl border border-red-200 bg-red-50 shadow-sm overflow-hidden">

        <div class="flex items-center justify-between px-5 py-4 bg-red-100 border-b border-red-200">

            <div class="flex items-center gap-3">

                <div class="w-10 h-10 rounded-full bg-red-500 flex items-center justify-center text-white text-lg">
                    ⚠
                </div>

                <div>

                    <h3 class="font-semibold text-red-700">
                        Gagal Memperbarui Data
                    </h3>

                    <p class="text-sm text-red-600">
                        Periksa kembali data yang Anda masukkan.
                    </p>

                </div>

            </div>

            <button
                type="button"
                onclick="document.getElementById('errorAlert').remove()"
                class="text-red-600 hover:text-red-800 text-xl">

                ✕

            </button>

        </div>

        <div class="px-5 py-4">

            <ul class="space-y-2">

                @foreach ($errors->all() as $error)

                <li class="flex items-start gap-2 text-red-700">

                    <span class="mt-1">•</span>

                    <span>{{ $error }}</span>

                </li>

                @endforeach

            </ul>

        </div>

    </div>

    @endif

    <form
        action="{{ route('obats.update',$obat->id) }}"
        method="POST"
        class="bg-white rounded-xl shadow p-8">

        @csrf
        @method('PUT')

        <div class="grid grid-cols-2 gap-6">

            <div>

                <label class="block mb-2 font-medium">
                    Nama Obat
                </label>

                <input
                    type="text"
                    name="nama_obat"
                    value="{{ old('nama_obat',$obat->nama_obat) }}"
                    class="w-full border rounded-lg p-3">

            </div>

            <div>

                <label class="block mb-2 font-medium">
                    Batch
                </label>

                <input
                    type="text"
                    name="batch"
                    value="{{ old('batch',$obat->batch) }}"
                    class="w-full border rounded-lg p-3">

            </div>

            <div>

                <label class="block mb-2 font-medium">
                    Jenis Obat
                </label>

                <select
                    name="jenis_obat_id"
                    class="w-full border rounded-lg p-3">

                    @foreach($jenisObats as $jenis)

                    <option
                        value="{{ $jenis->id }}"
                        {{ old('jenis_obat_id',$obat->jenis_obat_id)==$jenis->id ? 'selected':'' }}>

                        {{ $jenis->nama }}

                    </option>

                    @endforeach

                </select>

            </div>

            <div>

                <label class="block mb-2 font-medium">
                    Kategori
                </label>

                <select
                    name="kategori_id"
                    class="w-full border rounded-lg p-3">

                    @foreach($kategoris as $kategori)

                    <option
                        value="{{ $kategori->id }}"
                        {{ old('kategori_id',$obat->kategori_id)==$kategori->id ? 'selected':'' }}>

                        {{ $kategori->nama }}

                    </option>

                    @endforeach

                </select>

            </div>

            <div>

                <label class="block mb-2 font-medium">
                    Harga Beli
                </label>

                <input
                    type="number"
                    id="harga_beli"
                    name="harga_beli"
                    value="{{ old('harga_beli',$obat->harga_beli) }}"
                    class="w-full border rounded-lg p-3">

            </div>

            <div>

                <label class="block mb-2 font-medium">
                    Harga Jual
                </label>

                <input
                    type="number"
                    id="harga_jual"
                    name="harga_jual"
                    value="{{ old('harga_jual',$obat->harga_jual) }}"
                    class="w-full border rounded-lg p-3">

            </div>

            <div>

                <label class="block mb-2 font-medium">
                    Stok
                </label>

                <input
                    type="number"
                    name="stok"
                    value="{{ old('stok',$obat->stok) }}"
                    class="w-full border rounded-lg p-3">

            </div>

            <div>

                <label class="block mb-2 font-medium">
                    Stok Minimum
                </label>

                <input
                    type="number"
                    name="stok_minimum"
                    value="{{ old('stok_minimum',$obat->stok_minimum) }}"
                    class="w-full border rounded-lg p-3">

            </div>

            <div>

                <label class="block mb-2 font-medium">
                    Tanggal Kadaluarsa
                </label>

                <input
                    type="date"
                    name="tanggal_kadaluarsa"
                    value="{{ old('tanggal_kadaluarsa',$obat->tanggal_kadaluarsa) }}"
                    class="w-full border rounded-lg p-3">

            </div>

            <div>

                <label class="block mb-2 font-medium">
                    Estimasi Keuntungan / Item
                </label>

                <div
                    id="profit"
                    class="bg-gray-100 rounded-lg p-3 font-semibold text-green-600">

                    Rp 0

                </div>

            </div>

        </div>

        <div class="flex justify-end gap-3 mt-8">

            <a
                href="{{ route('obats.index') }}"
                class="px-5 py-3 border rounded-lg hover:bg-gray-100">

                Batal

            </a>

            <button
                type="submit"
                class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-lg">

                Update Obat

            </button>

        </div>

    </form>

</div>

<script>

const beli = document.getElementById('harga_beli');
const jual = document.getElementById('harga_jual');
const profit = document.getElementById('profit');
const btn = document.querySelector("button[type='submit']");

function hitungProfit(){

    let hb = parseFloat(beli.value) || 0;
    let hj = parseFloat(jual.value) || 0;

    let hasil = hj - hb;

    if(hasil < 0){

        profit.innerHTML =
        "<span class='text-red-600'>Harga jual tidak boleh lebih kecil dari harga beli</span>";

        btn.disabled = true;
        btn.classList.add("opacity-50","cursor-not-allowed");

        return;
    }

    btn.disabled = false;
    btn.classList.remove("opacity-50","cursor-not-allowed");

    profit.innerHTML =
    "Rp " + hasil.toLocaleString('id-ID');

}

hitungProfit();

beli.addEventListener('input', hitungProfit);
jual.addEventListener('input', hitungProfit);

</script>

@endsection
