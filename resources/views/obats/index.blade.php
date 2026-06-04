@extends('layouts.app')

@section('content')

<div class="flex justify-between mb-6">

    <h1 class="text-2xl font-bold">
        Data Obat
    </h1>

    <a href="{{ route('obats.create') }}"
       class="bg-blue-600 text-white px-4 py-2 rounded">

        Tambah Obat

    </a>

</div>

<table class="w-full bg-white shadow rounded">

    <thead>
        <tr class="bg-gray-100">
            <th class="p-3">Nama</th>
            <th class="p-3">Stok</th>
            <th class="p-3">Kadaluarsa</th>
            <th class="p-3">Aksi</th>
        </tr>
    </thead>

    <tbody>

        @forelse($obats as $obat)

        <tr>

            <td class="p-3">
                {{ $obat->nama_obat }}
            </td>

            <td class="p-3">
                {{ $obat->stok }}
            </td>

            <td class="p-3">
                {{ $obat->tanggal_kadaluarsa }}
            </td>

            <td class="p-3">

                <a href="{{ route('obats.edit',$obat->id) }}"
                   class="text-blue-600">

                    Edit

                </a>

            </td>

        </tr>

        @empty

        <tr>
            <td colspan="4" class="text-center p-5">
                Belum ada data obat
            </td>
        </tr>

        @endforelse

    </tbody>

</table>

@endsection
