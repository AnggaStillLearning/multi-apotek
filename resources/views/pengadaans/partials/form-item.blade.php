@if($pengadaan->status == 'draft')
<div class="bg-white rounded-xl shadow-sm border p-6">

    <h3 class="text-lg font-semibold mb-5">
        Tambah Item
    </h3>

    <form
        id="formItem"
        method="POST"
        action="{{ route('pengadaans.items.store', $pengadaan) }}">
        @csrf

        <div class="grid grid-cols-4 gap-4">

            <div class="col-span-2">

                <label>Obat</label>

                <select
                    id="obat"
                    name="obat_id"
                    required
                    class="w-full rounded-lg border">

                    <option value="">
                        Pilih Obat
                    </option>

                    @foreach($obats as $obat)

                        <option value="{{ $obat->id }}">

                            {{ $obat->nama_obat }}

                        </option>

                    @endforeach

                </select>

            </div>

            <div>

                <label>Konversi</label>

                <select
                    id="konversi"
                    name="konversi_obat_id"
                    required
                    class="w-full rounded-lg border">

                    <option value="">
                        Pilih Konversi
                    </option>

                </select>

            </div>

            <div>

                <label>Gudang</label>

                <select
                    id="gudang"
                    name="gudang_id"
                    required
                    class="w-full rounded-lg border">

                    <option value="">
                        Pilih Gudang
                    </option>

                    @foreach($gudangs as $gudang)

                        <option value="{{ $gudang->id }}">

                            {{ $gudang->nama_gudang }}

                        </option>

                    @endforeach

                </select>

            </div>

            <div>

                <label>Ruangan</label>

                <select
                    id="ruangan"
                    name="ruangan_id"
                    required
                    class="w-full rounded-lg border">

                    <option value="">
                        Pilih Ruangan
                    </option>

                </select>

            </div>

            <div>

                <label>No Batch</label>

                <input
                    type="text"
                    name="nomor_batch"
                    required
                    class="w-full rounded-lg border">

            </div>

            <div>

                <label>Kadaluarsa</label>

                <input
                    type="date"
                    name="tanggal_kadaluarsa"
                    class="w-full rounded-lg border">

            </div>

            <div>

                <label>Qty</label>

                <input
                    type="number"
                    name="qty"
                    min="1"
                    required
                    class="w-full rounded-lg border">

            </div>

            <div>

                <label>Harga Beli</label>

                <input
                    type="number"
                    name="harga_beli"
                    min="0"
                    step="0.01"
                    required
                    class="w-full rounded-lg border">

            </div>

        </div>

        <div class="mt-6">

            <button
                type="submit"
                class="bg-blue-600 text-white px-6 py-3 rounded-lg">

                Tambah Item

            </button>

        </div>

    </form>

</div>
@endif
