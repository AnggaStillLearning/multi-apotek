@extends('layouts.app')

@section('title', 'Pengadaan Barang')

@section('content')
<div class="space-y-6">

    @include('pengadaans.partials.header')

    @include('pengadaans.partials.form-item')

    @include('pengadaans.partials.table-item')

</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {

    const obat = document.getElementById('obat');
    const konversi = document.getElementById('konversi');
    const gudang = document.getElementById('gudang');
    const ruangan = document.getElementById('ruangan');

    if (obat && konversi) {
        obat.addEventListener('change', async function () {

            konversi.innerHTML =
                '<option value="">Memuat...</option>';

            if (!this.value) {

                konversi.innerHTML =
                    '<option value="">Pilih Konversi</option>';

                return;
            }

            const response = await fetch(
                `/api/obats/${this.value}/konversi`
            );

            const data = await response.json();

            konversi.innerHTML =
                '<option value="">Pilih Konversi</option>';

            data.forEach(item => {

                konversi.innerHTML += `
                    <option value="${item.id}">
                        ${item.satuan.nama_satuan}
                    </option>
                `;

            });

        });
    }

    if (gudang && ruangan) {
        gudang.addEventListener('change', async function () {

            ruangan.innerHTML =
                '<option value="">Memuat...</option>';

            if (!this.value) {

                ruangan.innerHTML =
                    '<option value="">Pilih Ruangan</option>';

                return;
            }

            const response = await fetch(
                `/api/gudangs/${this.value}/ruangans`
            );

            const data = await response.json();

            ruangan.innerHTML =
                '<option value="">Pilih Ruangan</option>';

            data.forEach(item => {

                ruangan.innerHTML += `
                    <option value="${item.id}">
                        ${item.nama_ruangan}
                    </option>
                `;

            });

        });
    }

});
</script>
@endpush
