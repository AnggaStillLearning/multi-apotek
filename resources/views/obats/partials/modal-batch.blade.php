<div
    id="batchModal"
    class="fixed inset-0 bg-black/50 hidden items-center justify-center z-50">

    <div class="bg-white rounded-xl shadow-xl w-full max-w-3xl">

        <div class="flex justify-between items-center border-b px-6 py-4">

            <h2 class="text-xl font-semibold">
                Tambah Batch Obat
            </h2>

            <button
                type="button"
                onclick="closeBatchModal()"
                class="text-gray-500 hover:text-red-600 text-2xl">

                &times;

            </button>

        </div>

        <form
            action="{{ route('batch.store',$obat->id) }}"
            method="POST">

            @csrf

            <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-5">

                {{-- Nomor Batch --}}
                <div>

                    <label class="block text-sm font-medium mb-2">

                        Nomor Batch

                    </label>

                    <input
                        type="text"
                        name="nomor_batch"
                        class="w-full border rounded-lg px-4 py-2"
                        required>

                </div>

                {{-- Gudang --}}
                <div>

                    <label class="block text-sm font-medium mb-2">

                        Gudang

                    </label>

                    <select
                        name="gudang_id"
                        id="gudang_id"
                        class="w-full border rounded-lg px-4 py-2"
                        required>

                        <option value="">Pilih Gudang</option>

                        @foreach($gudangs as $gudang)

                            <option value="{{ $gudang->id }}">

                                {{ $gudang->nama_gudang }}

                            </option>

                        @endforeach

                    </select>

                </div>

                {{-- Ruangan --}}
                <div>

                    <label class="block text-sm font-medium mb-2">

                        Ruangan

                    </label>

                    <select
                        name="ruangan_id"
                        id="ruangan_id"
                        class="w-full border rounded-lg px-4 py-2"
                        required>

                        <option value="">

                            Pilih Gudang Terlebih Dahulu

                        </option>

                    </select>

                </div>

                {{-- Harga Beli --}}
                <div>

                    <label class="block text-sm font-medium mb-2">

                        Harga Beli

                    </label>

                    <input
                        type="number"
                        min="1"
                        name="harga_beli"
                        value="{{ $obat->harga_beli_default }}"
                        class="w-full border rounded-lg px-4 py-2"
                        required>

                </div>

                {{-- Stok --}}
                <div>

                    <label class="block text-sm font-medium mb-2">

                        Jumlah Stok

                    </label>

                    <input
                        type="number"
                        min="1"
                        name="stok"
                        class="w-full border rounded-lg px-4 py-2"
                        required>

                </div>

                {{-- Kadaluarsa --}}
                <div>

                    <label class="block text-sm font-medium mb-2">

                        Tanggal Kadaluarsa

                    </label>

                    <input
                        type="date"
                        name="tanggal_kadaluarsa"
                        class="w-full border rounded-lg px-4 py-2"
                        required>

                </div>

            </div>

            <div class="border-t px-6 py-4 flex justify-end gap-3">

                <button
                    type="button"
                    onclick="closeBatchModal()"
                    class="border px-5 py-2 rounded-lg hover:bg-gray-100">

                    Batal

                </button>

                <button
                    class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-lg">

                    Simpan Batch

                </button>

            </div>

        </form>

    </div>

</div>
