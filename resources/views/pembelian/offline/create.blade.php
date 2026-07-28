@extends('layouts.app')

@section('title', 'Pembelian Offline (POS)')

@section('content')
<div class="max-w-4xl">

    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">
            Pembelian Offline (POS)
        </h1>
        <p class="text-sm text-gray-500 mt-1">
            Input transaksi untuk pembeli walk-in. Stok dikurangi otomatis (FEFO) begitu transaksi disimpan.
        </p>
    </div>

    @if(session('error'))
        <div class="mb-4 rounded-lg bg-red-50 border border-red-200 text-red-700 px-4 py-3 text-sm">
            {{ session('error') }}
        </div>
    @endif

    @error('items')
        <div class="mb-4 rounded-lg bg-red-50 border border-red-200 text-red-700 px-4 py-3 text-sm">
            {{ $message }}
        </div>
    @enderror

    {{-- Pencarian obat --}}
    <div class="bg-white rounded-xl shadow-sm border p-6 mb-6 relative">

        <label class="block text-sm font-semibold mb-1">Cari Obat</label>

        <input
            type="text"
            id="cariObat"
            autocomplete="off"
            placeholder="Ketik minimal 2 huruf nama obat..."
            class="w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500">

        <div
            id="hasilCari"
            class="absolute left-6 right-6 mt-1 bg-white border rounded-lg shadow-lg z-20 hidden max-h-72 overflow-y-auto">
        </div>

        <div id="pilihanObat" class="hidden mt-4 grid grid-cols-4 gap-4 items-end">

            <div class="col-span-2">
                <p class="text-sm text-gray-500">Obat dipilih</p>
                <p id="namaObatDipilih" class="font-semibold"></p>
            </div>

            <div>
                <label class="block text-sm font-semibold mb-1">Satuan</label>
                <select id="konversiDipilih" class="w-full rounded-lg border-gray-300"></select>
            </div>

            <div>
                <label class="block text-sm font-semibold mb-1">Jumlah</label>
                <div class="flex gap-2">
                    <input
                        type="number"
                        id="qtyDipilih"
                        value="1"
                        min="1"
                        class="w-full rounded-lg border-gray-300">
                    <button
                        type="button"
                        id="btnTambahItem"
                        class="bg-blue-600 hover:bg-blue-700 text-white px-4 rounded-lg whitespace-nowrap">
                        Tambah
                    </button>
                </div>
            </div>

        </div>

    </div>

    {{-- Form transaksi --}}
    <form id="formTransaksi" action="{{ route('pembelian.offline.store') }}" method="POST">
        @csrf

        <div id="itemsHidden"></div>

        <div class="bg-white rounded-xl shadow-sm border overflow-hidden mb-6">

            <table class="w-full">

                <thead class="bg-gray-50 text-sm text-gray-500">
                    <tr>
                        <th class="p-3 text-left">Obat</th>
                        <th class="p-3 text-center">Satuan</th>
                        <th class="p-3 text-center">Qty</th>
                        <th class="p-3 text-right">Harga</th>
                        <th class="p-3 text-right">Subtotal</th>
                        <th class="p-3 text-center">Aksi</th>
                    </tr>
                </thead>

                <tbody id="tbodyKeranjang">
                    <tr id="rowKosong">
                        <td colspan="6" class="p-6 text-center text-gray-400">
                            Belum ada item. Cari obat di atas untuk menambahkan.
                        </td>
                    </tr>
                </tbody>

                <tfoot>
                    <tr class="bg-gray-50">
                        <th colspan="4" class="text-right p-4">Total</th>
                        <th id="totalKeranjang" class="text-right p-4">Rp 0</th>
                        <th></th>
                    </tr>
                </tfoot>

            </table>

        </div>

        <div class="bg-white rounded-xl shadow-sm border p-6 flex flex-wrap items-end gap-4 justify-between">

            <div>
                <label class="block text-sm font-semibold mb-1">Metode Pembayaran</label>
                <select name="metode_pembayaran" required class="rounded-lg border-gray-300">
                    <option value="Tunai">Tunai</option>
                    <option value="Kartu Debit/Kredit">Kartu Debit/Kredit</option>
                    <option value="QRIS">QRIS</option>
                </select>
            </div>

            <button
                type="submit"
                id="btnSimpanTransaksi"
                disabled
                class="bg-green-600 hover:bg-green-700 disabled:bg-gray-300 disabled:cursor-not-allowed text-white px-8 py-3 rounded-lg font-semibold">
                Simpan Transaksi
            </button>

        </div>

    </form>

</div>

@push('scripts')
<script>
(function () {

    const inputCari = document.getElementById('cariObat');
    const hasilCari = document.getElementById('hasilCari');
    const pilihanObat = document.getElementById('pilihanObat');
    const namaObatDipilih = document.getElementById('namaObatDipilih');
    const konversiDipilih = document.getElementById('konversiDipilih');
    const qtyDipilih = document.getElementById('qtyDipilih');
    const btnTambahItem = document.getElementById('btnTambahItem');
    const tbodyKeranjang = document.getElementById('tbodyKeranjang');
    const totalKeranjang = document.getElementById('totalKeranjang');
    const itemsHidden = document.getElementById('itemsHidden');
    const btnSimpan = document.getElementById('btnSimpanTransaksi');

    let obatTerpilih = null;
    let keranjang = []; // { obat_id, nama_obat, konversi_obat_id, satuan, harga, qty, subtotal }
    let timerCari = null;

    function formatRupiah(angka) {
        return 'Rp ' + Number(angka).toLocaleString('id-ID');
    }

    inputCari.addEventListener('input', function () {

        clearTimeout(timerCari);

        const q = inputCari.value.trim();

        if (q.length < 2) {
            hasilCari.classList.add('hidden');
            hasilCari.innerHTML = '';
            return;
        }

        timerCari = setTimeout(function () {

            fetch('{{ route('api.obats.search') }}?q=' + encodeURIComponent(q))
                .then(res => res.json())
                .then(data => {

                    if (!data.length) {
                        hasilCari.innerHTML = '<div class="p-3 text-sm text-gray-400">Tidak ada obat ditemukan.</div>';
                        hasilCari.classList.remove('hidden');
                        return;
                    }

                    hasilCari.innerHTML = data.map(obat => `
                        <button
                            type="button"
                            data-obat='${JSON.stringify(obat)}'
                            class="block w-full text-left px-4 py-3 hover:bg-gray-50 border-b last:border-b-0">
                            <span class="font-medium">${obat.nama_obat}</span>
                            <span class="block text-xs text-gray-400">Stok: ${obat.stok_text}</span>
                        </button>
                    `).join('');

                    hasilCari.classList.remove('hidden');

                    hasilCari.querySelectorAll('button').forEach(function (btn) {
                        btn.addEventListener('click', function () {
                            pilihObat(JSON.parse(btn.dataset.obat));
                        });
                    });

                });

        }, 300);

    });

    function pilihObat(obat) {

        obatTerpilih = obat;

        namaObatDipilih.textContent = obat.nama_obat;

        konversiDipilih.innerHTML = obat.konversis.map(k => `
            <option value="${k.id}" ${k.is_default ? 'selected' : ''}>
                ${k.nama_satuan} (${formatRupiah(k.harga_jual)})
            </option>
        `).join('');

        qtyDipilih.value = 1;

        pilihanObat.classList.remove('hidden');
        hasilCari.classList.add('hidden');
        inputCari.value = obat.nama_obat;
    }

    btnTambahItem.addEventListener('click', function () {

        if (!obatTerpilih) {
            return;
        }

        const konversiId = konversiDipilih.value;
        const konversi = obatTerpilih.konversis.find(k => String(k.id) === String(konversiId));
        const qty = parseInt(qtyDipilih.value || '1', 10);

        if (!konversi || qty < 1) {
            return;
        }

        // Kalau obat + satuan yang sama sudah ada di keranjang, qty tinggal ditambah.
        const existing = keranjang.find(
            item => item.obat_id === obatTerpilih.id && item.konversi_obat_id === konversi.id
        );

        if (existing) {
            existing.qty += qty;
            existing.subtotal = existing.qty * existing.harga;
        } else {
            keranjang.push({
                obat_id: obatTerpilih.id,
                nama_obat: obatTerpilih.nama_obat,
                konversi_obat_id: konversi.id,
                satuan: konversi.nama_satuan,
                harga: konversi.harga_jual,
                qty: qty,
                subtotal: qty * konversi.harga_jual,
            });
        }

        renderKeranjang();

        obatTerpilih = null;
        pilihanObat.classList.add('hidden');
        inputCari.value = '';

    });

    function hapusItem(index) {
        keranjang.splice(index, 1);
        renderKeranjang();
    }

    function renderKeranjang() {

        if (!keranjang.length) {
            tbodyKeranjang.innerHTML = `
                <tr id="rowKosong">
                    <td colspan="6" class="p-6 text-center text-gray-400">
                        Belum ada item. Cari obat di atas untuk menambahkan.
                    </td>
                </tr>
            `;
        } else {

            tbodyKeranjang.innerHTML = keranjang.map((item, index) => `
                <tr class="border-t">
                    <td class="p-3">${item.nama_obat}</td>
                    <td class="p-3 text-center">${item.satuan}</td>
                    <td class="p-3 text-center">${item.qty}</td>
                    <td class="p-3 text-right">${formatRupiah(item.harga)}</td>
                    <td class="p-3 text-right">${formatRupiah(item.subtotal)}</td>
                    <td class="p-3 text-center">
                        <button
                            type="button"
                            data-index="${index}"
                            class="btnHapusItem text-red-600 hover:underline text-sm">
                            Hapus
                        </button>
                    </td>
                </tr>
            `).join('');

            tbodyKeranjang.querySelectorAll('.btnHapusItem').forEach(function (btn) {
                btn.addEventListener('click', function () {
                    hapusItem(parseInt(btn.dataset.index, 10));
                });
            });

        }

        const total = keranjang.reduce((sum, item) => sum + item.subtotal, 0);
        totalKeranjang.textContent = formatRupiah(total);

        itemsHidden.innerHTML = keranjang.map((item, index) => `
            <input type="hidden" name="items[${index}][obat_id]" value="${item.obat_id}">
            <input type="hidden" name="items[${index}][konversi_obat_id]" value="${item.konversi_obat_id}">
            <input type="hidden" name="items[${index}][qty]" value="${item.qty}">
        `).join('');

        btnSimpan.disabled = keranjang.length === 0;
    }

    document.addEventListener('click', function (e) {
        if (!hasilCari.contains(e.target) && e.target !== inputCari) {
            hasilCari.classList.add('hidden');
        }
    });

})();
</script>
@endpush

@endsection
