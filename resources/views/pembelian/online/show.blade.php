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

    <a href="{{ route('pembelian.online.index') }}" class="text-blue-600 hover:underline text-sm">
        &larr; Pesanan Saya
    </a>

    <div class="bg-white rounded-xl shadow p-8 mt-4">

        <div class="flex items-center justify-between flex-wrap gap-4">

            <div>
                <h1 class="text-2xl font-bold">{{ $pembelian->nomor_pembelian }}</h1>
                <p class="text-gray-500">
                    {{ $pembelian->apotek->nama_apotek }} &middot;
                    {{ \Carbon\Carbon::parse($pembelian->tanggal_pembelian)->format('d M Y H:i') }}
                </p>
            </div>

            <span class="text-sm px-3 py-1 rounded-full {{ $labelStatus[$pembelian->status][1] }}">
                {{ $labelStatus[$pembelian->status][0] }}
            </span>

        </div>

        <table class="w-full mt-6 border rounded-lg overflow-hidden">

            <thead class="bg-gray-100">
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
                    <th colspan="4" class="text-right p-4">Total</th>
                    <th class="text-right text-lg text-green-600 p-4">
                        Rp {{ number_format($pembelian->grand_total, 0, ',', '.') }}
                    </th>
                </tr>
            </tfoot>

        </table>

        <div class="flex justify-end gap-3 mt-8">

            @if($pembelian->status === 'menunggu_pembayaran')

                <form action="{{ route('pembelian.online.batal', $pembelian) }}" method="POST">
                    @csrf
                    <button class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-6 py-3 rounded-lg">
                        Batalkan
                    </button>
                </form>

                @if($snapToken)

                    <button
                        id="btn-bayar-midtrans"
                        class="bg-green-600 hover:bg-green-700 text-white px-8 py-3 rounded-lg">
                        Bayar Sekarang
                    </button>

                @else

                    {{-- Fallback dev/testing: dipakai kalau kredensial Midtrans belum
                         diisi di .env, atau webhook belum bisa diakses publik (butuh
                         ngrok saat development). Jangan dipakai di production. --}}
                    <form action="{{ route('pembelian.online.bayar', $pembelian) }}" method="POST">
                        @csrf
                        <button class="bg-yellow-500 hover:bg-yellow-600 text-white px-8 py-3 rounded-lg">
                            Konfirmasi Pembayaran (mode testing)
                        </button>
                    </form>

                @endif

            @elseif($pembelian->status === 'diproses')

                <p class="text-gray-500 text-sm self-center">
                    Pembayaran dikonfirmasi. Menunggu barang diambil/dikirim.
                </p>

            @elseif($pembelian->status === 'selesai')

                <p class="text-green-600 text-sm self-center">
                    Pesanan sudah selesai. Terima kasih!
                </p>

            @elseif($pembelian->status === 'dibatalkan')

                <p class="text-red-500 text-sm self-center">
                    Pesanan ini dibatalkan.
                </p>

            @endif

        </div>

    </div>

</div>

@if($snapToken)

    <script
        src="{{ config('services.midtrans.is_production') ? 'https://app.midtrans.com/snap/snap.js' : 'https://app.sandbox.midtrans.com/snap/snap.js' }}"
        data-client-key="{{ config('services.midtrans.client_key') }}">
    </script>

    <script>
        document.getElementById('btn-bayar-midtrans').addEventListener('click', function () {
            snap.pay('{{ $snapToken }}', {
                onSuccess: function () {
                    window.location.reload();
                },
                onPending: function () {
                    window.location.reload();
                },
                onError: function () {
                    alert('Pembayaran gagal diproses. Silakan coba lagi.');
                },
                onClose: function () {
                    // Pembeli menutup popup tanpa menyelesaikan pembayaran — biarkan
                    // saja, status tetap menunggu_pembayaran sampai dicoba lagi.
                }
            });
        });
    </script>

@endif

@endsection
