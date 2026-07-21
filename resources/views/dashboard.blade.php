@extends('layouts.app')

@section('content')
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-800">Dashboard</h1>
        <p class="text-gray-500 mt-2">Selamat datang di Sistem Manajemen Multi-Apotek</p>
    </div>

    {{-- Statistik --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-blue-500">
            <p class="text-sm text-gray-500">Total Obat</p>
            <h2 class="text-4xl font-bold text-gray-800 mt-2">{{ $totalObat }}</h2>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-red-500">
            <p class="text-sm text-gray-500">Stok Kritis</p>
            <h2 class="text-4xl font-bold text-red-600 mt-2">{{ $totalStokKritis }}</h2>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-yellow-500">
            <p class="text-sm text-gray-500">Mendekati Kadaluarsa</p>
            <h2 class="text-4xl font-bold text-yellow-600 mt-2">{{ $totalKadaluarsa }}</h2>
        </div>
    </div>

    {{-- Monitoring Cards --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        {{-- Monitoring Stok Kritis --}}
        <div class="bg-white rounded-xl shadow-sm">
            <div class="flex items-center justify-between border-b p-5">
                <h2 class="text-lg font-semibold text-red-600">⚠ Monitoring Stok Kritis</h2>
                <a href="{{ route('monitoring.stok-kritis') }}" class="text-sm text-blue-600 hover:underline">
                    Lihat Semua
                </a>
            </div>
            <div class="p-5">
                @if($stokKritis->count() > 0)
                    <div class="space-y-3">
                        @foreach($stokKritis as $obat)
                            <div class="flex items-center justify-between p-3 bg-red-50 rounded-lg border border-red-200">
                                <div>
                                    <p class="font-medium text-gray-800">{{ $obat->nama_obat }}</p>
                                    <p class="text-sm text-gray-500">
                                        Stok: <span class="font-bold text-red-600">{{ $obat->total_stok }}</span>
                                        (Min: {{ $obat->stok_minimum }})
                                    </p>
                                </div>
                                <span class="text-sm bg-red-200 text-red-700 px-3 py-1 rounded-full">
                                    Kritis
                                </span>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-8">
                        <div class="text-5xl mb-3">✅</div>
                        <p class="text-green-600 font-semibold">Tidak ada stok kritis</p>
                    </div>
                @endif
            </div>
        </div>

        {{-- Monitoring Kadaluarsa --}}
        <div class="bg-white rounded-xl shadow-sm">
            <div class="flex items-center justify-between border-b p-5">
                <h2 class="text-lg font-semibold text-yellow-600">⏳ Monitoring Kadaluarsa</h2>
                <a href="{{ route('monitoring.kadaluarsa') }}" class="text-sm text-blue-600 hover:underline">
                    Lihat Semua
                </a>
            </div>
            <div class="p-5">
                @if($kadaluarsa->count() > 0)
                    <div class="mb-4 p-3 bg-yellow-50 rounded-lg border border-yellow-200">
                        <p class="text-gray-700">
                            Terdapat <strong>{{ $kadaluarsa->count() }}</strong> batch obat yang mendekati tanggal kadaluarsa.
                        </p>
                        <p class="text-sm text-gray-500 mt-1">
                            Segera lakukan pengecekan atau penyesuaian stok.
                        </p>
                    </div>

                    <div class="space-y-3">
                        @foreach($kadaluarsa as $batch)
                            @php
                                $sisaHari = ceil(now()->diffInRealDays($batch->tanggal_kadaluarsa, false));
                            @endphp
                            <div class="flex items-center justify-between p-3 bg-yellow-50 rounded-lg border border-yellow-200">
                                <div>
                                    <p class="font-medium text-gray-800">{{ $batch->obat->nama_obat ?? 'Obat' }}</p>
                                    <p class="text-sm text-gray-500">
                                        Batch: <span class="font-mono">#{{ $batch->nomor_batch }}</span>
                                    </p>
                                </div>
                                <div class="text-right">
                                    <span class="text-sm font-semibold text-yellow-700">
                                        {{ $sisaHari }} Hari Lagi
                                    </span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-8">
                        <div class="text-5xl mb-3">✅</div>
                        <p class="text-green-600 font-semibold">Tidak ada obat yang mendekati kadaluarsa</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
