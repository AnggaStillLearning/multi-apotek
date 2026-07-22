<div class="bg-white rounded-xl shadow">

    <div class="flex items-center justify-between p-6 border-b">

        <h2 class="text-xl font-semibold">

            Konversi Satuan

        </h2>

        <button
            type="button"
            onclick="openTambahKonversi()"
            class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg">

            + Tambah Konversi

        </button>

    </div>

    <div class="overflow-x-auto">

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

                                <span class="inline-flex items-center px-3 py-1 rounded-full bg-green-100 text-green-700 text-xs font-semibold">

                                    ✓ Default

                                </span>

                            @else

                                <span class="inline-flex items-center px-3 py-1 rounded-full bg-gray-100 text-gray-500 text-xs">

                                    -

                                </span>

                            @endif

                        </td>

                        <td class="px-6 py-4 text-center">

                            <div class="flex justify-center gap-2">

                                <button
                                    type="button"
                                    onclick="editKonversi({{ $konversi->id }})"
                                    class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded">

                                    Edit

                                </button>

                                <form
                                    action="{{ route('konversi.destroy',$konversi) }}"
                                    method="POST"
                                    onsubmit="return confirm('Yakin ingin menghapus konversi ini?')">

                                    @csrf
                                    @method('DELETE')

                                    <button
                                        type="submit"
                                        class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded">

                                        Hapus

                                    </button>

                                </form>

                            </div>

                        </td>

                    </tr>

                @empty

                    <tr>

                        <td
                            colspan="5"
                            class="text-center py-10 text-gray-500">

                            Belum ada data konversi.

                        </td>

                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>
