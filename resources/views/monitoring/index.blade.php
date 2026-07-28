@extends('layouts.app')

@section('title', 'Monitoring')

@section('content')

<div class="mb-6">

    <h1 class="text-3xl font-bold text-gray-800">
        Monitoring
    </h1>

    <p class="text-gray-500 mt-2">
        Pantau obat dengan stok kritis dan batch obat yang mendekati/sudah kadaluarsa.
    </p>

</div>

{{-- Tab --}}
<div class="border-b border-gray-200 mb-6">

    <nav class="flex gap-6">

        @php
            $tabs = [
                'stok-kritis' => 'Stok Kritis',
                'akan-kadaluarsa' => 'Akan Kadaluarsa',
                'kadaluarsa' => 'Kadaluarsa',
            ];
        @endphp

        @foreach($tabs as $key => $label)

            <a
                href="{{ route('monitoring.index', ['tab' => $key]) }}"
                class="pb-3 px-1 border-b-2 text-sm font-medium transition
                    {{ $tab === $key
                        ? 'border-blue-600 text-blue-600'
                        : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">

                {{ $label }}

                <span class="ml-1 text-xs px-2 py-0.5 rounded-full
                    {{ $tab === $key ? 'bg-blue-100 text-blue-700' : 'bg-gray-100 text-gray-500' }}">
                    {{ $jumlah[$key] }}
                </span>

            </a>

        @endforeach

    </nav>

</div>

{{-- ================= STOK KRITIS ================= --}}
@if($tab === 'stok-kritis')

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

                @forelse($obats as $obat)

                    @php
                        $selisih = max(0, $obat->stok_minimum - $obat->total_stok);
                    @endphp

                    <tr class="border-t hover:bg-gray-50">

                        <td class="px-6 py-4 font-medium">{{ $obat->nama_obat }}</td>
                        <td class="px-6 py-4 text-center">{{ $obat->total_stok }}</td>
                        <td class="px-6 py-4 text-center">{{ $obat->stok_minimum }}</td>
                        <td class="px-6 py-4 text-center text-red-600 font-semibold">{{ $selisih }}</td>

                        <td class="px-6 py-4 text-center">

                            @if($obat->total_stok == 0)
                                <span class="px-3 py-1 rounded-full bg-red-600 text-white text-sm">Sangat Kritis</span>
                            @else
                                <span class="px-3 py-1 rounded-full bg-yellow-500 text-white text-sm">Kritis</span>
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
        <div class="mt-6">{{ $obats->links() }}</div>
    @endif

@endif

{{-- ================= AKAN KADALUARSA ================= --}}
@if($tab === 'akan-kadaluarsa')

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
                </tr>
            </thead>

            <tbody>

                @forelse($batches as $batch)

                    @php
                        $sisaHari = ceil(now()->diffInRealDays($batch->tanggal_kadaluarsa, false));
                    @endphp

                    <tr class="border-t hover:bg-gray-50">

                        <td class="px-6 py-4 font-medium">{{ $batch->obat->nama_obat }}</td>
                        <td class="px-6 py-4 text-center font-mono">{{ $batch->nomor_batch }}</td>
                        <td class="px-6 py-4 text-center">{{ $batch->gudang->nama_gudang }}</td>
                        <td class="px-6 py-4 text-center">{{ $batch->ruangan->nama_ruangan }}</td>
                        <td class="px-6 py-4 text-center font-semibold">{{ $batch->stok }}</td>
                        <td class="px-6 py-4 text-center">{{ \Carbon\Carbon::parse($batch->tanggal_kadaluarsa)->format('d M Y') }}</td>

                        <td class="px-6 py-4 text-center">

                            @if($sisaHari <= 7)
                                <span class="px-3 py-1 rounded-full bg-red-600 text-white text-sm">{{ $sisaHari }} Hari</span>
                            @else
                                <span class="px-3 py-1 rounded-full bg-yellow-500 text-white text-sm">{{ $sisaHari }} Hari</span>
                            @endif

                        </td>

                    </tr>

                @empty

                    <tr>
                        <td colspan="7" class="py-10 text-center text-gray-500">
                            Tidak ada batch obat yang akan kadaluarsa dalam 30 hari ke depan.
                        </td>
                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

    @if($batches->hasPages())
        <div class="mt-6">{{ $batches->links() }}</div>
    @endif

@endif

{{-- ================= KADALUARSA (SUDAH LEWAT) ================= --}}
@if($tab === 'kadaluarsa')

    <div class="bg-white rounded-xl shadow overflow-hidden">

        <table class="min-w-full">

            <thead class="bg-gray-100">
                <tr>
                    <th class="px-6 py-4 text-left">Nama Obat</th>
                    <th class="px-6 py-4 text-center">Batch</th>
                    <th class="px-6 py-4 text-center">Gudang</th>
                    <th class="px-6 py-4 text-center">Ruangan</th>
                    <th class="px-6 py-4 text-center">Stok Batch</th>
                    <th class="px-6 py-4 text-center">Tanggal Kadaluarsa</th>
                    <th class="px-6 py-4 text-center">Sudah Lewat</th>
                </tr>
            </thead>

            <tbody>

                @forelse($batches as $batch)

                    @php
                        $sudahLewat = now()->diffInDays($batch->tanggal_kadaluarsa);
                    @endphp

                    <tr class="border-t hover:bg-gray-50">

                        <td class="px-6 py-4 font-medium">{{ $batch->obat->nama_obat }}</td>
                        <td class="px-6 py-4 text-center font-mono">{{ $batch->nomor_batch }}</td>
                        <td class="px-6 py-4 text-center">{{ $batch->gudang->nama_gudang }}</td>
                        <td class="px-6 py-4 text-center">{{ $batch->ruangan->nama_ruangan }}</td>
                        <td class="px-6 py-4 text-center font-semibold">{{ $batch->stok }}</td>
                        <td class="px-6 py-4 text-center">{{ \Carbon\Carbon::parse($batch->tanggal_kadaluarsa)->format('d M Y') }}</td>

                        <td class="px-6 py-4 text-center">
                            <span class="px-3 py-1 rounded-full bg-gray-700 text-white text-sm">
                                {{ $sudahLewat }} hari lalu
                            </span>
                        </td>

                    </tr>

                @empty

                    <tr>
                        <td colspan="7" class="py-10 text-center text-gray-500">
                            Tidak ada batch obat yang sudah kadaluarsa.
                        </td>
                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

    @if($batches->hasPages())
        <div class="mt-6">{{ $batches->links() }}</div>
    @endif

@endif

@endsection
