@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto">

    {{-- Header --}}
    <div class="flex justify-between items-start mb-8">

        <div>

            <a href="{{ route('obats.index') }}"
                class="text-blue-600 hover:underline">

                ← Kembali

            </a>

            <h1 class="text-3xl font-bold mt-2">

                {{ $obat->nama_obat }}

            </h1>

            <p class="text-gray-500">

                {{ $obat->jenis->nama }}
                •
                {{ $obat->kategori->nama }}

            </p>

        </div>

        <a
            href="{{ route('obats.edit',$obat) }}"
            class="bg-yellow-500 hover:bg-yellow-600 text-white px-5 py-3 rounded-xl">

            ✏ Edit Obat

        </a>

    </div>

    @include('obats.partials.informasi')

    @include('obats.partials.konversi')

    @include('obats.partials.batch')

</div>

@include('obats.partials.modal-batch')

@include('obats.partials.modal-konversi')

@endsection


@push('scripts')

<script>

    /* ===============================
       MODAL BATCH
    =============================== */

    function openBatchModal(){

        const modal=document.getElementById('batchModal');

        modal.classList.remove('hidden');

        modal.classList.add('flex');

    }

    function closeBatchModal(){

        const modal=document.getElementById('batchModal');

        modal.classList.remove('flex');

        modal.classList.add('hidden');

    }


    /* ===============================
       MODAL KONVERSI
    =============================== */

    function openKonversiModal(){

        const modal=document.getElementById('konversiModal');

        modal.classList.remove('hidden');

        modal.classList.add('flex');

    }

    function closeKonversiModal(){

        const modal=document.getElementById('konversiModal');

        modal.classList.remove('flex');

        modal.classList.add('hidden');

    }


    /* ===============================
       TAMBAH KONVERSI
    =============================== */

    function openTambahKonversi(){

        const form=document.getElementById('konversiForm');

        form.reset();

        document.getElementById('rasio_turun').disabled=false;

        form.action="{{ route('konversi.store',$obat) }}";

        document.getElementById('httpMethod').value='POST';

        document.getElementById('konversiTitle').innerHTML='Tambah Konversi';

        openKonversiModal();

    }


    /* ===============================
       EDIT KONVERSI
    =============================== */

    async function editKonversi(id){

        try{

            const response=await fetch(`/konversi/${id}/edit`);

            if(!response.ok){

                throw new Error('Data tidak ditemukan');

            }

            const data=await response.json();

            document.getElementById('konversiForm').action=`/konversi/${id}`;

            document.getElementById('httpMethod').value='PUT';

            document.getElementById('konversiTitle').innerHTML='Edit Konversi';

            document.getElementById('satuan_id').value=data.satuan_id;

            document.getElementById('is_dasar').checked=!data.rasio_turun;

            toggleRasioTurun(!data.rasio_turun);

            document.getElementById('rasio_turun').value=data.rasio_turun ?? '';

            document.getElementById('harga_jual').value=data.harga_jual;

            document.getElementById('is_default').checked=data.is_default;

            openKonversiModal();

        }catch(error){

            console.error(error);

            alert('Gagal mengambil data konversi.');

        }

    }


    /* ===============================
       LOAD RUANGAN
    =============================== */

    document.addEventListener('DOMContentLoaded',function(){

        const gudang=document.getElementById('gudang_id');

        if(!gudang){

            return;

        }

        gudang.addEventListener('change',async function(){

            const ruangan=document.getElementById('ruangan_id');

            if(!this.value){

                ruangan.innerHTML='<option value="">Pilih Gudang Terlebih Dahulu</option>';

                return;

            }

            ruangan.innerHTML='<option>Memuat...</option>';

            try{

                const response=await fetch(`/gudangs/${this.value}/ruangans`);

                const data=await response.json();

                ruangan.innerHTML='<option value="">Pilih Ruangan</option>';

                data.forEach(function(item){

                    ruangan.innerHTML+=`
                        <option value="${item.id}">
                            ${item.nama_ruangan}
                        </option>
                    `;

                });

            }catch(error){

                console.error(error);

                ruangan.innerHTML='<option value="">Gagal memuat ruangan</option>';

            }

        });

    });

</script>

@endpush
