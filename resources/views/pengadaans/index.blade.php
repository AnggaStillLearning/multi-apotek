@extends('layouts.app')

@section('title', 'Pengadaan Barang')

@section('content')
<div class="space-y-6">

    @if(session('success'))
        <div class="rounded-lg bg-green-100 border border-green-300 text-green-700 px-4 py-3">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="rounded-lg bg-red-100 border border-red-300 text-red-700 px-4 py-3">
            {{ session('error') }}
        </div>
    @endif

    {{-- Header --}}
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">

        <div>
            <h1 class="text-2xl font-bold text-gray-800">
                Pengadaan Barang
            </h1>

            <p class="text-sm text-gray-500 mt-1">
                Kelola transaksi pengadaan obat dari supplier.
            </p>
        </div>

        <a href="{{ route('pengadaans.create') }}"
           class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg shadow">

            + Tambah Pengadaan

        </a>

    </div>

    {{-- Search --}}
    <div class="bg-white rounded-xl shadow-sm border p-4">

        <form method="GET">

            <div class="flex gap-3">

                <input
                    type="text"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Cari nomor pengadaan atau supplier..."
                    class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500">

                <button
                    class="px-5 rounded-lg bg-gray-800 text-white hover:bg-gray-900">

                    Cari

                </button>

            </div>

        </form>

    </div>

    {{-- Table --}}
    <div class="bg-white rounded-xl shadow-sm border overflow-hidden">

        <table class="min-w-full">

            <thead class="bg-gray-100">

                <tr>
                    <th class="px-6 py-3 text-left">No</th>
                    <th class="px-6 py-3 text-left">Nomor Pengadaan</th>
                    <th class="px-6 py-3 text-left">Supplier</th>
                    <th class="px-6 py-3 text-left">Tanggal</th>
                    <th class="px-6 py-3 text-right">Total</th>
                    <th class="px-6 py-3 text-center">Status</th>
                    <th class="px-6 py-3 text-center">Aksi</th>
                </tr>

            </thead>

            <tbody>

                @forelse($pengadaans as $pengadaan)

                <tr class="border-t hover:bg-gray-50">

                    <td class="px-6 py-4">
                        {{ $loop->iteration + ($pengadaans->firstItem() ?? 0) - 1 }}
                    </td>

                    <td class="px-6 py-4 font-medium">
                        {{ $pengadaan->nomor_pengadaan }}
                    </td>

                    <td class="px-6 py-4">
                        {{ $pengadaan->supplier->nama_supplier }}
                    </td>

                    <td class="px-6 py-4">
                        {{ \Carbon\Carbon::parse($pengadaan->tanggal_pengadaan)->format('d M Y') }}
                    </td>

                    <td class="px-6 py-4 text-right">
                        Rp {{ number_format($pengadaan->grand_total, 0, ',', '.') }}
                    </td>

                    <td class="px-6 py-4 text-center">
                        <span class="px-3 py-1 rounded-full text-xs font-semibold
                            @if($pengadaan->status == 'draft')
                                bg-yellow-100 text-yellow-700
                            @elseif($pengadaan->status == 'selesai')
                                bg-green-100 text-green-700
                            @else
                                bg-red-100 text-red-700
                            @endif">
                            {{ ucfirst($pengadaan->status) }}
                        </span>
                    </td>

                    <td class="px-6 py-4 text-center">
                        <a href="{{ route('pengadaans.show', $pengadaan) }}"
                           class="text-blue-600 hover:underline">
                            Detail
                        </a>
                    </td>

                </tr>

                @empty

                <tr>
                    <td colspan="7" class="text-center py-10 text-gray-400">
                        Belum ada data pengadaan.
                    </td>
                </tr>

                @endforelse

            </tbody>

        </table>

    </div>

    <div>
        {{ $pengadaans->links() }}
    </div>

</div>
@endsection
