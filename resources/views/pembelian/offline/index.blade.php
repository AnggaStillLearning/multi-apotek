@extends('layouts.app')

@section('title', 'Pembelian Offline (POS)')

@section('content')
<div class="space-y-6">

    <div class="flex items-center justify-between flex-wrap gap-4">

        <div>
            <h1 class="text-2xl font-bold text-gray-800">
                Pembelian Offline (POS)
            </h1>
            <p class="text-sm text-gray-500 mt-1">
                Riwayat transaksi walk-in yang diinput langsung oleh kasir.
            </p>
        </div>

        <a
            href="{{ route('pembelian.offline.create') }}"
            class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 rounded-lg font-medium">
            + Transaksi Baru
        </a>

    </div>

    @if(session('success'))
        <div class="rounded-lg bg-green-50 border border-green-200 text-green-700 px-4 py-3 text-sm">
            {{ session('success') }}
        </div>
    @endif

    <form method="GET" class="max-w-sm">
        <input
            type="text"
            name="search"
            value="{{ request('search') }}"
            placeholder="Cari nomor pembelian..."
            class="w-full rounded-lg border-gray-300 text-sm">
    </form>

    <div class="bg-white rounded-xl shadow-sm border overflow-hidden">

        <table class="w-full text-sm">

            <thead class="bg-gray-50 text-gray-500">
                <tr>
                    <th class="p-3 text-left">Nomor</th>
                    <th class="p-3 text-left">Tanggal</th>
                    <th class="p-3 text-left">Kasir</th>
                    <th class="p-3 text-left">Metode</th>
                    <th class="p-3 text-right">Total</th>
                    <th class="p-3 text-center">Aksi</th>
                </tr>
            </thead>

            <tbody>

                @forelse($pembelians as $pembelian)

                    <tr class="border-t hover:bg-gray-50">
                        <td class="p-3 font-medium">{{ $pembelian->nomor_pembelian }}</td>
                        <td class="p-3">{{ \Carbon\Carbon::parse($pembelian->tanggal_pembelian)->format('d M Y H:i') }}</td>
                        <td class="p-3">{{ $pembelian->kasir->name ?? '-' }}</td>
                        <td class="p-3">{{ $pembelian->metode_pembayaran }}</td>
                        <td class="p-3 text-right">Rp {{ number_format($pembelian->grand_total, 0, ',', '.') }}</td>
                        <td class="p-3 text-center">
                            <a href="{{ route('pembelian.offline.show', $pembelian) }}" class="text-blue-600 hover:underline">
                                Detail
                            </a>
                        </td>
                    </tr>

                @empty

                    <tr>
                        <td colspan="6" class="p-6 text-center text-gray-400">
                            Belum ada transaksi offline.
                        </td>
                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

    <div>
        {{ $pembelians->links() }}
    </div>

</div>
@endsection
