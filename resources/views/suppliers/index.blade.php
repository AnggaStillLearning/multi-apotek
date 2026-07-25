@extends('layouts.app')

@section('content')

<div class="space-y-6">

    {{-- Header --}}
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">

        <div>
            <h1 class="text-2xl font-bold text-gray-800">
                Data Supplier
            </h1>

            <p class="text-sm text-gray-500 mt-1">
                Kelola data supplier untuk kebutuhan pengadaan obat dan alat kesehatan.
            </p>
        </div>

        <a href="{{ route('suppliers.create') }}"
           class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg shadow">

            + Tambah Supplier

        </a>

    </div>

    {{-- Search --}}
    <div class="bg-white rounded-xl shadow-sm border p-4">

        <form method="GET">

            <div class="flex gap-3">

                <input
                    type="text"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Cari supplier..."
                    class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500">

                <button
                    class="px-5 rounded-lg bg-gray-800 text-white hover:bg-gray-900">

                    Cari

                </button>

            </div>

        </form>

    </div>

    {{-- Table --}}
    <div class="bg-white rounded-xl shadow-sm border overflow-hidden">

        <table class="min-w-full">

            <thead class="bg-gray-100">

                <tr>

                    <th class="px-6 py-3 text-left">No</th>

                    <th class="px-6 py-3 text-left">
                        Nama Supplier
                    </th>

                    <th class="px-6 py-3 text-left">
                        Kontak
                    </th>

                    <th class="px-6 py-3 text-left">
                        Email
                    </th>

                    <th class="px-6 py-3 text-center">
                        Status
                    </th>

                    <th class="px-6 py-3 text-center">
                        Aksi
                    </th>

                </tr>

            </thead>

            <tbody>

                @forelse($suppliers as $supplier)

                <tr class="border-t hover:bg-gray-50">

                    <td class="px-6 py-4">

                        {{ $loop->iteration + ($suppliers->firstItem() ?? 0) - 1 }}

                    </td>

                    <td class="px-6 py-4 font-medium">

                        {{ $supplier->nama_supplier }}

                    </td>

                    <td class="px-6 py-4">

                        {{ $supplier->kontak ?: '-' }}

                    </td>

                    <td class="px-6 py-4">

                        {{ $supplier->email ?: '-' }}

                    </td>

                    <td class="px-6 py-4 text-center">

                        @if($supplier->status == 'aktif')

                            <span class="px-3 py-1 rounded-full bg-green-100 text-green-700 text-sm">

                                Aktif

                            </span>

                        @else

                            <span class="px-3 py-1 rounded-full bg-red-100 text-red-700 text-sm">

                                Nonaktif

                            </span>

                        @endif

                    </td>

                    <td class="px-6 py-4">

                        <div class="flex justify-center gap-2">

                            <a href="{{ route('suppliers.edit',$supplier) }}"
                               class="px-3 py-1 rounded bg-yellow-500 text-white hover:bg-yellow-600">

                                Edit

                            </a>

                            <form
                                action="{{ route('suppliers.destroy',$supplier) }}"
                                method="POST"
                                onsubmit="return confirm('Hapus supplier ini?')">

                                @csrf
                                @method('DELETE')

                                <button
                                    class="px-3 py-1 rounded bg-red-600 text-white hover:bg-red-700">

                                    Hapus

                                </button>

                            </form>

                        </div>

                    </td>

                </tr>

                @empty

                <tr>

                    <td colspan="6"
                        class="py-10 text-center text-gray-500">

                        Belum ada data supplier.

                    </td>

                </tr>

                @endforelse

            </tbody>

        </table>

    </div>

    <div>

        {{ $suppliers->links() }}

    </div>

</div>

@endsection
