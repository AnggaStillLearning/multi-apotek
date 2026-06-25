@extends('layouts.app')

@section('content')

<div class="flex justify-between mb-6">

    <h1 class="text-3xl font-bold">
        Data Apotek
    </h1>

    <a href="{{ route('apoteks.create') }}"
       class="bg-blue-600 text-white px-4 py-2 rounded">

        Tambah Apotek

    </a>

</div>

@if(session('success'))

<div class="bg-green-100 text-green-700 p-3 rounded mb-4">
    {{ session('success') }}
</div>

@endif

<table class="w-full bg-white rounded shadow">

    <thead class="bg-gray-100">

        <tr>
            <th class="p-3">Nama Apotek</th>
            <th class="p-3">Alamat</th>
            <th class="p-3">Aksi</th>
        </tr>

    </thead>

    <tbody>

        @foreach($apoteks as $apotek)

        <tr class="border-t">

            <td class="p-3">
                {{ $apotek->nama_apotek }}
            </td>

            <td class="p-3">
                {{ $apotek->alamat }}
            </td>

            <td class="p-3 flex gap-2">

                <a href="{{ route('apoteks.edit',$apotek->id) }}"
                   class="text-blue-600">

                    Edit

                </a>

                <form method="POST"
                      action="{{ route('apoteks.destroy',$apotek->id) }}">

                    @csrf
                    @method('DELETE')

                    <button
                        class="text-red-600">

                        Hapus

                    </button>

                </form>

            </td>

        </tr>

        @endforeach

    </tbody>

</table>

@endsection
