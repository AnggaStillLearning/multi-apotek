<div class="bg-white rounded-xl shadow-sm border p-6">

    <h3 class="text-lg font-semibold mb-5">
        Tambah Item
    </h3>

    <form id="formItem">

        <div class="grid grid-cols-4 gap-4">

            <div class="col-span-2">

                <label>Obat</label>

                <select
                    id="obat"
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
                    class="w-full rounded-lg border">

                    <option>

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
                    class="w-full rounded-lg border">

                    <option>

                        Pilih Ruangan

                    </option>

                </select>

            </div>

            <div>

                <label>No Batch</label>

                <input
                    class="w-full rounded-lg border">

            </div>

            <div>

                <label>Kadaluarsa</label>

                <input
                    type="date"
                    class="w-full rounded-lg border">

            </div>

            <div>

                <label>Qty</label>

                <input
                    type="number"
                    class="w-full rounded-lg border">

            </div>

            <div>

                <label>Harga Beli</label>

                <input
                    type="number"
                    class="w-full rounded-lg border">

            </div>

        </div>

        <div class="mt-6">

            <button
                class="bg-blue-600 text-white px-6 py-3 rounded-lg">

                Tambah Item

            </button>

        </div>

    </form>

</div>
