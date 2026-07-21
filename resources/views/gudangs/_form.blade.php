@csrf

@if(auth()->user()->role == 'super_admin')

<div class="mb-5">

    <label class="block text-sm font-medium text-gray-700 mb-2">
        Apotek
    </label>

    <select
        name="apotek_id"
        class="w-full border rounded-lg px-4 py-2">

        <option value="">Pilih Apotek</option>

        @foreach($apoteks as $apotek)

            <option
                value="{{ $apotek->id }}"
                {{ old('apotek_id', $gudang->apotek_id ?? '') == $apotek->id ? 'selected' : '' }}>

                {{ $apotek->nama_apotek }}

            </option>

        @endforeach

    </select>

</div>

@endif

<div class="mb-5">

    <label class="block text-sm font-medium text-gray-700 mb-2">
        Nama Gudang
    </label>

    <input
        type="text"
        name="nama_gudang"
        value="{{ old('nama_gudang', $gudang->nama_gudang ?? '') }}"
        class="w-full border rounded-lg px-4 py-2">

</div>

<div class="mb-5">

    <label class="block text-sm font-medium text-gray-700 mb-2">
        Alamat
    </label>

    <textarea
        name="alamat"
        rows="3"
        class="w-full border rounded-lg px-4 py-2">{{ old('alamat', $gudang->alamat ?? '') }}</textarea>

</div>

<div class="mb-6">

    <label class="block text-sm font-medium text-gray-700 mb-2">
        Keterangan
    </label>

    <textarea
        name="keterangan"
        rows="3"
        class="w-full border rounded-lg px-4 py-2">{{ old('keterangan', $gudang->keterangan ?? '') }}</textarea>

</div>

<div class="flex justify-end gap-3">

    <a
        href="{{ route('gudangs.index') }}"
        class="px-6 py-2 border rounded-lg hover:bg-gray-100">

        Batal

    </a>

    <button
        class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg">

        Simpan

    </button>

</div>
