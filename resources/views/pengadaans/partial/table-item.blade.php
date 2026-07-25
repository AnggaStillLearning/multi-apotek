<div class="bg-white rounded-xl shadow-sm border p-6">

    <h3 class="text-lg font-semibold mb-4">
        Daftar Item
    </h3>

    <table class="w-full border-collapse">

        <thead>

            <tr class="border-b">

                <th>Obat</th>
                <th>Batch</th>
                <th>Gudang</th>
                <th>Ruangan</th>
                <th>Qty</th>
                <th>Harga</th>
                <th>Subtotal</th>
                <th></th>

            </tr>

        </thead>

        <tbody id="tableItem">

            @forelse($pengadaan->details as $detail)

            <tr>

                <td>{{ $detail->obat->nama_obat }}</td>

                <td>{{ $detail->nomor_batch }}</td>

                <td>{{ $detail->gudang->nama_gudang }}</td>

                <td>{{ $detail->ruangan->nama_ruangan }}</td>

                <td>{{ $detail->qty }}</td>

                <td>
                    Rp {{ number_format($detail->harga_beli,0,',','.') }}
                </td>

                <td>
                    Rp {{ number_format($detail->subtotal,0,',','.') }}
                </td>

                <td>

                    <button
                        class="text-red-600">

                        Hapus

                    </button>

                </td>

            </tr>

            @empty

            <tr>

                <td colspan="8" class="text-center py-8 text-gray-400">

                    Belum ada item

                </td>

            </tr>

            @endforelse

        </tbody>

    </table>

</div>
