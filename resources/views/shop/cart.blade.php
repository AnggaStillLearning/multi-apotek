@extends('layouts.shop')

@section('content')

<div class="container mx-auto py-8">

    <h1 class="text-3xl font-bold mb-6">

        Keranjang Belanja

    </h1>

    @if(count($cart))

    <table class="w-full bg-white shadow rounded-lg">

        <thead class="bg-gray-100">

            <tr>

                <th class="p-3 text-left">Obat</th>

                <th class="p-3 text-center">Harga</th>

                <th class="p-3 text-center">Qty</th>

                <th class="p-3 text-center">Subtotal</th>

                <th class="p-3 text-center">Aksi</th>

            </tr>

        </thead>

        <tbody>

            @php

                $total = 0;

            @endphp

            @foreach($cart as $item)

            @php

                $subtotal = $item['harga'] * $item['qty'];

                $total += $subtotal;

            @endphp

            <tr class="border-b">

                <td class="p-3">

                    {{ $item['nama'] }}

                </td>

                <td class="p-3 text-center">

                    Rp {{ number_format($item['harga'],0,',','.') }}

                </td>

                <td class="p-3 text-center">

                    <form
                        action="{{ route('cart.update',$item['id']) }}"
                        method="POST"
                        class="flex justify-center">

                        @csrf

                        <input
                            type="number"
                            name="qty"
                            min="1"
                            max="{{ $item['stok'] }}"
                            value="{{ $item['qty'] }}"
                            class="border rounded w-20 text-center">

                        <button
                            class="ml-2 bg-blue-600 text-white px-3 rounded">

                            Update

                        </button>

                    </form>

                </td>

                <td class="p-3 text-center">

                    Rp {{ number_format($subtotal,0,',','.') }}

                </td>

                <td class="p-3 text-center">

                    <form
                        action="{{ route('cart.remove',$item['id']) }}"
                        method="POST">

                        @csrf

                        @method('DELETE')

                        <button
                            class="bg-red-600 text-white px-3 py-2 rounded">

                            Hapus

                        </button>

                    </form>

                </td>

            </tr>

            @endforeach

        </tbody>

        <tfoot>

            <tr>

                <th colspan="3" class="text-right p-4">

                    Total

                </th>

                <th class="text-center">

                    Rp {{ number_format($total,0,',','.') }}

                </th>

                <th></th>

            </tr>

        </tfoot>

    </table>

    @else

    <div class="bg-white rounded-lg shadow p-6 text-center">

        Keranjang masih kosong.

    </div>

    @endif

</div>

@endsection
