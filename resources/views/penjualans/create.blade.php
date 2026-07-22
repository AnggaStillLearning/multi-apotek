@extends('layouts.app')

@section('content')

<div class="container">

    <h2 class="mb-4">Penjualan POS</h2>

    {{-- Notifikasi --}}
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    {{-- Pencarian --}}
    <form method="GET" action="{{ route('penjualans.create') }}" class="mb-4">

        <input
            type="text"
            name="search"
            class="form-control"
            placeholder="Cari obat..."
            value="{{ request('search') }}">

    </form>

    <div class="card">

        <div class="card-header">
            Daftar Obat
        </div>

        <div class="card-body p-0">

            <table class="table table-bordered mb-0">

                <thead>

                    <tr>

                        <th>Nama Obat</th>

                        <th width="220">Konversi</th>

                        <th width="100">Qty</th>

                        <th width="120">Aksi</th>

                    </tr>

                </thead>

                <tbody>

                @forelse($obats as $obat)

                    <tr>

                        <form
                            action="{{ route('penjualans.cart') }}"
                            method="POST">

                            @csrf

                            <td>

                                {{ $obat->nama_obat }}

                                <input
                                    type="hidden"
                                    name="obat_id"
                                    value="{{ $obat->id }}">

                            </td>

                            <td>

                                <select
                                    name="konversi_id"
                                    class="form-control"
                                    required>

                                    @foreach($obat->konversis as $konversi)

                                        <option
                                            value="{{ $konversi->id }}">

                                            {{ $konversi->satuan->nama_satuan }}
                                            -
                                            Rp {{ number_format($konversi->harga_jual,0,',','.') }}

                                        </option>

                                    @endforeach

                                </select>

                            </td>

                            <td>

                                <input
                                    type="number"
                                    name="qty"
                                    min="1"
                                    value="1"
                                    class="form-control">

                            </td>

                            <td>

                                <button
                                    class="btn btn-primary btn-sm">

                                    Tambah

                                </button>

                            </td>

                        </form>

                    </tr>

                @empty

                    <tr>

                        <td colspan="4">

                            Tidak ada data obat.

                        </td>

                    </tr>

                @endforelse

                </tbody>

            </table>

        </div>

    </div>

    <div class="mt-3">

        {{ $obats->links() }}

    </div>

    <hr class="my-5">

    <h4>Keranjang</h4>

    <table class="table table-bordered">

        <thead>

        <tr>

            <th>Obat</th>

            <th>Satuan</th>

            <th>Qty</th>

            <th>Harga</th>

            <th>Subtotal</th>

            <th></th>

        </tr>

        </thead>

        <tbody>

        @php

            $total = 0;

        @endphp

        @forelse($cart as $index => $item)

            @php

                $total += $item['subtotal'];

            @endphp

            <tr>

                <td>{{ $item['nama_obat'] }}</td>

                <td>{{ $item['satuan'] }}</td>

                <td>

<form
    action="{{ route('penjualans.cart.update',$index) }}"
    method="POST"
    class="d-flex">

    @csrf
    @method('PUT')

    <input
        type="number"
        name="qty"
        value="{{ $item['qty'] }}"
        min="1"
        class="form-control form-control-sm me-2"
        style="width:80px;">

    <button
        class="btn btn-warning btn-sm">

        Update

    </button>

</form>

</td>

                <td>
                    Rp {{ number_format($item['harga_jual'],0,',','.') }}
                </td>

                <td>
                    Rp {{ number_format($item['subtotal'],0,',','.') }}
                </td>

                <td>

                    <form
                        action="{{ route('penjualans.cart.remove',$index) }}"
                        method="POST">

                        @csrf
                        @method('DELETE')

                        <button
                            class="btn btn-danger btn-sm">

                            Hapus

                        </button>

                    </form>

                </td>

            </tr>

        @empty

            <tr>

                <td colspan="6">

                    Keranjang masih kosong.

                </td>

            </tr>

        @endforelse

        </tbody>

    </table>

    <div class="text-end">

        <h4>

            Total :
            Rp {{ number_format($total,0,',','.') }}

        </h4>

    </div>

    <div class="mt-3">

        <form action="{{ route('penjualans.checkout') }}" method="POST">

    @csrf

    <button type="submit" class="btn btn-danger">
        TEST CHECKOUT
    </button>

</form>

    </div>

</div>

@endsection
