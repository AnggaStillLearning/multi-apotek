@extends('layouts.app')

@section('content')

<h1 class="text-3xl font-bold mb-6">
    Tambah Admin Apotek
</h1>

<div class="bg-white p-6 rounded-xl shadow">

    @if ($errors->any())

        <div class="mb-5 rounded-lg bg-red-100 border border-red-400 text-red-700 p-4">

            <ul class="list-disc ml-5">

                @foreach ($errors->all() as $error)

                    <li>{{ $error }}</li>

                @endforeach

            </ul>

        </div>

    @endif

    <form method="POST"
          action="{{ route('users.store') }}">

        @csrf

        <div class="mb-4">

            <label class="block font-medium mb-2">
                Nama Admin
            </label>

            <input
                type="text"
                name="name"
                value="{{ old('name') }}"
                class="w-full border rounded p-2">

        </div>

        <div class="mb-4">

            <label class="block font-medium mb-2">
                Email
            </label>

            <input
                type="email"
                name="email"
                value="{{ old('email') }}"
                class="w-full border rounded p-2">

        </div>

        <div class="mb-4">

            <label class="block font-medium mb-2">
                Password
            </label>

            <input
                type="password"
                name="password"
                class="w-full border rounded p-2">

        </div>

        <div class="mb-4">

            <label class="block font-medium mb-2">
                Role
            </label>

            <select
                name="role"
                class="w-full border rounded p-2">

                <option value="">Pilih Role</option>

                <option value="admin_apotek">

                    Admin Apotek

                </option>

                <option value="kasir">

                    Kasir

                </option>

            </select>


        </div>

        <div class="mb-6">

            <label class="block font-medium mb-2">
                Pilih Apotek
            </label>

            <select
                id="apotek_id"
                name="apotek_id"
                class="w-full border rounded p-2"
                required>

                <option value="">
                    -- Pilih Apotek --
                </option>

                @foreach($apoteks as $apotek)

                    <option
                        value="{{ $apotek->id }}"
                        {{ old('apotek_id') == $apotek->id ? 'selected' : '' }}>

                        {{ $apotek->nama_apotek }}

                    </option>

                @endforeach

            </select>

            @error('apotek_id')

                <p class="text-red-500 text-sm mt-2">

                    {{ $message }}

                </p>

            @enderror

        </div>

        <div class="flex gap-3">

            <button
                type="submit"
                class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-lg">

                Simpan

            </button>

            <a
                href="{{ route('users.index') }}"
                class="bg-gray-500 hover:bg-gray-600 text-white px-5 py-2 rounded-lg">

                Batal

            </a>

        </div>

    </form>

</div>

@endsection
