@extends('layouts.app')

@section('content')
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Laporan Penjualan</h1>
            <p class="text-gray-500 mt-2">Ringkasan transaksi berdasarkan hak akses pengguna.</p>
        </div>
    </div>

    {{-- Summary --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white rounded-2xl shadow p-6">
            <p class="text-gray-500">Total Transaksi</p>
            <h2 class="text-4xl font-bold text-blue-600 mt-3">{{ $totalTransaksi }}</h2>
        </div>

        <div class="bg-white rounded-2xl shadow p-6">
            <p class="text-gray-500">Total Pendapatan</p>
            <h2 class="text-4xl font-bold text-green-600 mt-3">
                Rp {{ number_format($totalPendapatan, 0, ',', '.') }}
            </h2>
        </div>

        <div class="bg-white rounded-2xl shadow p-6">
            <p class="text-gray-500">Obat Terjual</p>
            <h2 class="text-4xl font-bold text-orange-500 mt-3">{{ $totalObatTerjual }}</h2>
        </div>
    </div>

    {{-- Filter --}}
    <div class="bg-white rounded-2xl shadow p-6 mb-8">
        <form method="GET">
            <div class="grid md:grid-cols-5 gap-5">
                <div>
                    <label class="block mb-2 font-medium">Periode</label>
                    <select
                        name="periode"
                        class="w-full border rounded-xl p-3"
                    >
                        <option value="">Semua</option>
                        <option
                            value="hari_ini"
                            {{ request('periode') == 'hari_ini' ? 'selected' : '' }}
                        >
                            Hari Ini
                        </option>
                        <option
                            value="minggu_ini"
                            {{ request('periode') == 'minggu_ini' ? 'selected' : '' }}
                        >
                            Minggu Ini
                        </option>
                        <option
                            value="bulan_ini"
                            {{ request('periode') == 'bulan_ini' ? 'selected' : '' }}
                        >
                            Bulan Ini
                        </option>
                    </select>
                </div>

                <div>
                    <label class="block mb-2 font-medium">Tanggal Awal</label>
                    <input
                        type="date"
                        name="tanggal_awal"
                        value="{{ request('tanggal_awal') }}"
                        class="w-full border rounded-xl p-3"
                    >
                </div>

                <div>
                    <label class="block mb-2 font-medium">Tanggal Akhir</label>
                    <input
                        type="date"
                        name="tanggal_akhir"
                        value="{{ request('tanggal_akhir') }}"
                        class="w-full border rounded-xl p-3"
                    >
                </div>

                <div class="flex items-end">
                    <button class="w-full bg-blue-600 hover:bg-blue-700 text-white rounded-xl py-3 transition">
                        Filter
                    </button>
                </div>

                <div class="flex items-end">
                    <a
                        href="{{ route('laporan.index') }}"
                        class="w-full bg-gray-200 hover:bg-gray-300 rounded-xl py-3 text-center transition"
                    >
                        Reset
                    </a>
                </div>
            </div>
        </form>
    </div>

    {{-- Tabel --}}
    <div class="bg-white rounded-2xl shadow overflow-hidden">
        <table class="w-full">
            <thead class="bg-blue-600 text-white">
                <tr>
                    <th class="p-4 text-left">ID</th>
                    <th class="p-4 text-left">Tanggal</th>

                    @if(auth()->user()->role == 'super_admin')
                        <th class="p-4 text-left">Apotek</th>
                    @endif

                    @if(auth()->user()->role != 'kasir')
                        <th class="p-4 text-left">Kasir</th>
                    @endif

                    <th class="p-4 text-right">Total</th>
                    <th class="p-4 text-center">Status</th>
                    <th class="p-4 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($laporans as $laporan)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="p-4">#{{ $laporan->id }}</td>
                        <td class="p-4">{{ \Carbon\Carbon::parse($laporan->tanggal)->format('d M Y') }}</td>

                        @if(auth()->user()->role == 'super_admin')
                            <td class="p-4">{{ $laporan->apotek->nama_apotek }}</td>
                        @endif

                        @if(auth()->user()->role != 'kasir')
                            <td class="p-4">{{ $laporan->user->name }}</td>
                        @endif

                        <td class="p-4 text-right font-semibold text-green-600">
                            Rp {{ number_format($laporan->total_harga, 0, ',', '.') }}
                        </td>

                        <td class="p-4 text-center">
                            @if($laporan->status == 'selesai')
                                <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-sm">
                                    Selesai
                                </span>
                            @else
                                <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-sm">
                                    Dibatalkan
                                </span>
                            @endif
                        </td>

                        <td class="p-4 text-center">
                            <a
                                href="{{ route('penjualans.show', $laporan->id) }}"
                                class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-2 rounded-lg transition"
                            >
                                Detail
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center py-8 text-gray-500">
                            Belum ada data laporan.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    <div class="mt-6">
        {{ $laporans->withQueryString()->links() }}
    </div>
@endsection
