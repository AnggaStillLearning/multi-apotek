@csrf

<div class="grid grid-cols-1 md:grid-cols-2 gap-6">

    {{-- Nama Obat --}}
    <div>

        <label class="block text-sm font-medium text-gray-700 mb-2">
            Nama Obat
        </label>

        <input
            type="text"
            name="nama_obat"
            value="{{ old('nama_obat', $obat->nama_obat ?? '') }}"
            class="w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500"
            required>

    </div>

    {{-- Jenis --}}
    <div>

        <label class="block text-sm font-medium text-gray-700 mb-2">
            Jenis Obat
        </label>

        <select
            name="jenis_obat_id"
            class="w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500"
            required>

            <option value="">Pilih Jenis</option>

            @foreach($jenisObats as $jenis)

                <option
                    value="{{ $jenis->id }}"
                    {{ old('jenis_obat_id', $obat->jenis_obat_id ?? '') == $jenis->id ? 'selected' : '' }}>

                    {{ $jenis->nama }}

                </option>

            @endforeach

        </select>

    </div>

    {{-- Kategori --}}
    <div>

        <label class="block text-sm font-medium text-gray-700 mb-2">
            Kategori
        </label>

        <select
            name="kategori_id"
            class="w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500"
            required>

            <option value="">Pilih Kategori</option>

            @foreach($kategoris as $kategori)

                <option
                    value="{{ $kategori->id }}"
                    {{ old('kategori_id', $obat->kategori_id ?? '') == $kategori->id ? 'selected' : '' }}>

                    {{ $kategori->nama }}

                </option>

            @endforeach

        </select>

    </div>

    {{-- Harga Beli --}}
    <div>

        <label class="block text-sm font-medium text-gray-700 mb-2">
            Harga Beli Default
        </label>

        <input
            type="number"
            name="harga_beli_default"
            min="0"
            step="0.01"
            value="{{ old('harga_beli_default', $obat->harga_beli_default ?? 0) }}"
            class="w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500"
            required>

    </div>

    {{-- Stok Minimum --}}
    <div>

        <label class="block text-sm font-medium text-gray-700 mb-2">
            Stok Minimum
        </label>

        <input
            type="number"
            name="stok_minimum"
            min="0"
            value="{{ old('stok_minimum', $obat->stok_minimum ?? 10) }}"
            class="w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500"
            required>

    </div>

    {{-- Tipe Produk --}}
    <div>

        <label class="block text-sm font-medium text-gray-700 mb-2">
            Tipe Produk
        </label>

        <select
            name="tipe_produk"
            class="w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500"
            required>

            <option value="obat" {{ old('tipe_produk', $obat->tipe_produk ?? 'obat') == 'obat' ? 'selected' : '' }}>
                Obat
            </option>

            <option value="alat_kesehatan" {{ old('tipe_produk', $obat->tipe_produk ?? '') == 'alat_kesehatan' ? 'selected' : '' }}>
                Alat Kesehatan
            </option>

        </select>

        <p class="text-xs text-gray-500 mt-1">
            Alat kesehatan boleh tidak punya tanggal kadaluarsa saat pengadaan.
        </p>

    </div>

    {{-- Satuan Dasar --}}
    <div>

        <label class="block text-sm font-medium text-gray-700 mb-2">
            Satuan Dasar
        </label>

        @if($satuanDasarTerkunci ?? false)

            <select
                disabled
                class="w-full rounded-lg border-gray-300 bg-gray-100 text-gray-500">

                <option>{{ $obat->satuanDasar->nama_satuan }}</option>

            </select>

            <input type="hidden" name="satuan_dasar_id" value="{{ $obat->satuan_dasar_id }}">

            <p class="text-xs text-gray-500 mt-1">
                Tidak bisa diubah karena obat ini sudah punya konversi satuan atau batch stok.
            </p>

        @else

            <select
                name="satuan_dasar_id"
                class="w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500"
                required>

                <option value="">Pilih Satuan Dasar</option>

                @foreach($satuans as $satuan)

                    <option
                        value="{{ $satuan->id }}"
                        {{ old('satuan_dasar_id', $obat->satuan_dasar_id ?? '') == $satuan->id ? 'selected' : '' }}>

                        {{ $satuan->nama_satuan }}

                    </option>

                @endforeach

            </select>

            <p class="text-xs text-gray-500 mt-1">
                Satuan terkecil obat ini (mis. Tablet, Botol, Pcs). Semua konversi satuan lain dihitung relatif ke sini — pilih dengan hati-hati, karena akan terkunci setelah ada konversi/batch.
            </p>

        @endif

    </div>

</div>

{{-- Deskripsi --}}
<div class="mt-6">

    <label class="block text-sm font-medium text-gray-700 mb-2">
        Deskripsi
    </label>

    <textarea
        name="deskripsi"
        rows="4"
        class="w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500">{{ old('deskripsi', $obat->deskripsi ?? '') }}</textarea>

</div>

<div class="flex justify-end gap-3 mt-8">

    <a
        href="{{ route('obats.index') }}"
        class="px-5 py-2 border rounded-lg hover:bg-gray-100">

        Batal

    </a>

    <button
        type="submit"
        class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg">

        Simpan

    </button>

</div>
