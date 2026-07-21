@extends('layouts.shop')

@section('content')

<div class="container mx-auto py-8">

    <div class="bg-white rounded-xl shadow p-8">

        <h1 class="text-3xl font-bold">

            {{ $obat->nama_obat }}

        </h1>

        <div class="mt-4 space-y-2">

            <p>

                <strong>Kategori :</strong>

                {{ $obat->kategori->nama_kategori ?? '-' }}

            </p>

            <p>

                <strong>Jenis :</strong>

                {{ $obat->jenisObat->nama ?? '-' }}

            </p>

            <p>

                <strong>Harga :</strong>

                Rp {{ number_format($obat->harga_jual,0,',','.') }}

            </p>

            <p>

                <strong>Stok :</strong>

                {{ $obat->stok }}

            </p>

        </div>

        <div class="mt-8">

            @auth

                @if(auth()->user()->role == 'pembeli')

                    <form
    action="{{ route('cart.add',$obat->id) }}"
    method="POST">

    @csrf

    <button
        class="bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-lg">

        Tambah ke Keranjang

    </button>

</form>

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
