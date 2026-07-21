@extends('layouts.app')

@section('content')

<div class="mb-8">

    <h1 class="text-3xl font-bold text-gray-800">
        Monitoring Kadaluarsa
    </h1>

    <p class="text-gray-500 mt-2">
        Daftar batch obat yang mendekati tanggal kadaluarsa dalam 30 hari ke depan.
    </p>

</div>

<div class="bg-white rounded-xl shadow overflow-hidden">

    <table class="min-w-full">

        <thead class="bg-gray-100">

            <tr>

                <th class="px-6 py-4 text-left">
                    Nama Obat
                </th>

                <th class="px-6 py-4 text-center">
                    Batch
                </th>

                <th class="px-6 py-4 text-center">
                    Gudang
                </th>

                <th class="px-6 py-4 text-center">
                    Ruangan
                </th>

                <th class="px-6 py-4 text-center">
                    Stok Batch
                </th>

                <th class="px-6 py-4 text-center">
                    Kadaluarsa
                </th>

                <th class="px-6 py-4 text-center">
                    Sisa Hari
                </th>

                <th class="px-6 py-4 text-center">
                    Status
                </th>

            </tr>

        </thead>

        <tbody>

            @forelse($obats as $batch)

                @php

                    $sisaHari = ceil(
                        now()->diffInRealDays(
                            $batch->tanggal_kadaluarsa,
                            false
                        )
                    );

                @endphp

                <tr class="border-t hover:bg-gray-50">

                    <td class="px-6 py-4 font-medium">

                        {{ $batch->obat->nama_obat }}

                    </td>

                    <td class="px-6 py-4 text-center font-mono">

                        {{ $batch->nomor_batch }}

                    </td>

                    <td class="px-6 py-4 text-center">

                        {{ $batch->gudang->nama_gudang }}

                    </td>

                    <td class="px-6 py-4 text-center">

                        {{ $batch->ruangan->nama_ruangan }}

                    </td>

                    <td class="px-6 py-4 text-center font-semibold">

                        {{ $batch->stok }}

                    </td>

                    <td class="px-6 py-4 text-center">

                        {{ \Carbon\Carbon::parse($batch->tanggal_kadaluarsa)->format('d M Y') }}

                    </td>

                    <td class="px-6 py-4 text-center">

                        @if($sisaHari < 0)

                            <span class="text-red-600 font-semibold">

                                Kadaluarsa

                            </span>

                        @else

                            {{ $sisaHari }} Hari

                        @endif

                    </td>

                    <td class="px-6 py-4 text-center">

                        @if($sisaHari < 0)

                            <span class="px-3 py-1 rounded-full bg-gray-600 text-white text-sm">
                                Kadaluarsa
                            </span>

                        @elseif($sisaHari <= 7)

                            <span class="px-3 py-1 rounded-full bg-red-600 text-white text-sm">
                                Segera
                            </span>

                        @elseif($sisaHari <= 30)

                            <span class="px-3 py-1 rounded-full bg-yellow-500 text-white text-sm">
                                Perhatian
                            </span>

                        @else

                            <span class="px-3 py-1 rounded-full bg-green-600 text-white text-sm">
                                Aman
                            </span>

                        @endif

                    </td>

                </tr>

            @empty

                <tr>

                    <td colspan="8" class="py-10 text-center text-gray-500">

                        Tidak ada batch obat yang mendekati kadaluarsa.

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
