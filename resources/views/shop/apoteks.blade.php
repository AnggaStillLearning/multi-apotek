@extends('layouts.shop')

@section('content')

<div class="container mx-auto py-8">

    <h1 class="text-3xl font-bold mb-8">
        Pilih Apotek
    </h1>

    <div class="grid md:grid-cols-3 gap-6">

        @forelse($apoteks as $apotek)

            <div class="bg-white rounded-xl shadow p-6">

                <h2 class="text-xl font-semibold">
                    {{ $apotek->nama_apotek }}
                </h2>

                <p class="text-gray-600 mt-2">
                    {{ $apotek->alamat }}
                </p>

                <a
                    href="{{ route('shop.katalog', $apotek) }}"
                    class="mt-5 inline-block bg-blue-600 text-white px-5 py-2 rounded-lg"
                >
                    Belanja
                </a>

            </div>

        @empty

            <p>Belum ada apotek.</p>

        @endforelse

    </div>

</div>

@endsection
