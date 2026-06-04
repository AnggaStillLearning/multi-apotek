@extends('layouts.app')

@section('content')

@if(session('success'))

<div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
    {{ session('success') }}
</div>
@endif

<div class="flex justify-between items-center mb-6">

<h1 class="text-2xl font-bold">
    Data Obat
</h1>

<a href="{{ route('obats.create') }}"
   class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">

    Tambah Obat

</a>

</div>

<div class="bg-white shadow rounded-lg overflow-hidden">

<table class="w-full">

    <thead>
        <tr class="bg-gray-100">

            <th class="p-3 text-left">
                Nama Obat
            </th>

            <th class="p-3 text-left">
                Stok
            </th>

            <th class="p-3 text-left">
                Kadaluarsa
            </th>

            <th class="p-3 text-center">
                Aksi
            </th>

        </tr>
    </thead>

    <tbody>

        @forelse($obats as $obat)

        <tr class="border-t">

            <td class="p-3">
                {{ $obat->nama_obat }}
            </td>

            <td class="p-3">
                {{ $obat->stok }}
            </td>

            <td class="p-3">
                {{ $obat->tanggal_kadaluarsa }}
            </td>

            <td class="p-3 text-center">

                <a href="{{ route('obats.edit', $obat->id) }}"
                   class="text-blue-600 hover:text-blue-800 mr-3">

                    Edit

                </a>

                <form action="{{ route('obats.destroy', $obat->id) }}"
                      method="POST"
                      class="inline">

                    @csrf
                    @method('DELETE')

                    <button
                        type="submit"
                        onclick="return confirm('Yakin ingin menghapus obat ini?')"
                        class="text-red-600 hover:text-red-800">

                        Hapus

                    </button>

                </form>

            </td>

        </tr>

        @empty

        <tr>
            <td colspan="4" class="text-center p-6 text-gray-500">
                Belum ada data obat
            </td>
        </tr>

        @endforelse

    </tbody>

</table>

</div>

@endsection
