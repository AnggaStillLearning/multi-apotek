@extends('layouts.app')

@section('content')

<h1 class="text-3xl font-bold mb-6">
    Tambah Transaksi
</h1>

<div class="bg-white rounded-xl shadow p-6">

@if(session('error'))

<div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
    {{ session('error') }}
</div>

@endif

<form action="{{ route('penjualans.store') }}" method="POST">

    @csrf

    <div id="items">

        <div class="item border rounded-lg p-4 mb-4">

            <div class="grid grid-cols-12 gap-4">

                <div class="col-span-7">

                    <label class="block mb-2">
                        Pilih Obat
                    </label>

                    <select
                        name="nama_obat[]"
                        class="obat w-full border rounded p-2">

                        <option value="">
                            Pilih Obat
                        </option>

                    @foreach($obats as $obat)

                        <option
                            value="{{ $obat->nama_obat }}"
                            data-harga="0">

                            {{ $obat->nama_obat }}

                        </option>

                    @endforeach

                    </select>

                    <small class="stok text-gray-500"></small>

                </div>

                <div class="col-span-3">

                    <label class="block mb-2">
                        Qty
                    </label>

                    <input
                        type="number"
                        name="qty[]"
                        value="1"
                        min="1"
                        class="qty w-full border rounded p-2">

                </div>

                <div class="col-span-2 flex items-end">

                    <button
                        type="button"
                        class="hapus bg-red-600 text-white px-3 py-2 rounded w-full">

                        Hapus

                    </button>

                </div>

            </div>

        </div>

    </div>

    <button
        type="button"
        id="tambah"
        class="bg-blue-600 text-white px-4 py-2 rounded">

        + Tambah Obat

    </button>

    <hr class="my-6">

    <div class="text-right">

        <h2 class="text-2xl font-bold">

            Total :
            <span id="total">
                Rp 0
            </span>

        </h2>

    </div>

    <div class="mt-6">

        <button
            class="bg-green-600 text-white px-6 py-3 rounded">

            Simpan Transaksi

        </button>

    </div>

</form>

</div>

<script>

const items = document.getElementById('items');

/*
|--------------------------------------------------------------------------
| Tambah Item
|--------------------------------------------------------------------------
*/

document.getElementById('tambah').onclick = function(){

    let clone =
    document.querySelector('.item')
    .cloneNode(true);

    clone.querySelector('.obat').selectedIndex = 0;

    clone.querySelector('.qty').value = 1;

    clone.querySelector('.qty').max = '';

    clone.querySelector('.stok').innerHTML = '';

    items.appendChild(clone);

    updateDropdowns();

    hitungTotal();

};

/*
|--------------------------------------------------------------------------
| Hapus Item
|--------------------------------------------------------------------------
*/

document.addEventListener('click', function(e){

    if(e.target.classList.contains('hapus')){

        let totalItem =
        document.querySelectorAll('.item');

        if(totalItem.length > 1){

            e.target.closest('.item').remove();

            updateDropdowns();

            hitungTotal();

        }

    }

});

/*
|--------------------------------------------------------------------------
| Pilih Obat
|--------------------------------------------------------------------------
*/

document.addEventListener('change', async function (e) {

    if (!e.target.classList.contains('obat')) {
        return;
    }

    const namaObat = e.target.value;

    if (namaObat === '') {
        return;
    }

    try {

        const response = await fetch(
            "/obat/info/" + encodeURIComponent(namaObat)
        );

        const data = await response.json();

        const item = e.target.closest('.item');

        item.querySelector('.stok').innerHTML =
            "Stok tersedia : " + data.stok;

        item.querySelector('.qty').max =
            data.stok;

        e.target.selectedOptions[0].dataset.harga =
            data.harga;

        hitungTotal();

        updateDropdowns();

    } catch (error) {

        console.error(error);

    }

});

/*
|--------------------------------------------------------------------------
| Qty
|--------------------------------------------------------------------------
*/

document.addEventListener('input', function(e){

    if(e.target.classList.contains('qty')){

        let max =
        parseInt(e.target.max);

        if(max && parseInt(e.target.value) > max){

            e.target.value = max;

        }

        if(e.target.value < 1){

            e.target.value = 1;

        }

        hitungTotal();

    }

});

/*
|--------------------------------------------------------------------------
| Hitung Total
|--------------------------------------------------------------------------
*/

function hitungTotal(){

    let total = 0;

    document.querySelectorAll('.item').forEach(function(item){

        const select = item.querySelector('.obat');

        const harga = Number(
            select.selectedOptions[0]?.dataset.harga ?? 0
        );

        const qty = Number(
            item.querySelector('.qty').value ?? 0
        );

        total += harga * qty;

    });

    document.getElementById('total').innerHTML =
        'Rp ' + total.toLocaleString('id-ID');

}

/*
|--------------------------------------------------------------------------
| Disable Obat Yang Sudah Dipilih
|--------------------------------------------------------------------------
*/

function updateDropdowns(){

    let selected = [];

    document.querySelectorAll('.obat').forEach(function(select){

        if(select.value !== ''){

            selected.push(select.value);

        }

    });

    document.querySelectorAll('.obat').forEach(function(currentSelect){

        currentSelect.querySelectorAll('option').forEach(function(option){

            if(option.value === ''){

                option.disabled = false;

                return;

            }

            if(
                selected.includes(option.value) &&
                option.value !== currentSelect.value
            ){

                option.disabled = true;

            }else{

                option.disabled = false;

            }

        });

    });

}

/*
|--------------------------------------------------------------------------
| Pertama Kali Halaman Dibuka
|--------------------------------------------------------------------------
*/

updateDropdowns();

hitungTotal();

</script>

@endsection
