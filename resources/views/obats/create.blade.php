@extends('layouts.app')

@section('content')

<div class="max-w-5xl mx-auto">

    <div class="mb-8">

        <h1 class="text-3xl font-bold text-gray-800">
            Tambah Obat
        </h1>

        <p class="text-gray-500 mt-1">
            Lengkapi informasi obat yang akan ditambahkan.
        </p>

    </div>

    @if ($errors->any())

    <div class="mb-6 rounded-lg bg-red-100 border border-red-300 p-4">

        <ul class="list-disc list-inside text-red-700">

            @foreach ($errors->all() as $error)

                <li>{{ $error }}</li>

            @endforeach

        </ul>

    </div>

    @endif

    <form
        action="{{ route('obats.store') }}"
        method="POST"
        class="bg-white shadow rounded-xl p-8">

        @csrf

        <div class="grid grid-cols-2 gap-6">

            {{-- Nama Obat --}}
            <div>

                <label class="block mb-2 font-medium">
                    Nama Obat
                </label>

                <input
                    type="text"
                    name="nama_obat"
                    value="{{ old('nama_obat') }}"
                    class="w-full border rounded-lg p-3 focus:ring focus:ring-blue-200">

            </div>

            {{-- Batch --}}
            <div>

                <label class="block mb-2 font-medium">
                    Batch
                </label>

                <input
                    type="text"
                    name="batch"
                    value="{{ old('batch') }}"
                    placeholder="Contoh : PAR001"
                    class="w-full border rounded-lg p-3 focus:ring focus:ring-blue-200">

            </div>

            {{-- Jenis --}}
            <div>

                <label class="block mb-2 font-medium">
                    Jenis Obat
                </label>

                <select
                    name="jenis_obat_id"
                    class="w-full border rounded-lg p-3">

                    <option value="">
                        Pilih Jenis
                    </option>

                    @foreach($jenisObats as $jenis)

                        <option
                            value="{{ $jenis->id }}"
                            {{ old('jenis_obat_id') == $jenis->id ? 'selected' : '' }}>

                            {{ $jenis->nama }}

                        </option>

                    @endforeach

                </select>

            </div>

            {{-- Kategori --}}
            <div>

                <label class="block mb-2 font-medium">
                    Kategori
                </label>

                <select
                    name="kategori_id"
                    class="w-full border rounded-lg p-3">

                    <option value="">
                        Pilih Kategori
                    </option>

                    @foreach($kategoris as $kategori)

                        <option
                            value="{{ $kategori->id }}"
                            {{ old('kategori_id') == $kategori->id ? 'selected' : '' }}>

                            {{ $kategori->nama }}

                        </option>

                    @endforeach

                </select>

            </div>

            {{-- Harga Beli --}}
            <div>

                <label class="block mb-2 font-medium">
                    Harga Beli
                </label>

                <input
                    type="number"
                    name="harga_beli"
                    id="harga_beli"
                    value="{{ old('harga_beli') }}"
                    class="w-full border rounded-lg p-3">

            </div>

            {{-- Harga Jual --}}
            <div>

                <label class="block mb-2 font-medium">
                    Harga Jual
                </label>

                <input
                    type="number"
                    name="harga_jual"
                    id="harga_jual"
                    value="{{ old('harga_jual') }}"
                    class="w-full border rounded-lg p-3">

            </div>

            {{-- Stok --}}
            <div>

                <label class="block mb-2 font-medium">
                    Stok
                </label>

                <input
                    type="number"
                    name="stok"
                    value="{{ old('stok') }}"
                    class="w-full border rounded-lg p-3">

            </div>

            {{-- Minimum --}}
            <div>

                <label class="block mb-2 font-medium">
                    Stok Minimum
                </label>

                <input
                    type="number"
                    name="stok_minimum"
                    value="{{ old('stok_minimum') }}"
                    class="w-full border rounded-lg p-3">

            </div>

            {{-- Kadaluarsa --}}
            <div>

                <label class="block mb-2 font-medium">
                    Tanggal Kadaluarsa
                </label>

                <input
                    type="date"
                    name="tanggal_kadaluarsa"
                    value="{{ old('tanggal_kadaluarsa') }}"
                    class="w-full border rounded-lg p-3">

            </div>

            {{-- Profit --}}
            <div>

                <label class="block mb-2 font-medium">
                    Estimasi Keuntungan / Item
                </label>

                <div
                    id="profit"
                    class="w-full border rounded-lg p-3 bg-gray-100 font-semibold text-green-600">

                    Rp 0

                </div>

            </div>

        </div>

        <div class="flex justify-end gap-3 mt-8">

            <a
                href="{{ route('obats.index') }}"
                class="px-5 py-3 rounded-lg border hover:bg-gray-100">

                Batal

            </a>

            <button
                class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-lg">

                Simpan Obat

            </button>

        </div>

    </form>

</div>

<script>

const beli = document.getElementById('harga_beli');

const jual = document.getElementById('harga_jual');

const profit = document.getElementById('profit');

function hitungProfit(){

    let hb = parseFloat(beli.value) || 0;

    let hj = parseFloat(jual.value) || 0;

    let hasil = hj - hb;

    if(hasil < 0){

        profit.innerHTML =
            "<span class='text-red-600'>Harga jual tidak boleh lebih kecil dari harga beli</span>";

        return;

    }

    profit.innerHTML =
        "Rp " + hasil.toLocaleString('id-ID');

}

beli.addEventListener('input', hitungProfit);

jual.addEventListener('input', hitungProfit);

</script>

@endsection
