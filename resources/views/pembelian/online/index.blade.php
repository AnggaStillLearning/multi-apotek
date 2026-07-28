@extends('layouts.shop')

@php
    $labelStatus = [
        'menunggu_pembayaran' => ['Menunggu Pembayaran', 'bg-yellow-100 text-yellow-700'],
        'diproses' => ['Diproses', 'bg-blue-100 text-blue-700'],
        'selesai' => ['Selesai', 'bg-green-100 text-green-700'],
        'dibatalkan' => ['Dibatalkan', 'bg-red-100 text-red-700'],
    ];
@endphp

@section('content')

<div class="container mx-auto py-8">

    <h1 class="text-3xl font-bold mb-6">
        Pesanan Saya
    </h1>

    @if($pembelians->isEmpty())

        <div class="bg-white rounded-xl shadow p-6 text-center">

            <p class="mb-4">Belum ada pesanan.</p>

            <a
                href="{{ route('shop.apoteks') }}"
                class="inline-block bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg">

                Mulai Belanja

            </a>

        </div>

    @else

        <div class="bg-white rounded-xl shadow divide-y">

            @foreach($pembelians as $pembelian)

                <a
                    href="{{ route('pembelian.online.show', $pembelian) }}"
                    class="flex items-center justify-between p-5 hover:bg-gray-50 transition">

                    <div>
                        <p class="font-semibold">{{ $pembelian->nomor_pembelian }}</p>
                        <p class="text-sm text-gray-500">
                            {{ $pembelian->apotek->nama_apotek }} &middot;
                            {{ \Carbon\Carbon::parse($pembelian->tanggal_pembelian)->format('d M Y H:i') }}
                        </p>
                    </div>

                    <div class="text-right">
                        <p class="font-semibold text-green-600">
                            Rp {{ number_format($pembelian->grand_total, 0, ',', '.') }}
                        </p>
                        <span class="text-xs px-2 py-1 rounded-full {{ $labelStatus[$pembelian->status][1] }}">
                            {{ $labelStatus[$pembelian->status][0] }}
                        </span>
                    </div>

                </a>

            @endforeach

        </div>

        <div class="mt-6">
            {{ $pembelians->links() }}
        </div>

    @endif

</div>

@endsection
