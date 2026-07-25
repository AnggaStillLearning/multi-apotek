<div class="bg-white rounded-xl shadow-sm border p-6">

    <div class="flex items-center justify-between">

        <div>
            <h2 class="text-2xl font-bold">
                Pengadaan Barang
            </h2>

            <p class="text-gray-500 mt-1">
                Nomor :
                <strong>{{ $pengadaan->nomor_pengadaan }}</strong>
            </p>
        </div>

        <span class="px-4 py-2 rounded-full
            @if($pengadaan->status=='draft')
                bg-yellow-100 text-yellow-700
            @elseif($pengadaan->status=='selesai')
                bg-green-100 text-green-700
            @else
                bg-red-100 text-red-700
            @endif">

            {{ ucfirst($pengadaan->status) }}

        </span>

    </div>

    <div class="grid grid-cols-3 gap-5 mt-6">

        <div>

            <label class="text-gray-500 text-sm">
                Supplier
            </label>

            <div class="font-semibold">

                {{ $pengadaan->supplier->nama_supplier }}

            </div>

        </div>

        <div>

            <label class="text-gray-500 text-sm">
                Tanggal
            </label>

            <div class="font-semibold">

                {{ $pengadaan->tanggal_pengadaan }}

            </div>

        </div>

        <div>

            <label class="text-gray-500 text-sm">
                Total
            </label>

            <div class="font-bold text-xl text-blue-600">

                Rp {{ number_format($pengadaan->grand_total,0,',','.') }}

            </div>

        </div>

    </div>

</div>
