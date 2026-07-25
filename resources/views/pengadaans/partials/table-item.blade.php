<div class="bg-white rounded-xl shadow-sm border p-6">

    <h3 class="text-lg font-semibold mb-4">
        Daftar Item
    </h3>

    <table class="w-full border-collapse">

        <thead>

            <tr class="border-b">

                <th class="text-left py-2">Obat</th>
                <th class="text-left py-2">Batch</th>
                <th class="text-left py-2">Gudang</th>
                <th class="text-left py-2">Ruangan</th>
                <th class="text-right py-2">Qty</th>
                <th class="text-right py-2">Harga</th>
                <th class="text-right py-2">Subtotal</th>
                @if($pengadaan->status == 'draft')
                    <th></th>
                @endif

            </tr>

        </thead>

        <tbody id="tableItem">

            @forelse($pengadaan->details as $detail)

            <tr class="border-b">

                <td class="py-2">{{ $detail->obat->nama_obat }}</td>

                <td class="py-2">{{ $detail->nomor_batch }}</td>

                <td class="py-2">{{ $detail->gudang->nama_gudang }}</td>

                <td class="py-2">{{ $detail->ruangan->nama_ruangan }}</td>

                <td class="py-2 text-right">{{ $detail->qty }}</td>

                <td class="py-2 text-right">
                    Rp {{ number_format($detail->harga_beli,0,',','.') }}
                </td>

                <td class="py-2 text-right">
                    Rp {{ number_format($detail->subtotal,0,',','.') }}
                </td>

                @if($pengadaan->status == 'draft')
                <td class="py-2 text-center">

                    <form
                        method="POST"
                        action="{{ route('pengadaans.items.destroy', $detail) }}"
                        onsubmit="return confirm('Hapus item ini?');">
                        @csrf
                        @method('DELETE')

                        <button type="submit" class="text-red-600 hover:underline">
                            Hapus
                        </button>
                    </form>

                </td>
                @endif

            </tr>

            @empty

            <tr>

                <td colspan="8" class="text-center py-8 text-gray-400">

                    Belum ada item

                </td>

            </tr>

            @endforelse

        </tbody>

        @if($pengadaan->details->count() > 0)
        <tfoot>
            <tr class="border-t font-semibold">
                <td colspan="6" class="py-3 text-right">Grand Total</td>
                <td class="py-3 text-right">
                    Rp {{ number_format($pengadaan->grand_total,0,',','.') }}
                </td>
                @if($pengadaan->status == 'draft')
                    <td></td>
                @endif
            </tr>
        </tfoot>
        @endif

    </table>

</div>
