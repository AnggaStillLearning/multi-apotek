@extends('layouts.app')

@section('content')

<h1 class="text-3xl font-bold mb-6">
    Monitoring Stok Kritis
</h1>

<div class="bg-white rounded-lg shadow overflow-hidden">

    <table class="w-full">

        <thead class="bg-gray-100">

            <tr>
                <th class="p-3 text-left">
                    Nama Obat
                </th>

                <th class="p-3 text-left">
                    Stok
                </th>

                <th class="p-3 text-left">
                    Minimum
                </th>

                <th class="p-3 text-left">
                    Status
                </th>
            </tr>

        </thead>

        <tbody>

        @forelse($obats as $obat)

            <tr class="border-t">

                <td class="p-3">
                    {{ $obat->nama_obat }}
                </td>

                <td class="p-3">
                    {{ $obat->stok }}
                </td>

                <td class="p-3">
                    {{ $obat->stok_minimum }}
                </td>

                <td class="p-3">

                    <span class="bg-red-500 text-white px-3 py-1 rounded">
                        KRITIS
                    </span>

                </td>

            </tr>

        @empty

            <tr>
                <td colspan="4"
                    class="text-center p-5">

                    Tidak ada stok kritis

                </td>
            </tr>

        @endforelse

        </tbody>

    </table>

</div>

@endsection
