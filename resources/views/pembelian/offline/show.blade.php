@extends('layouts.app')

@section('title', 'Detail Transaksi')

@section('content')
<div class="max-w-2xl space-y-6">

    <a href="{{ route('pembelian.offline.index') }}" class="text-blue-600 hover:underline text-sm">
        &larr; Kembali
    </a>

    @if(session('success'))
        <div class="rounded-lg bg-green-50 border border-green-200 text-green-700 px-4 py-3 text-sm">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white rounded-xl shadow-sm border p-8">

        <div class="flex items-center justify-between flex-wrap gap-4 mb-6">

            <div>
                <h1 class="text-2xl font-bold text-gray-800">{{ $pembelian->nomor_pembelian }}</h1>
                <p class="text-sm text-gray-500">
                    {{ \Carbon\Carbon::parse($pembelian->tanggal_pembelian)->format('d M Y H:i') }}
                    &middot; Kasir: {{ $pembelian->kasir->name ?? '-' }}
                </p>
            </div>

            <span class="text-sm px-3 py-1 rounded-full bg-green-100 text-green-700">
                Selesai
            </span>

        </div>

        <table class="w-full text-sm border rounded-lg overflow-hidden">

            <thead class="bg-gray-50">
                <tr>
                    <th class="p-3 text-left">Obat</th>
                    <th class="p-3 text-center">Satuan</th>
                    <th class="p-3 text-center">Qty</th>
                    <th class="p-3 text-right">Harga</th>
                    <th class="p-3 text-right">Subtotal</th>
                </tr>
            </thead>

            <tbody>

                @foreach($pembelian->details as $item)

                    <tr class="border-t">
                        <td class="p-3">{{ $item->obat->nama_obat }}</td>
                        <td class="p-3 text-center">{{ $item->konversi->satuan->nama_satuan }}</td>
                        <td class="p-3 text-center">{{ $item->qty }}</td>
                        <td class="p-3 text-right">Rp {{ number_format($item->harga_jual, 0, ',', '.') }}</td>
                        <td class="p-3 text-right">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                    </tr>

                @endforeach

            </tbody>

            <tfoot>
                <tr class="bg-gray-50">
                    <th colspan="4" class="text-right p-3">Total ({{ $pembelian->metode_pembayaran }})</th>
                    <th class="text-right p-3 text-green-600">
                        Rp {{ number_format($pembelian->grand_total, 0, ',', '.') }}
                    </th>
                </tr>
            </tfoot>

        </table>

        <div class="flex justify-end mt-6">
            <button onclick="window.print()" class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-5 py-2.5 rounded-lg text-sm">
                Cetak Struk
            </button>
        </div>

    </div>

</div>
@endsection
