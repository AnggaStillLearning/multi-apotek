<div class="grid grid-cols-1 md:grid-cols-2 gap-6">

    {{-- Nama Supplier --}}
    <div class="md:col-span-2">
        <label class="block text-sm font-medium text-gray-700 mb-2">
            Nama Supplier <span class="text-red-500">*</span>
        </label>
        <input
            type="text"
            name="nama_supplier"
            value="{{ old('nama_supplier', $supplier->nama_supplier ?? '') }}"
            class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500"
            required
        >
        @error('nama_supplier')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
        @enderror
    </div>

    {{-- Kontak --}}
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-2">
            Kontak
        </label>
        <input
            type="text"
            name="kontak"
            value="{{ old('kontak', $supplier->kontak ?? '') }}"
            class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500"
        >
        @error('kontak')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
        @enderror
    </div>

    {{-- Email --}}
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-2">
            Email
        </label>
        <input
            type="email"
            name="email"
            value="{{ old('email', $supplier->email ?? '') }}"
            class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500"
        >
        @error('email')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
        @enderror
    </div>

    {{-- Alamat --}}
    <div class="md:col-span-2">
        <label class="block text-sm font-medium text-gray-700 mb-2">
            Alamat
        </label>
        <textarea
            name="alamat"
            rows="3"
            class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500"
        >{{ old('alamat', $supplier->alamat ?? '') }}</textarea>

        @error('alamat')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
        @enderror
    </div>

    {{-- Keterangan --}}
    <div class="md:col-span-2">
        <label class="block text-sm font-medium text-gray-700 mb-2">
            Keterangan
        </label>
        <textarea
            name="keterangan"
            rows="3"
            class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500"
        >{{ old('keterangan', $supplier->keterangan ?? '') }}</textarea>

        @error('keterangan')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
        @enderror
    </div>

    {{-- Status --}}
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-2">
            Status
        </label>

        <select
            name="status"
            class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500"
        >
            <option value="aktif"
                @selected(old('status', $supplier->status ?? 'aktif') == 'aktif')>
                Aktif
            </option>

            <option value="nonaktif"
                @selected(old('status', $supplier->status ?? '') == 'nonaktif')>
                Nonaktif
            </option>
        </select>

        @error('status')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
        @enderror
    </div>

</div>

<div class="mt-8 flex justify-end gap-3">

    <a href="{{ route('suppliers.index') }}"
        class="px-5 py-2 rounded-lg border border-gray-300 hover:bg-gray-100">
        Batal
    </a>

    <button
        type="submit"
        class="px-5 py-2 rounded-lg bg-blue-600 text-white hover:bg-blue-700">
        Simpan
    </button>

</div>
