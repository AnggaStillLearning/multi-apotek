@extends('layouts.app')

@section('content')

<div class="mb-6">

    <h1 class="text-3xl font-bold text-gray-800">
        Monitoring Stok Kritis
    </h1>

    <p class="text-gray-500 mt-2">
        Daftar obat yang memiliki stok sama atau di bawah batas minimum.
    </p>

</div>

<div class="bg-white rounded-xl shadow overflow-hidden">

    <table class="min-w-full">

        <thead class="bg-gray-100">

            <tr>

                <th class="px-6 py-3 text-left">
                    Nama Obat
                </th>

                <th class="px-6 py-3 text-center">
                    Total Stok
                </th>

                <th class="px-6 py-3 text-center">
                    Stok Minimum
                </th>

                <th class="px-6 py-3 text-center">
                    Kekurangan
                </th>

                <th class="px-6 py-3 text-center">
                    Status
                </th>

            </tr>

        </thead>

        <tbody>

            @forelse($obats as $obat)

                @php

                    $selisih = max(
                        0,
                        $obat->stok_minimum - $obat->total_stok
                    );

                @endphp

                <tr class="border-t hover:bg-gray-50">

                    <td class="px-6 py-4 font-medium">

                        {{ $obat->nama_obat }}

                    </td>

                    <td class="px-6 py-4 text-center">

                        {{ $obat->total_stok }}

                    </td>

                    <td class="px-6 py-4 text-center">

                        {{ $obat->stok_minimum }}

                    </td>

                    <td class="px-6 py-4 text-center text-red-600 font-semibold">

                        {{ $selisih }}

                    </td>

                    <td class="px-6 py-4 text-center">

                        @if($obat->total_stok == 0)

                            <span class="px-3 py-1 rounded-full bg-red-600 text-white text-sm">
                                Sangat Kritis
                            </span>

                        @else

                            <span class="px-3 py-1 rounded-full bg-yellow-500 text-white text-sm">
                                Kritis
                            </span>

                        @endif

                    </td>

                </tr>

            @empty

                <tr>

                    <td colspan="5" class="text-center py-10 text-gray-500">

                        Tidak ada obat dengan stok kritis.

                    </td>

                </tr>

            @endforelse

        </tbody>

    </table>

</div>

@if($obats->hasPages())

    <div class="mt-6">

        {{ $obats->links() }}

    </div>

@endif

@endsection
