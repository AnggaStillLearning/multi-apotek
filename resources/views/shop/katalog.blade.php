@extends('layouts.shop')

@section('content')

<div class="container mx-auto py-8">

    <h1 class="text-3xl font-bold mb-6">
        Daftar Obat
    </h1>

    @if($obats->count())

        <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-6">

            @foreach($obats as $obat)

                <div class="bg-white rounded-xl shadow p-5">

                    <h2 class="text-xl font-semibold">

                        {{ $obat->nama_obat }}

                    </h2>

                    <p class="text-gray-500 mt-2">

                        {{ $obat->kategori->nama_kategori ?? '-' }}

                    </p>

                    <p class="text-gray-500">

                        {{ $obat->jenisObat->nama ?? '-' }}

                    </p>

                    <p class="text-green-600 font-bold text-lg mt-3">

                        Rp {{ number_format($obat->harga_jual,0,',','.') }}

                    </p>

                    <p class="text-sm text-gray-500">

                        Stok : {{ $obat->stok }}

                    </p>

                    <a
                        href="{{ route('shop.show',$obat->id) }}"
                        class="block text-center mt-5 bg-blue-600 hover:bg-blue-700 text-white py-2 rounded-lg">

                        Detail

                    </a>

                </div>

            @endforeach

        </div>

        <div class="mt-8">

            {{ $obats->links() }}

        </div>

    @else

        <div class="bg-white rounded-xl shadow p-6 text-center">

            Tidak ada obat tersedia.

        </div>

    @endif

</div>

@endsection
