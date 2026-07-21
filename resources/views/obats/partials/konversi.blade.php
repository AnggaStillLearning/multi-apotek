<div class="bg-white rounded-xl shadow">

    <div class="flex justify-between items-center p-6 border-b">

        <h2 class="text-xl font-semibold">
            Konversi Satuan
        </h2>

        <button
            type="button"
            onclick="openTambahKonversi()"
            class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">

            + Tambah Konversi

        </button>

    </div>

    <table class="min-w-full">

        <thead class="bg-gray-100">

            <tr>

                <th class="px-6 py-4 text-left">
                    Satuan
                </th>

                <th class="px-6 py-4 text-center">
                    Isi
                </th>

                <th class="px-6 py-4 text-right">
                    Harga Jual
                </th>

                <th class="px-6 py-4 text-center">
                    Default
                </th>

                <th class="px-6 py-4 text-center">
                    Aksi
                </th>

            </tr>

        </thead>

        <tbody>

            @forelse($obat->konversis as $konversi)

            <tr class="border-t hover:bg-gray-50">

                <td class="px-6 py-4">

                    {{ $konversi->satuan->nama_satuan }}

                </td>

                <td class="px-6 py-4 text-center">

                    {{ number_format($konversi->isi) }}

                </td>

                <td class="px-6 py-4 text-right">

                    Rp {{ number_format($konversi->harga_jual,0,',','.') }}

                </td>

                <td class="px-6 py-4 text-center">

                    @if($konversi->is_default)

                        <span class="bg-green-600 text-white text-xs px-3 py-1 rounded-full">

                            Default

                        </span>

                    @endif

                </td>

                <td class="px-6 py-4 text-center space-x-2">

                    <button
                        onclick="editKonversi({{ $konversi->id }})"
                        class="bg-yellow-500 text-white px-3 py-1 rounded">

                        Edit

                    </button>

                    <form
                        action="{{ route('konversi.destroy',$konversi) }}"
                        method="POST"
                        class="inline">

                        @csrf
                        @method('DELETE')

                        <button
                            onclick="return confirm('Hapus konversi?')"
                            class="bg-red-600 text-white px-3 py-1 rounded">

                            Hapus

                        </button>

                    </form>

                </td>

            </tr>

            @empty

            <tr>

                <td colspan="5" class="py-8 text-center text-gray-500">

                    Belum ada konversi.

                </td>

            </tr>

            @endforelse

        </tbody>

    </table>

</div>
