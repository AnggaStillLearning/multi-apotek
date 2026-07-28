<div class="bg-white rounded-xl shadow p-6 mb-6">

    <h2 class="text-xl font-semibold mb-5">

        Informasi Obat

    </h2>

    <div class="grid md:grid-cols-2 gap-6">

        <div>

            <label class="text-gray-500">
                Nama Obat
            </label>

            <p class="font-semibold">
                {{ $obat->nama_obat }}
            </p>

        </div>

        <div>

            <label class="text-gray-500">
                Jenis
            </label>

            <p class="font-semibold">
                {{ $obat->jenis->nama }}
            </p>

        </div>

        <div>

            <label class="text-gray-500">
                Kategori
            </label>

            <p class="font-semibold">
                {{ $obat->kategori->nama }}
            </p>

        </div>

        <div>

            <label class="text-gray-500">
                Tipe Produk
            </label>

            <p class="font-semibold">
                {{ $obat->tipe_produk == 'alat_kesehatan' ? 'Alat Kesehatan' : 'Obat' }}
            </p>

        </div>

        <div>

            <label class="text-gray-500">
                Satuan Dasar
            </label>

            <p class="font-semibold">
                {{ $obat->satuanDasar->nama_satuan ?? '-' }}
            </p>

        </div>

        <div>

            <label class="text-gray-500">
                Harga Beli Default
            </label>

            <p class="font-semibold">
                Rp {{ number_format($obat->harga_beli_default,0,',','.') }}
            </p>

        </div>

        <div>

            <label class="text-gray-500">
                Stok Minimum
            </label>

            <p class="font-semibold">
                {{ $obat->stok_minimum }}
            </p>

        </div>

        <div>

            <label class="text-gray-500">
                Total Stok
            </label>

            <p class="font-bold text-blue-600">
                {{ $obat->total_stok }}
            </p>

            <p class="text-xs text-gray-500 mt-1">
                {{ $obat->breakdownStokText() }}
            </p>

        </div>

    </div>

</div>
