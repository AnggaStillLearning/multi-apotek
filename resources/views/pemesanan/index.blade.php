@extends('layouts.shop')

@section('content')

<div class="container mx-auto py-8">

    <h1 class="text-3xl font-bold mb-6">
        Keranjang Saya
    </h1>

    @if($pemesanans->isEmpty())

        <div class="bg-white rounded-xl shadow p-6 text-center">

            <p class="mb-4">Keranjang kamu masih kosong.</p>

            <a
                href="{{ route('shop.apoteks') }}"
                class="inline-block bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg">

                Mulai Belanja

            </a>

        </div>

    @else

        <p class="text-gray-500 mb-4">
            Kamu punya keranjang aktif di beberapa apotek berbeda:
        </p>

        <div class="grid md:grid-cols-2 gap-6">

            @foreach($pemesanans as $pemesanan)

                <a
                    href="{{ route('pemesanan.show', $pemesanan) }}"
                    class="bg-white rounded-xl shadow p-6 block hover:shadow-md transition">

                    <h2 class="text-xl font-semibold">
                        {{ $pemesanan->apotek->nama_apotek }}
                    </h2>

                    <p class="text-gray-500 mt-1">
                        {{ $pemesanan->details_count }} item &middot;
                        Rp {{ number_format($pemesanan->grand_total, 0, ',', '.') }}
                    </p>

                </a>

            @endforeach

        </div>

    @endif

</div>

@endsection
