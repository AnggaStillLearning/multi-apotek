@if(session('success'))
    <div class="rounded-lg bg-green-100 border border-green-300 text-green-700 px-4 py-3">
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="rounded-lg bg-red-100 border border-red-300 text-red-700 px-4 py-3">
        {{ session('error') }}
    </div>
@endif

<div class="bg-white rounded-xl shadow-sm border p-6">

    <div class="flex items-center justify-between">

        <div>
            <a href="{{ route('pengadaans.index') }}" class="text-sm text-blue-600 hover:underline">
                &larr; Kembali ke Daftar Pengadaan
            </a>

            <h2 class="text-2xl font-bold mt-1">
                Pengadaan Barang
            </h2>

            <p class="text-gray-500 mt-1">
                Nomor :
                <strong>{{ $pengadaan->nomor_pengadaan }}</strong>
            </p>
        </div>

        <div class="flex items-center gap-3">

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

            @if($pengadaan->status == 'draft')
                <form method="POST"
                      action="{{ route('pengadaans.selesaikan', $pengadaan) }}"
                      onsubmit="return confirm('Selesaikan pengadaan ini? Stok obat akan langsung diperbarui dan data tidak bisa diubah lagi.');">
                    @csrf

                    <button
                        type="submit"
                        class="px-4 py-2 rounded-lg bg-green-600 hover:bg-green-700 text-white font-medium">

                        Selesaikan Pengadaan

                    </button>
                </form>
            @endif

        </div>

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
