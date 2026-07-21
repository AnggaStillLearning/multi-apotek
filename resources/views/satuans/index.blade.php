@extends('layouts.app')

@section('content')

@if(session('success'))
<div class="mb-5 rounded-lg bg-green-100 border border-green-300 text-green-700 px-4 py-3">
    {{ session('success') }}
</div>
@endif

<div class="flex items-center justify-between mb-6">

    <div>

        <h1 class="text-3xl font-bold text-gray-800">
            Data Ruangan
        </h1>

        <p class="text-gray-500 mt-1">
            Kelola seluruh ruangan penyimpanan obat.
        </p>

    </div>

    <a
        href="{{ route('ruangans.create') }}"
        class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-5 py-3 rounded-xl shadow">

        <svg xmlns="http://www.w3.org/2000/svg"
             class="w-5 h-5"
             fill="none"
             viewBox="0 0 24 24"
             stroke="currentColor">

            <path stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="M12 4v16m8-8H4"/>

        </svg>

        Tambah Ruangan

    </a>

</div>


<div class="bg-white rounded-xl shadow p-5 mb-6">

    <form method="GET">

        <div class="grid md:grid-cols-2 gap-4">

            <div>

                <label class="block text-sm font-medium text-gray-700 mb-2">

                    Cari Ruangan

                </label>

                <input
                    type="text"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Cari nama ruangan..."
                    class="w-full border rounded-lg px-4 py-2">

            </div>

        </div>

        <div class="mt-5 flex justify-end">

            <button
                class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg">

                Filter

            </button>

        </div>

    </form>

</div>


<div class="bg-white rounded-xl shadow overflow-hidden">

<table class="min-w-full">

<thead class="bg-gray-100">

<tr>

<th class="px-5 py-3 text-left">

Nama Ruangan

</th>

<th class="px-5 py-3 text-left">

Gudang

</th>

<th class="px-5 py-3 text-left">

Apotek

</th>

<th class="px-5 py-3 text-left">

Keterangan

</th>

<th class="px-5 py-3 text-center">

Aksi

</th>

</tr>

</thead>

<tbody>

@forelse($ruangans as $ruangan)

<tr class="border-t hover:bg-gray-50">

<td class="px-5 py-3 font-medium">

{{ $ruangan->nama_ruangan }}

</td>

<td class="px-5 py-3">

{{ $ruangan->gudang->nama_gudang }}

</td>

<td class="px-5 py-3">

{{ $ruangan->gudang->apotek->nama_apotek }}

</td>

<td class="px-5 py-3">

{{ $ruangan->keterangan ?? '-' }}

</td>

<td class="px-5 py-3">

<div class="flex justify-center gap-2">

<a
href="{{ route('ruangans.edit',$ruangan->id) }}"
class="inline-flex items-center px-3 py-2 rounded-lg bg-yellow-100 text-yellow-700 hover:bg-yellow-200">

✏️

</a>

<form
action="{{ route('ruangans.destroy',$ruangan->id) }}"
method="POST">

@csrf
@method('DELETE')

<button
onclick="return confirm('Yakin ingin menghapus ruangan ini?')"
class="inline-flex items-center px-3 py-2 rounded-lg bg-red-100 text-red-700 hover:bg-red-200">

🗑️

</button>

</form>

</div>

</td>

</tr>

@empty

<tr>

<td colspan="5" class="text-center py-10 text-gray-500">

Belum ada data ruangan.

</td>

</tr>

@endforelse

</tbody>

</table>

</div>

<div class="mt-6">

{{ $ruangans->links() }}

</div>

@endsection
