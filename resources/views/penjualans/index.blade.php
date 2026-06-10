@extends('layouts.app')

@section('content')

<div class="flex justify-between items-center mb-6">

```
<h1 class="text-3xl font-bold">
    Transaksi Penjualan
</h1>

<a href="{{ route('penjualans.create') }}"
   class="bg-blue-600 text-white px-4 py-2 rounded-lg">

    Tambah Transaksi

</a>
```

</div>

@if(session('success'))

<div class="bg-green-100 border border-green-400
            text-green-700 px-4 py-3 rounded mb-4">

```
{{ session('success') }}
```

</div>

@endif

<div class="bg-white rounded-xl shadow overflow-hidden">

<table class="w-full">

    <thead class="bg-gray-100">

        <tr>

            <th class="p-4 text-left">
                No
            </th>

            <th class="p-4 text-left">
                Tanggal
            </th>

            <th class="p-4 text-left">
                Total
            </th>

            <th class="p-4 text-left">
                Aksi
            </th>

        </tr>

    </thead>

    <tbody>

        @forelse($penjualans as $penjualan)

        <tr class="border-t">

            <td class="p-4">
                {{ $loop->iteration }}
            </td>

            <td class="p-4">
                {{ $penjualan->tanggal }}
            </td>

            <td class="p-4">
                Rp {{ number_format($penjualan->total_harga,0,',','.') }}
            </td>

            <td class="p-4">

                <a href="{{ route('penjualans.show', $penjualan->id) }}"
                   class="bg-blue-500 hover:bg-blue-600
                          text-white px-3 py-1 rounded">

                    Detail

                </a>

            </td>

        </tr>

        @empty

        <tr>

            <td colspan="4"
                class="text-center p-6 text-gray-500">

                Belum ada transaksi

            </td>

        </tr>

        @endforelse

    </tbody>

</table>

</div>

@endsection
