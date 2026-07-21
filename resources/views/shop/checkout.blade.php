@extends('layouts.shop')

@section('content')

<h1 class="text-3xl font-bold mb-6">

    Checkout

</h1>

<form
    action="{{ route('checkout.store') }}"
    method="POST">

    @csrf

    <div class="bg-white rounded-xl shadow p-6">

        {{-- Pilih Apotek --}}

        <div class="mb-8">

            <label class="block mb-2 font-semibold">

                Pilih Apotek
                <span class="text-red-500">*</span>

            </label>

            <select
                name="apotek_id"
                class="w-full border rounded-lg p-3">

                <option value="">
                    -- Pilih Apotek --
                </option>

                @foreach($apoteks as $apotek)

                    <option
                        value="{{ $apotek->id }}"
                        {{ old('apotek_id') == $apotek->id ? 'selected' : '' }}>

                        {{ $apotek->nama_apotek }}

                    </option>

                @endforeach

            </select>

            @error('apotek_id')

                <small class="text-red-500">

                    {{ $message }}

                </small>

            @enderror

        </div>

        {{-- Ringkasan Pesanan --}}

        <table class="w-full border rounded-lg overflow-hidden">

            <thead class="bg-gray-100">

                <tr>

                    <th class="p-3 text-left">

                        Obat

                    </th>

                    <th class="p-3 text-center">

                        Qty

                    </th>

                    <th class="p-3 text-right">

                        Harga

                    </th>

                    <th class="p-3 text-right">

                        Subtotal

                    </th>

                </tr>

            </thead>

            <tbody>

                @foreach($cart as $item)

                <tr class="border-t">

                    <td class="p-3">

                        {{ $item['nama'] }}

                    </td>

                    <td class="text-center">

                        {{ $item['qty'] }}

                    </td>

                    <td class="text-right">

                        Rp {{ number_format($item['harga'],0,',','.') }}

                    </td>

                    <td class="text-right font-semibold">

                        Rp {{ number_format($item['harga'] * $item['qty'],0,',','.') }}

                    </td>

                </tr>

                @endforeach

            </tbody>

            <tfoot>

                <tr class="bg-gray-50">

                    <th
                        colspan="3"
                        class="text-right p-4">

                        Total

                    </th>

                    <th class="text-right text-xl text-green-600 p-4">

                        Rp {{ number_format($total,0,',','.') }}

                    </th>

                </tr>

            </tfoot>

        </table>

        <div class="flex justify-end mt-8">

            <button
                class="bg-green-600 hover:bg-green-700 text-white px-8 py-3 rounded-lg">

                Buat Pesanan

            </button>

        </div>

    </div>

</form>

@endsection
