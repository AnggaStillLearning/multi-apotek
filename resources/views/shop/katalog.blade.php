@extends('layouts.shop')

@section('content')

<div class="container mx-auto py-8">

    <div class="mb-6">

        <a href="{{ route('shop.apoteks') }}" class="text-blue-600 hover:underline text-sm">
            &larr; Pilih Apotek Lain
        </a>

        <h1 class="text-3xl font-bold mt-2">
            {{ $apotek->nama_apotek }}
        </h1>

        <p class="text-gray-500">
            {{ $apotek->alamat }}
        </p>

    </div>

    @if($obats->count())

        <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-6">

            @foreach($obats as $obat)

                @php
                    $konversiDefault = $obat->konversis->firstWhere('is_default', true)
                        ?? $obat->konversis->first();
                @endphp

                <div class="bg-white rounded-xl shadow p-5">

                    <h2 class="text-xl font-semibold">
                        {{ $obat->nama_obat }}
                    </h2>

                    <p class="text-gray-500 mt-2">
                        {{ $obat->kategori->nama ?? '-' }}
                    </p>

                    <p class="text-gray-500">
                        {{ $obat->jenis->nama ?? '-' }}
                    </p>

                    <p class="text-green-600 font-bold text-lg mt-3">
                        @if($konversiDefault)
                            Rp {{ number_format($konversiDefault->harga_jual, 0, ',', '.') }}
                            / {{ $konversiDefault->satuan->nama_satuan }}
                        @else
                            Harga belum tersedia
                        @endif
                    </p>

                    <p class="text-sm text-gray-500">
                        Stok: {{ $obat->breakdownStokText() }}
                    </p>

                    <a
                        href="{{ route('shop.show', [$apotek, $obat]) }}"
                        class="block text-center mt-5 bg-blue-600 hover:bg-blue-700 text-white py-2 rounded-lg">

                        Detail

                    </a>

                </div>

            @endforeach

        </div>

        <div class="mt-8">

            {{ $obats->links() }}

        </div>

    @else

        <div class="bg-white rounded-xl shadow p-6 text-center">

            Tidak ada obat tersedia di apotek ini.

        </div>

    @endif

</div>

@endsection
