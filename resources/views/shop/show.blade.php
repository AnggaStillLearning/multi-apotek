@extends('layouts.shop')

@section('content')

<div class="container mx-auto py-8">

    <a href="{{ route('shop.katalog', $apotek) }}" class="text-blue-600 hover:underline text-sm">
        &larr; Kembali ke {{ $apotek->nama_apotek }}
    </a>

    <div class="bg-white rounded-xl shadow p-8 mt-4">

        <h1 class="text-3xl font-bold">

            {{ $obat->nama_obat }}

        </h1>

        <div class="mt-4 space-y-2">

            <p>

                <strong>Kategori :</strong>

                {{ $obat->kategori->nama ?? '-' }}

            </p>

            <p>

                <strong>Jenis :</strong>

                {{ $obat->jenis->nama ?? '-' }}

            </p>

            <p>

                <strong>Deskripsi :</strong>

                {{ $obat->deskripsi ?? '-' }}

            </p>

            <p>

                <strong>Stok tersedia :</strong>

                {{ $obat->breakdownStokText() }}

            </p>

        </div>

        <div class="mt-8">

            @auth

                @if(auth()->user()->role == 'pembeli')

                    @if($obat->konversis->isEmpty())

                        <p class="text-gray-500">Obat ini belum memiliki satuan yang bisa dijual.</p>

                    @else

                        <form
                            action="{{ route('pemesanan.items.store', [$apotek, $obat]) }}"
                            method="POST"
                            class="flex flex-wrap items-end gap-4">

                            @csrf

                            <div>
                                <label class="block text-sm font-semibold mb-1">Satuan</label>
                                <select name="konversi_obat_id" class="border rounded-lg p-2">
                                    @foreach($obat->konversis as $konversi)
                                        <option
                                            value="{{ $konversi->id }}"
                                            {{ $konversi->is_default ? 'selected' : '' }}>
                                            {{ $konversi->satuan->nama_satuan }}
                                            (Rp {{ number_format($konversi->harga_jual, 0, ',', '.') }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label class="block text-sm font-semibold mb-1">Jumlah</label>
                                <input
                                    type="number"
                                    name="qty"
                                    value="1"
                                    min="1"
                                    class="border rounded-lg p-2 w-24">
                            </div>

                            <button
                                class="bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-lg">

                                Tambah ke Keranjang

                            </button>

                        </form>

                    @endif

                @endif

            @else

                <a
                    href="{{ route('login') }}"
                    class="bg-blue-600 text-white px-6 py-3 rounded-lg">

                    Login untuk Membeli

                </a>

            @endauth

        </div>

    </div>

</div>

@endsection
