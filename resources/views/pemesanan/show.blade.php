@extends('layouts.shop')

@section('content')

<div class="container mx-auto py-8">

    <h1 class="text-3xl font-bold mb-2">
        Keranjang &mdash; {{ $pemesanan->apotek->nama_apotek }}
    </h1>

    <p class="text-gray-500 mb-6">
        Nomor: {{ $pemesanan->nomor_pemesanan }}
    </p>

    @if($pemesanan->details->isEmpty())

        <div class="bg-white rounded-lg shadow p-6 text-center">
            Keranjang masih kosong.
        </div>

    @else

        <table class="w-full bg-white shadow rounded-lg overflow-hidden">

            <thead class="bg-gray-100">
                <tr>
                    <th class="p-3 text-left">Obat</th>
                    <th class="p-3 text-center">Satuan</th>
                    <th class="p-3 text-center">Harga</th>
                    <th class="p-3 text-center">Qty</th>
                    <th class="p-3 text-center">Subtotal</th>
                    <th class="p-3 text-center">Aksi</th>
                </tr>
            </thead>

            <tbody>

                @foreach($pemesanan->details as $item)

                    <tr class="border-b">

                        <td class="p-3">
                            {{ $item->obat->nama_obat }}
                        </td>

                        <td class="p-3 text-center">
                            {{ $item->konversi->satuan->nama_satuan }}
                        </td>

                        <td class="p-3 text-center">
                            Rp {{ number_format($item->harga_jual, 0, ',', '.') }}
                        </td>

                        <td class="p-3 text-center">

                            <form
                                action="{{ route('pemesanan.items.update', $item) }}"
                                method="POST"
                                class="flex justify-center gap-2">

                                @csrf
                                @method('PUT')

                                <input
                                    type="number"
                                    name="qty"
                                    min="1"
                                    value="{{ $item->qty }}"
                                    class="border rounded w-20 text-center">

                                <button class="bg-blue-600 text-white px-3 rounded">
                                    Update
                                </button>

                            </form>

                        </td>

                        <td class="p-3 text-center">
                            Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                        </td>

                        <td class="p-3 text-center">

                            <form
                                action="{{ route('pemesanan.items.destroy', $item) }}"
                                method="POST">

                                @csrf
                                @method('DELETE')

                                <button class="bg-red-600 text-white px-3 py-2 rounded">
                                    Hapus
                                </button>

                            </form>

                        </td>

                    </tr>

                @endforeach

            </tbody>

            <tfoot>
                <tr>
                    <th colspan="4" class="text-right p-4">Total</th>
                    <th class="text-center">
                        Rp {{ number_format($pemesanan->grand_total, 0, ',', '.') }}
                    </th>
                    <th></th>
                </tr>
            </tfoot>

        </table>

        <div class="flex justify-end mt-8">

            <form action="{{ route('pembelian.online.store', $pemesanan) }}" method="POST">

                @csrf

                <button class="bg-green-600 hover:bg-green-700 text-white px-8 py-3 rounded-lg">
                    Checkout
                </button>

            </form>

        </div>

    @endif

</div>

@endsection
