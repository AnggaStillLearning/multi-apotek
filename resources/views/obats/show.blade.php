@extends('layouts.app')

@section('content')
    <div class="max-w-7xl mx-auto">
        {{-- Header --}}
        <div class="flex justify-between items-start mb-8">
            <div>
                <a href="{{ route('obats.index') }}" class="text-blue-600 hover:underline">← Kembali</a>
                <h1 class="text-3xl font-bold mt-2">{{ $obat->nama_obat }}</h1>
                <p class="text-gray-500">{{ $obat->jenis->nama }} • {{ $obat->kategori->nama }}</p>
            </div>
            <a href="{{ route('obats.edit',$obat->id) }}" class="bg-yellow-500 hover:bg-yellow-600 text-white px-5 py-3 rounded-xl">✏ Edit Obat</a>
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
        // ===== FUNGSI MODAL BATCH =====
        function openBatchModal() {
            const modal = document.getElementById('batchModal');
            if (modal) {
                modal.classList.remove('hidden');
                modal.classList.add('flex');
            }
        }

        function closeBatchModal() {
            const modal = document.getElementById('batchModal');
            if (modal) {
                modal.classList.remove('flex');
                modal.classList.add('hidden');
            }
        }

        // ===== FUNGSI MODAL KONVERSI =====
        function openKonversiModal() {
            const modal = document.getElementById('konversiModal');
            if (modal) {
                modal.classList.remove('hidden');
                modal.classList.add('flex');
            }
        }

        function closeKonversiModal() {
            const modal = document.getElementById('konversiModal');
            if (modal) {
                modal.classList.remove('flex');
                modal.classList.add('hidden');
            }
        }

        // ===== FUNGSI TAMBAH KONVERSI =====
        function openTambahKonversi() {
            document.getElementById('konversiTitle').innerHTML = 'Tambah Konversi';
            document.getElementById('konversiForm').action = "{{ route('konversi.store', $obat) }}";
            document.getElementById('methodField').value = 'POST';
            document.getElementById('konversiForm').reset();

            // Reset checkbox is_default ke false
            document.getElementById('is_default').checked = false;

            openKonversiModal();
        }

        // ===== FUNGSI EDIT KONVERSI =====
        async function editKonversi(id) {
            try {
                const response = await fetch('/konversi/' + id + '/edit');

                if (!response.ok) {
                    throw new Error('Gagal mengambil data konversi');
                }

                const data = await response.json();

                document.getElementById('konversiTitle').innerHTML = 'Edit Konversi';
                document.getElementById('konversiForm').action = '/konversi/' + id;
                document.getElementById('methodField').value = 'PUT';
                document.getElementById('satuan_id').value = data.satuan_id;
                document.getElementById('isi').value = data.isi;
                document.getElementById('harga_jual').value = data.harga_jual;
                document.getElementById('is_default').checked = data.is_default == 1;

                openKonversiModal();
            } catch (error) {
                console.error('Error:', error);
                alert('Gagal memuat data konversi');
            }
        }

        // ===== EVENT LISTENER: Gudang → Ruangan (Batch) =====
        document.addEventListener('DOMContentLoaded', function() {
            const gudangSelect = document.getElementById('gudang_id');

            if (gudangSelect) {
                gudangSelect.addEventListener('change', async function() {
                    const gudangId = this.value;
                    const ruanganSelect = document.getElementById('ruangan_id');

                    if (!ruanganSelect) {
                        console.warn('Element #ruangan_id tidak ditemukan');
                        return;
                    }

                    // Reset jika tidak ada gudang yang dipilih
                    if (!gudangId) {
                        ruanganSelect.innerHTML = '<option value="">Pilih Gudang Terlebih Dahulu</option>';
                        return;
                    }

                    // Tampilkan loading
                    ruanganSelect.innerHTML = '<option>Memuat...</option>';

                    try {
                        const response = await fetch(`/gudangs/${gudangId}/ruangans`);

                        if (!response.ok) {
                            throw new Error('Gagal mengambil data ruangan');
                        }

                        const data = await response.json();

                        // Reset options
                        ruanganSelect.innerHTML = '<option value="">Pilih Ruangan</option>';

                        // Tambahkan data ruangan
                        data.forEach(function(item) {
                            const option = document.createElement('option');
                            option.value = item.id;
                            option.textContent = item.nama_ruangan;
                            ruanganSelect.appendChild(option);
                        });

                    } catch (error) {
                        console.error('Error:', error);
                        ruanganSelect.innerHTML = '<option value="">Gagal memuat ruangan</option>';
                    }
                });
            }

            // ===== EVENT LISTENER: Gudang → Ruangan (Konversi) =====
            const gudangKonversiSelect = document.getElementById('gudang_konversi_id');

            if (gudangKonversiSelect) {
                gudangKonversiSelect.addEventListener('change', async function() {
                    const gudangId = this.value;
                    const ruanganKonversiSelect = document.getElementById('ruangan_konversi_id');

                    if (!ruanganKonversiSelect) {
                        console.warn('Element #ruangan_konversi_id tidak ditemukan');
                        return;
                    }

                    // Reset jika tidak ada gudang yang dipilih
                    if (!gudangId) {
                        ruanganKonversiSelect.innerHTML = '<option value="">Pilih Gudang Terlebih Dahulu</option>';
                        return;
                    }

                    // Tampilkan loading
                    ruanganKonversiSelect.innerHTML = '<option>Memuat...</option>';

                    try {
                        const response = await fetch(`/gudangs/${gudangId}/ruangans`);

                        if (!response.ok) {
                            throw new Error('Gagal mengambil data ruangan');
                        }

                        const data = await response.json();

                        // Reset options
                        ruanganKonversiSelect.innerHTML = '<option value="">Pilih Ruangan</option>';

                        // Tambahkan data ruangan
                        data.forEach(function(item) {
                            const option = document.createElement('option');
                            option.value = item.id;
                            option.textContent = item.nama_ruangan;
                            ruanganKonversiSelect.appendChild(option);
                        });

                    } catch (error) {
                        console.error('Error:', error);
                        ruanganKonversiSelect.innerHTML = '<option value="">Gagal memuat ruangan</option>';
                    }
                });
            }
        });
    </script>
@endpush
