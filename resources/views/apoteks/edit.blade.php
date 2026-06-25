@extends('layouts.app')

@section('content')

<h1 class="text-3xl font-bold mb-6">
    Edit Apotek
</h1>

<div class="bg-white p-6 rounded-xl shadow">

    <form method="POST"
          action="{{ route('apoteks.update',$apotek->id) }}">

        @csrf
        @method('PUT')

        <div class="mb-4">

            <label class="block mb-2">
                Nama Apotek
            </label>

            <input
                type="text"
                name="nama_apotek"
                value="{{ $apotek->nama_apotek }}"
                class="w-full border rounded p-2"
                required>

        </div>

        <div class="mb-4">

            <label class="block mb-2">
                Alamat
            </label>

            <textarea
                name="alamat"
                rows="4"
                class="w-full border rounded p-2"
                required>{{ $apotek->alamat }}</textarea>

        </div>

        <button
            class="bg-yellow-500 text-white px-4 py-2 rounded">

            Update

        </button>

    </form>

</div>

@endsection
