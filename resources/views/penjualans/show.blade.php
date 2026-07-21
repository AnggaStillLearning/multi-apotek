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

    <table class="w-full overflow-hidden rounded-xl">

    <thead class="bg-blue-600 text-white">

        <tr>

            <th class="p-3 text-left">Obat</th>

            <th class="p-3 text-left">Batch</th>

            <th class="p-3 text-left">Kadaluarsa</th>

            <th class="p-3 text-right">Harga</th>

            <th class="p-3 text-center">Qty</th>

            <th class="p-3 text-right">Subtotal</th>

        </tr>

    </thead>

    <tbody>

        @forelse($penjualan->details as $detail)

        <tr class="border-b hover:bg-gray-50">

            <td class="p-3">

                <div class="font-semibold">

                    {{ $detail->obat->nama_obat }}

                </div>

            </td>

            <td class="p-3">

                <span class="bg-blue-100 text-blue-700 px-2 py-1 rounded">

                    {{ $detail->obat->batch }}

                </span>

            </td>

            <td class="p-3">

                {{ \Carbon\Carbon::parse(
                    $detail->obat->tanggal_kadaluarsa
                )->format('d M Y') }}

            </td>

            <td class="p-3 text-right">

                Rp {{ number_format($detail->harga,0,',','.') }}

            </td>

            <td class="p-3 text-center">

                {{ $detail->qty }}

            </td>

            <td class="p-3 text-right font-semibold">

                Rp {{ number_format($detail->subtotal,0,',','.') }}

            </td>

        </tr>

        @empty

        <tr>

            <td colspan="6" class="text-center py-6 text-gray-500">

                Tidak ada detail transaksi.

            </td>

        </tr>

        @endforelse

    </tbody>

    <tfoot>

        <tr class="bg-gray-100">

            <th colspan="5" class="text-right p-4">

                Total Transaksi

            </th>

            <th class="text-right p-4 text-green-700 text-lg">

                Rp {{ number_format($penjualan->total_harga,0,',','.') }}

            </th>

        </tr>

    </tfoot>

</table>

</div>

@endsection
