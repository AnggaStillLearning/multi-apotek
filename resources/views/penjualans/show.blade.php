@extends('layouts.app')

@section('content')

<h1 class="text-3xl font-bold mb-6">
    Detail Transaksi
</h1>

<div class="bg-white rounded-xl shadow p-6">

    <p>
        Tanggal :
        {{ $penjualan->tanggal }}
    </p>

    <p>
        Total :
        Rp {{ number_format($penjualan->total_harga,0,',','.') }}
    </p>

</div>

<div class="bg-white rounded-xl shadow mt-6">

    <table class="w-full">

        <thead class="bg-gray-100">

            <tr>

                <th class="p-3">
                    Obat
                </th>

                <th class="p-3">
                    Qty
                </th>

                <th class="p-3">
                    Harga
                </th>

                <th class="p-3">
                    Subtotal
                </th>

            </tr>

        </thead>

        <tbody>

            @foreach(
                $penjualan->details
                as $detail
            )

            <tr>

                <td class="p-3">
                    {{ $detail->obat->nama_obat }}
                </td>

                <td class="p-3">
                    {{ $detail->qty }}
                </td>

                <td class="p-3">
                    Rp {{ number_format($detail->harga,0,',','.') }}
                </td>

                <td class="p-3">
                    Rp {{ number_format($detail->subtotal,0,',','.') }}
                </td>

            </tr>

            @endforeach

        </tbody>

    </table>

</div>

@endsection
