@extends('layouts.app')

@section('content')

<div class="mb-6">

    <h1 class="text-3xl font-bold text-gray-800">
        Monitoring
    </h1>

    <p class="text-gray-500 mt-2">
        Pantau obat dengan stok kritis dan batch obat yang mendekati kadaluarsa.
    </p>

</div>

{{-- ================= STOK KRITIS ================= --}}
<div class="mb-10">

    <h2 class="text-xl font-semibold text-gray-800 mb-4">
        Stok Kritis
        <span class="text-sm font-normal text-gray-500">
            (stok sama atau di bawah batas minimum)
        </span>
    </h2>

    <div class="bg-white rounded-xl shadow overflow-hidden">

        <table class="min-w-full">

            <thead class="bg-gray-100">

                <tr>
                    <th class="px-6 py-3 text-left">Nama Obat</th>
                    <th class="px-6 py-3 text-center">Total Stok</th>
                    <th class="px-6 py-3 text-center">Stok Minimum</th>
                    <th class="px-6 py-3 text-center">Kekurangan</th>
                    <th class="px-6 py-3 text-center">Status</th>
                </tr>

            </thead>

            <tbody>

                @forelse($stokKritisObats as $obat)

                    @php
                        $selisih = max(0, $obat->stok_minimum - $obat->total_stok);
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

    @if($stokKritisObats->hasPages())
        <div class="mt-4">
            {{ $stokKritisObats->links() }}
        </div>
    @endif

</div>

{{-- ================= KADALUARSA ================= --}}
<div>

    <h2 class="text-xl font-semibold text-gray-800 mb-4">
        Kadaluarsa
        <span class="text-sm font-normal text-gray-500">
            (mendekati tanggal kadaluarsa dalam 30 hari)
        </span>
    </h2>

    <div class="bg-white rounded-xl shadow overflow-hidden">

        <table class="min-w-full">

            <thead class="bg-gray-100">

                <tr>
                    <th class="px-6 py-4 text-left">Nama Obat</th>
                    <th class="px-6 py-4 text-center">Batch</th>
                    <th class="px-6 py-4 text-center">Gudang</th>
                    <th class="px-6 py-4 text-center">Ruangan</th>
                    <th class="px-6 py-4 text-center">Stok Batch</th>
                    <th class="px-6 py-4 text-center">Kadaluarsa</th>
                    <th class="px-6 py-4 text-center">Sisa Hari</th>
                    <th class="px-6 py-4 text-center">Status</th>
                </tr>

            </thead>

            <tbody>

                @forelse($kadaluarsaObats as $batch)

                    @php
                        $sisaHari = ceil(now()->diffInRealDays($batch->tanggal_kadaluarsa, false));
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
                                <span class="text-red-600 font-semibold">Kadaluarsa</span>
                            @else
                                {{ $sisaHari }} Hari
                            @endif

                        </td>

                        <td class="px-6 py-4 text-center">

                            @if($sisaHari < 0)
                                <span class="px-3 py-1 rounded-full bg-gray-600 text-white text-sm">Kadaluarsa</span>
                            @elseif($sisaHari <= 7)
                                <span class="px-3 py-1 rounded-full bg-red-600 text-white text-sm">Segera</span>
                            @elseif($sisaHari <= 30)
                                <span class="px-3 py-1 rounded-full bg-yellow-500 text-white text-sm">Perhatian</span>
                            @else
                                <span class="px-3 py-1 rounded-full bg-green-600 text-white text-sm">Aman</span>
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

    @if($kadaluarsaObats->hasPages())
        <div class="mt-4">
            {{ $kadaluarsaObats->links() }}
        </div>
    @endif

</div>

@endsection
