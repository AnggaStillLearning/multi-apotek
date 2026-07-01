@extends('layouts.app')

@section('content')

<div class="flex justify-between items-center mb-6">

    <h1 class="text-3xl font-bold">

        Detail Transaksi

    </h1>

    <a href="{{ route('penjualans.index') }}"
       class="bg-gray-600 text-white px-4 py-2 rounded">

        Kembali

    </a>

</div>

<div class="bg-white rounded-xl shadow p-6">

    <div class="grid grid-cols-2 gap-6 mb-6">

        <div>

            <p><strong>No Transaksi :</strong></p>

            <p>#{{ $penjualan->id }}</p>

        </div>

        <div>

            <p><strong>Tanggal :</strong></p>

            <p>{{ \Carbon\Carbon::parse($penjualan->tanggal)->format('d M Y') }}</p>

        </div>

        <div>

            <p><strong>Kasir :</strong></p>

            <p>{{ $penjualan->user->name }}</p>

        </div>

        <div>

            <p><strong>Status :</strong></p>

            @if($penjualan->status == 'selesai')

                <span class="bg-green-100 text-green-700 px-3 py-1 rounded">

                    Selesai

                </span>

            @else

                <span class="bg-red-100 text-red-700 px-3 py-1 rounded">

                    Dibatalkan

                </span>

            @endif

        </div>

    </div>

    <table class="w-full border">

        <thead class="bg-gray-100">

            <tr>

                <th class="border p-3">Obat</th>

                <th class="border p-3">Harga</th>

                <th class="border p-3">Qty</th>

                <th class="border p-3">Subtotal</th>

            </tr>

        </thead>

        <tbody>

            @foreach($penjualan->details as $detail)

            <tr>

                <td class="border p-3">

                    {{ $detail->obat->nama_obat }}

                </td>

                <td class="border p-3">

                    Rp {{ number_format($detail->harga,0,',','.') }}

                </td>

                <td class="border p-3">

                    {{ $detail->qty }}

                </td>

                <td class="border p-3">

                    Rp {{ number_format($detail->subtotal,0,',','.') }}

                </td>

            </tr>

            @endforeach

        </tbody>

        <tfoot>

            <tr>

                <th colspan="3" class="border p-3 text-right">

                    Total

                </th>

                <th class="border p-3">

                    Rp {{ number_format($penjualan->total_harga,0,',','.') }}

                </th>

            </tr>

        </tfoot>

    </table>

</div>

@endsection
