@extends('layouts.app')

@section('title', 'Tambah Pengadaan')

@section('content')
<div class="space-y-6 max-w-2xl">

    <div>
        <h1 class="text-2xl font-bold text-gray-800">
            Tambah Pengadaan
        </h1>

        <p class="text-sm text-gray-500 mt-1">
            Buat transaksi pengadaan baru, item obat ditambahkan pada langkah berikutnya.
        </p>
    </div>

    <div class="bg-white rounded-xl shadow-sm border p-6">

        <form method="POST" action="{{ route('pengadaans.store') }}" class="space-y-5">
            @csrf

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Supplier
                </label>

                <select
                    name="supplier_id"
                    class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500">

                    <option value="">Pilih Supplier</option>

                    @foreach($suppliers as $supplier)
                        <option value="{{ $supplier->id }}" @selected(old('supplier_id') == $supplier->id)>
                            {{ $supplier->nama_supplier }}
                        </option>
                    @endforeach

                </select>

                @error('supplier_id')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Tanggal Pengadaan
                </label>

                <input
                    type="date"
                    name="tanggal_pengadaan"
                    value="{{ old('tanggal_pengadaan', date('Y-m-d')) }}"
                    class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500">

                @error('tanggal_pengadaan')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Keterangan
                </label>

                <textarea
                    name="keterangan"
                    rows="3"
                    class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500">{{ old('keterangan') }}</textarea>

                @error('keterangan')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex gap-3 pt-2">

                <button
                    type="submit"
                    class="px-6 py-3 rounded-lg bg-blue-600 hover:bg-blue-700 text-white font-medium">

                    Simpan & Lanjutkan

                </button>

                <a href="{{ route('pengadaans.index') }}"
                   class="px-6 py-3 rounded-lg bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium">

                    Batal

                </a>

            </div>

        </form>

    </div>

</div>
@endsection
