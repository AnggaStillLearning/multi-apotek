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
            Data Obat
        </h1>

        <p class="text-gray-500 mt-1">
            Kelola seluruh data obat pada apotek.
        </p>

    </div>

    <a
        href="{{ route('obats.create') }}"
        class="bg-blue-600 hover:bg-blue-700 transition text-white px-5 py-3 rounded-xl shadow">

        + Tambah Obat

    </a>

</div>

{{-- Card Filter --}}

<div class="bg-white rounded-xl shadow p-5 mb-6">

    <form method="GET">

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4">

            {{-- Cari Obat --}}
            <div>

                <label class="block text-sm font-medium text-gray-600 mb-2">
                    Cari Obat
                </label>

                <input
                    type="text"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Nama obat..."
                    class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500">

            </div>

            {{-- Jenis --}}
            <div>

                <label class="block text-sm font-medium text-gray-600 mb-2">
                    Jenis
                </label>

                <select
                    name="jenis"
                    class="w-full border rounded-lg px-4 py-2">

                    <option value="">
                        Semua Jenis
                    </option>

                    @foreach($jenisObats as $jenis)

                    <option
                        value="{{ $jenis->id }}"
                        {{ request('jenis') == $jenis->id ? 'selected' : '' }}>

                        {{ $jenis->nama }}

                    </option>

                    @endforeach

                </select>

            </div>

            {{-- Kategori --}}
            <div>

                <label class="block text-sm font-medium text-gray-600 mb-2">
                    Kategori
                </label>

                <select
                    name="kategori"
                    class="w-full border rounded-lg px-4 py-2">

                    <option value="">
                        Semua Kategori
                    </option>

                    @foreach($kategoris as $kategori)

                    <option
                        value="{{ $kategori->id }}"
                        {{ request('kategori') == $kategori->id ? 'selected' : '' }}>

                        {{ $kategori->nama }}

                    </option>

                    @endforeach

                </select>

            </div>

            {{-- Stok --}}
            <div>

                <label class="block text-sm font-medium text-gray-600 mb-2">
                    Stok
                </label>

                <select
                    name="stok"
                    class="w-full border rounded-lg px-4 py-2">

                    <option value="">
                        Semua Stok
                    </option>

                    <option
                        value="kritis"
                        {{ request('stok') == 'kritis' ? 'selected' : '' }}>

                        Stok Kritis

                    </option>

                </select>

            </div>

            {{-- Kadaluarsa --}}
            <div>

                <label class="block text-sm font-medium text-gray-600 mb-2">
                    Kadaluarsa
                </label>

                <select
                    name="expired"
                    class="w-full border rounded-lg px-4 py-2">

                    <option value="">
                        Semua

                    </option>

                    <option
                        value="1"
                        {{ request('expired') == '1' ? 'selected' : '' }}>

                        ≤ 30 Hari

                    </option>

                </select>

            </div>

        </div>

        <div class="flex justify-end gap-3 mt-5">

            <a
                href="{{ route('obats.index') }}"
                class="px-5 py-2 rounded-lg border hover:bg-gray-100">

                Reset

            </a>

            <button
                type="submit"
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
                Nama Obat
            </th>

            <th class="px-4 py-3 text-left">
                Jenis
            </th>

            <th class="px-4 py-3 text-left">
                Kategori
            </th>

            <th class="px-4 py-3 text-left">
                Batch
            </th>

            <th class="px-4 py-3 text-right">
                Harga
            </th>

            <th class="px-4 py-3 text-center">
                Stok
            </th>

            <th class="px-4 py-3 text-center">
                Kadaluarsa
            </th>

            <th class="px-4 py-3 text-center">
                Status
            </th>

            <th class="px-4 py-3 text-center">
                Aksi
            </th>

        </tr>

    </thead>

    <tbody>

    @forelse($obats as $obat)

        <tr class="border-t hover:bg-gray-50">

            <td class="px-4 py-3 font-medium">

                {{ $obat->nama_obat }}

            </td>

            <td class="px-4 py-3">

                {{ $obat->jenisObat->nama }}

            </td>

            <td class="px-4 py-3">

                {{ $obat->kategori->nama }}

            </td>

            <td class="px-4 py-3">

                {{ $obat->batch }}

            </td>

            <td class="px-4 py-3 text-right">

                Rp {{ number_format($obat->harga_jual,0,',','.') }}

            </td>

            <td class="px-4 py-3 text-center">

                {{ $obat->stok }}

            </td>

            <td class="px-4 py-3 text-center">

                {{ \Carbon\Carbon::parse($obat->tanggal_kadaluarsa)->format('d M Y') }}

            </td>

            <td class="px-4 py-3 text-center">

                @if($obat->stok <= $obat->stok_minimum)

                    <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-sm">

                        Stok Kritis

                    </span>

                @else

                    <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-sm">

                        Aman

                    </span>

                @endif

            </td>

            <td class="px-4 py-3 text-center">

                <a
                    href="{{ route('obats.edit',$obat->id) }}"
                    class="text-blue-600 hover:underline">

                    Edit

                </a>

                |

                <form
                    action="{{ route('obats.destroy',$obat->id) }}"
                    method="POST"
                    class="inline">

                    @csrf
                    @method('DELETE')

                    <button
                        onclick="return confirm('Yakin ingin menghapus obat ini?')"
                        class="text-red-600 hover:underline">

                        Hapus

                    </button>

                </form>

            </td>

        </tr>

    @empty

        <tr>

            <td colspan="9" class="text-center py-10 text-gray-500">

                Belum ada data obat.

            </td>

        </tr>

    @endforelse

    </tbody>

</table>

</div>

<div class="mt-6">

    {{ $obats->links() }}

</div>

@endsection
