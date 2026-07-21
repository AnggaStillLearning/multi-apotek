@csrf

<div class="mb-5">

    <label class="block text-sm font-medium text-gray-700 mb-2">

        Gudang

    </label>

    <select
        name="gudang_id"
        class="w-full border rounded-lg px-4 py-2">

        <option value="">Pilih Gudang</option>

        @foreach($gudangs as $gudang)

            <option
                value="{{ $gudang->id }}"
                {{ old('gudang_id',$ruangan->gudang_id ?? '') == $gudang->id ? 'selected' : '' }}>

                {{ $gudang->nama_gudang }}

            </option>

        @endforeach

    </select>

</div>

<div class="mb-5">

    <label class="block text-sm font-medium text-gray-700 mb-2">

        Nama Ruangan

    </label>

    <input
        type="text"
        name="nama_ruangan"
        value="{{ old('nama_ruangan',$ruangan->nama_ruangan ?? '') }}"
        class="w-full border rounded-lg px-4 py-2">

</div>

<div class="mb-6">

    <label class="block text-sm font-medium text-gray-700 mb-2">

        Keterangan

    </label>

    <textarea
        rows="3"
        name="keterangan"
        class="w-full border rounded-lg px-4 py-2">{{ old('keterangan',$ruangan->keterangan ?? '') }}</textarea>

</div>

<div class="flex justify-end gap-3">

    <a
        href="{{ route('ruangans.index') }}"
        class="px-6 py-2 border rounded-lg hover:bg-gray-100">

        Batal

    </a>

    <button
        class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg">

        Simpan

    </button>

</div>
