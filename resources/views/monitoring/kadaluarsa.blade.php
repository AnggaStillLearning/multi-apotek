@extends('layouts.app')

@section('content')

<h1 class="text-3xl font-bold mb-6">
    Monitoring Kadaluarsa
</h1>

<div class="bg-white rounded-xl shadow overflow-hidden">

<table class="w-full">

    <thead class="bg-gray-100">

        <tr>
            <th class="p-4 text-left">
                Nama Obat
            </th>

            <th class="p-4 text-left">
                Tanggal Kadaluarsa
            </th>

            <th class="p-4 text-left">
                Sisa Hari
            </th>

            <th class="p-4 text-left">
                Status
            </th>
        </tr>

    </thead>

    <tbody>

    @forelse($obats as $obat)

        @php
            $sisaHari = (int) now()->diffInDays(
                $obat->tanggal_kadaluarsa,
                false
            );
        @endphp

        <tr class="border-t hover:bg-gray-50">

            <td class="p-4">
                {{ $obat->nama_obat }}
            </td>

            <td class="p-4">
                {{ \Carbon\Carbon::parse($obat->tanggal_kadaluarsa)->format('d M Y') }}
            </td>

            <td class="p-4">

                @if($sisaHari <= 0)

                    Kadaluarsa

                @else

                    {{ $sisaHari }} Hari

                @endif

            </td>

            <td class="p-4">

                @if($sisaHari <= 7)

                    <span class="bg-red-500 text-white px-3 py-1 rounded-full text-sm">
                        KRITIS
                    </span>

                @elseif($sisaHari <= 30)

                    <span class="bg-yellow-500 text-white px-3 py-1 rounded-full text-sm">
                        PERINGATAN
                    </span>

                @else

                    <span class="bg-green-500 text-white px-3 py-1 rounded-full text-sm">
                        AMAN
                    </span>

                @endif

            </td>

        </tr>

    @empty

        <tr>
            <td colspan="4"
                class="text-center p-6 text-gray-500">

                Tidak ada obat mendekati kadaluarsa

            </td>
        </tr>

    @endforelse

    </tbody>

</table>


</div>

@endsection
