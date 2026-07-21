<div
    id="konversiModal"
    class="fixed inset-0 bg-black/50 hidden items-center justify-center z-50">

    <div class="bg-white rounded-xl shadow-xl w-full max-w-lg">

        <form
            id="konversiForm"
            method="POST"
            action="{{ route('konversi.store',$obat) }}">

            @csrf

            <input
                type="hidden"
                id="methodField"
                name="_method"
                value="POST">

            <div class="flex justify-between items-center p-6 border-b">

                <h2
                    id="konversiTitle"
                    class="text-xl font-bold">

                    Tambah Konversi

                </h2>

                <button
                    type="button"
                    onclick="closeKonversiModal()">

                    ✕

                </button>

            </div>

            <div class="p-6 space-y-5">

                <div>

                    <label class="block mb-2 font-medium">

                        Satuan

                    </label>

                    <select
                        id="satuan_id"
                        name="satuan_id"
                        class="w-full border rounded-lg p-3"
                        required>

                        <option value="">
                            Pilih Satuan
                        </option>

                        @foreach($satuans as $satuan)

                            <option value="{{ $satuan->id }}">

                                {{ $satuan->nama_satuan }}

                            </option>

                        @endforeach

                    </select>

                </div>

                <div>

                    <label class="block mb-2 font-medium">

                        Isi

                    </label>

                    <input
                        type="number"
                        id="isi"
                        name="isi"
                        min="1"
                        class="w-full border rounded-lg p-3"
                        required>

                </div>

                <div>

                    <label class="block mb-2 font-medium">

                        Harga Jual

                    </label>

                    <input
                        type="number"
                        id="harga_jual"
                        name="harga_jual"
                        step="0.01"
                        class="w-full border rounded-lg p-3"
                        required>

                </div>

                <div class="flex items-center gap-3">

                    <input
                        type="checkbox"
                        id="is_default"
                        name="is_default"
                        value="1">

                    <label for="is_default">

                        Jadikan Default

                    </label>

                </div>

            </div>

            <div class="flex justify-end gap-3 p-6 border-t">

                <button
                    type="button"
                    onclick="closeKonversiModal()"
                    class="px-4 py-2 rounded-lg bg-gray-300">

                    Batal

                </button>

                <button
                    class="px-4 py-2 rounded-lg bg-blue-600 text-white">

                    Simpan

                </button>

            </div>

        </form>

    </div>

</div>
