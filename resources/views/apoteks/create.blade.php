@extends('layouts.app')

@section('content')

<h1 class="text-3xl font-bold mb-6">
    Tambah Apotek
</h1>

<div class="bg-white p-6 rounded-xl shadow">

    <form method="POST"
          action="{{ route('apoteks.store') }}">

        @csrf

        <div class="mb-4">

            <label class="block mb-2">
                Nama Apotek
            </label>

            <input
                type="text"
                name="nama_apotek"
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
                required></textarea>

        </div>

        <button
            class="bg-blue-600 text-white px-4 py-2 rounded">

            Simpan

        </button>

    </form>

</div>

@endsection
