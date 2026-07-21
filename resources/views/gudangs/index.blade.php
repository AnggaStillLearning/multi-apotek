@extends('layouts.app')

@section('content')

@if(session('success'))

<div class="mb-5 rounded-lg bg-green-100 border border-green-300 text-green-700 px-4 py-3">
    {{ session('success') }}
</div>

@endif

<div class="flex justify-between items-center mb-6">

    <div>

        <h1 class="text-3xl font-bold text-gray-800">

            Data Gudang

        </h1>

        <p class="text-gray-500 mt-1">

            Kelola seluruh data gudang.

        </p>

    </div>

    <a
        href="{{ route('gudangs.create') }}"
        class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-3 rounded-xl shadow">

        + Tambah Gudang

    </a>

</div>


<div class="bg-white rounded-xl shadow p-5 mb-6">

    <form method="GET">

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

            <div>

                <label class="block text-sm font-medium text-gray-600 mb-2">

                    Cari Gudang

                </label>

                <input
                    type="text"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Nama gudang..."
                    class="w-full border rounded-lg px-4 py-2">

            </div>

        </div>

        <div class="flex justify-end mt-5">

            <button
                class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg">

                Filter

            </button>

        </div>

    </form>

</div>


<div class="bg-white rounded-xl shadow overflow-x-auto">

<table class="min-w-full">

<thead class="bg-gray-100">

<tr>

<th class="px-4 py-3 text-left">

Nama Gudang

</th>

<th class="px-4 py-3 text-left">

Apotek

</th>

<th class="px-4 py-3 text-left">

Alamat

</th>

<th class="px-4 py-3 text-left">

Keterangan

</th>

<th class="px-4 py-3 text-center">

Aksi

</th>

</tr>

</thead>

<tbody>

@forelse($gudangs as $gudang)

<tr class="border-t hover:bg-gray-50">

<td class="px-4 py-3">

{{ $gudang->nama_gudang }}

</td>

<td class="px-4 py-3">

{{ $gudang->apotek->nama_apotek }}

</td>

<td class="px-4 py-3">

{{ $gudang->alamat ?? '-' }}

</td>

<td class="px-4 py-3">

{{ $gudang->keterangan ?? '-' }}

</td>

<td class="px-4 py-3 text-center">

<a
href="{{ route('gudangs.edit',$gudang->id) }}"
class="text-blue-600 hover:underline">

Edit

</a>

|

<form
action="{{ route('gudangs.destroy',$gudang->id) }}"
method="POST"
class="inline">

@csrf

@method('DELETE')

<button
onclick="return confirm('Yakin ingin menghapus gudang ini?')"
class="text-red-600 hover:underline">

Hapus

</button>

</form>

</td>

</tr>

@empty

<tr>

<td colspan="5" class="text-center py-10 text-gray-500">

Belum ada data gudang.

</td>

</tr>

@endforelse

</tbody>

</table>

</div>

<div class="mt-6">

{{ $gudangs->links() }}

</div>

@endsection
