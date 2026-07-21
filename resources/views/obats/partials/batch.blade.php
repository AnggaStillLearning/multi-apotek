<div class="bg-white rounded-xl shadow p-6 mt-6">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h2 class="text-xl font-semibold text-gray-800">Batch Obat</h2>
            <p class="text-sm text-gray-500 mt-1">
                Kelola batch, lokasi penyimpanan, stok dan tanggal kadaluarsa.
            </p>
        </div>
        <button
            type="button"
            onclick="openBatchModal()"
            class="bg-green-600 hover:bg-green-700 text-white px-5 py-2 rounded-lg shadow"
        >
            + Tambah Batch
        </button>
    </div>

    {{-- Statistik Batch --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
            <p class="text-sm text-gray-500">Total Batch</p>
            <h3 class="text-2xl font-bold text-blue-700">
                {{ $obat->batchObats->count() }}
            </h3>
        </div>
        <div class="bg-green-50 border border-green-200 rounded-lg p-4">
            <p class="text-sm text-gray-500">Total Stok</p>
            <h3 class="text-2xl font-bold text-green-700">
                {{ number_format($obat->total_stok) }}
            </h3>
        </div>
    </div>

    {{-- Tabel Batch --}}
    <div class="overflow-x-auto">
        <table class="min-w-full">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-4 py-3 text-left">Batch</th>
                    <th class="px-4 py-3 text-left">Gudang</th>
                    <th class="px-4 py-3 text-left">Ruangan</th>
                    <th class="px-4 py-3 text-right">Harga Beli</th>
                    <th class="px-4 py-3 text-center">Stok</th>
                    <th class="px-4 py-3 text-center">Kadaluarsa</th>
                    <th class="px-4 py-3 text-center">Status</th>
                    <th class="px-4 py-3 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($obat->batchObats->sortBy('tanggal_kadaluarsa') as $batch)
                    @php
                        $sisaHari = now()->diffInDays($batch->tanggal_kadaluarsa, false);
                    @endphp
                    <tr class="border-b hover:bg-gray-50">
                        <td class="px-4 py-4 font-medium">{{ $batch->nomor_batch }}</td>
                        <td class="px-4 py-4">{{ $batch->gudang->nama_gudang ?? '-' }}</td>
                        <td class="px-4 py-4">{{ $batch->ruangan->nama_ruangan ?? '-' }}</td>
                        <td class="px-4 py-4 text-right">
                            Rp {{ number_format($batch->harga_beli, 0, ',', '.') }}
                        </td>
                        <td class="px-4 py-4 text-center">
                            @if($batch->stok <= $obat->stok_minimum)
                                <span class="px-3 py-1 rounded-full bg-red-100 text-red-700">
                                    {{ $batch->stok }}
                                </span>
                            @else
                                <span class="px-3 py-1 rounded-full bg-green-100 text-green-700">
                                    {{ $batch->stok }}
                                </span>
                            @endif
                        </td>
                        <td class="px-4 py-4 text-center">
                            {{ \Carbon\Carbon::parse($batch->tanggal_kadaluarsa)->format('d M Y') }}
                        </td>
                        <td class="px-4 py-4 text-center">
                            @if($sisaHari < 0)
                                <span class="px-3 py-1 rounded-full bg-red-100 text-red-700">
                                    Kadaluarsa
                                </span>
                            @elseif($sisaHari <= 30)
                                <span class="px-3 py-1 rounded-full bg-yellow-100 text-yellow-700">
                                    Segera Kadaluarsa
                                </span>
                            @else
                                <span class="px-3 py-1 rounded-full bg-green-100 text-green-700">
                                    Aman
                                </span>
                            @endif
                        </td>
                        <td class="px-4 py-4">
                            <div class="flex justify-center gap-2">
                                <button
                                    type="button"
                                    onclick="openEditBatchModal({{ $batch->id }})"
                                    class="bg-yellow-100 hover:bg-yellow-200 text-yellow-700 px-3 py-2 rounded-lg"
                                    title="Edit Batch"
                                >
                                    ✏
                                </button>
                                <form
                                    action="{{ route('batch.destroy', $batch->id) }}"
                                    method="POST"
                                    class="inline"
                                    onsubmit="return confirm('Apakah Anda yakin ingin menghapus batch ini?')"
                                >
                                    @csrf
                                    @method('DELETE')
                                    <button
                                        type="submit"
                                        class="bg-red-100 hover:bg-red-200 text-red-700 px-3 py-2 rounded-lg"
                                        title="Hapus Batch"
                                    >
                                        🗑
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="py-10 text-center text-gray-500">
                            Belum ada data batch.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- Modal Edit Batch --}}
<div id="editBatchModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50">
    <div class="bg-white rounded-xl shadow-lg max-w-2xl w-full max-h-[90vh] overflow-y-auto">
        <div class="flex justify-between items-center p-6 border-b">
            <h3 class="text-xl font-semibold">Edit Batch</h3>
            <button type="button" onclick="closeEditBatchModal()" class="text-gray-400 hover:text-gray-600 text-2xl">
                ×
            </button>
        </div>
        <form id="editBatchForm" method="POST" action="">
            @csrf
            @method('PUT')
            <div class="p-6 space-y-4">
                <div>
                    <label class="block text-sm font-medium mb-1">Nomor Batch</label>
                    <input
                        type="text"
                        name="nomor_batch"
                        id="edit_nomor_batch"
                        class="w-full border rounded-lg p-2 bg-gray-100"
                        readonly
                    >
                </div>

                <div>
                    <label class="block text-sm font-medium mb-1">Gudang</label>
                    <select name="gudang_id" id="edit_gudang_id" class="w-full border rounded-lg p-2" required>
                        <option value="">Pilih Gudang</option>
                        @foreach($gudangs as $gudang)
                            <option value="{{ $gudang->id }}">{{ $gudang->nama_gudang }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium mb-1">Ruangan</label>
                    <select name="ruangan_id" id="edit_ruangan_id" class="w-full border rounded-lg p-2" required>
                        <option value="">Pilih Ruangan</option>
                    </select>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium mb-1">Harga Beli</label>
                        <input
                            type="number"
                            name="harga_beli"
                            id="edit_harga_beli"
                            class="w-full border rounded-lg p-2"
                            required
                        >
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1">Stok</label>
                        <input
                            type="number"
                            name="stok"
                            id="edit_stok"
                            class="w-full border rounded-lg p-2"
                            required
                            min="0"
                        >
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium mb-1">Tanggal Kadaluarsa</label>
                    <input
                        type="date"
                        name="tanggal_kadaluarsa"
                        id="edit_tanggal_kadaluarsa"
                        class="w-full border rounded-lg p-2"
                        required
                    >
                </div>
            </div>
            <div class="flex justify-end gap-3 p-6 border-t bg-gray-50 rounded-b-xl">
                <button
                    type="button"
                    onclick="closeEditBatchModal()"
                    class="px-4 py-2 border rounded-lg hover:bg-gray-100"
                >
                    Batal
                </button>
                <button
                    type="submit"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg"
                >
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    // ===== FUNGSI EDIT BATCH =====
    function openEditBatchModal(batchId) {
        // Fetch data batch
        fetch(`/batch/${batchId}/edit`)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Response gagal');
                }
                return response.json();
            })
            .then(data => {
                document.getElementById('edit_nomor_batch').value = data.nomor_batch;
                document.getElementById('edit_gudang_id').value = data.gudang_id;
                document.getElementById('edit_harga_beli').value = data.harga_beli;
                document.getElementById('edit_stok').value = data.stok;
                document.getElementById('edit_tanggal_kadaluarsa').value = data.tanggal_kadaluarsa;

                // Set form action
                document.getElementById('editBatchForm').action = `/batch/${batchId}`;

                // Load ruangan berdasarkan gudang yang dipilih
                loadRuanganForEdit(data.gudang_id, data.ruangan_id);

                // Tampilkan modal
                const modal = document.getElementById('editBatchModal');
                modal.classList.remove('hidden');
                modal.classList.add('flex');
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Gagal memuat data batch');
            });
    }

    function closeEditBatchModal() {
        const modal = document.getElementById('editBatchModal');
        modal.classList.remove('flex');
        modal.classList.add('hidden');
    }

    function loadRuanganForEdit(gudangId, selectedRuanganId = null) {
        const ruanganSelect = document.getElementById('edit_ruangan_id');

        if (!gudangId) {
            ruanganSelect.innerHTML = '<option value="">Pilih Gudang Terlebih Dahulu</option>';
            return;
        }

        ruanganSelect.innerHTML = '<option>Memuat...</option>';

        fetch(`/gudangs/${gudangId}/ruangans`)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Response gagal');
                }
                return response.json();
            })
            .then(data => {
                ruanganSelect.innerHTML = '<option value="">Pilih Ruangan</option>';
                data.forEach(item => {
                    const option = document.createElement('option');
                    option.value = item.id;
                    option.textContent = item.nama_ruangan;
                    if (selectedRuanganId && item.id == selectedRuanganId) {
                        option.selected = true;
                    }
                    ruanganSelect.appendChild(option);
                });
            })
            .catch(error => {
                console.error('Error:', error);
                ruanganSelect.innerHTML = '<option value="">Gagal memuat ruangan</option>';
            });
    }

    // ===== EVENT LISTENER UNTUK EDIT BATCH =====
    document.addEventListener('DOMContentLoaded', function() {
        const editGudangSelect = document.getElementById('edit_gudang_id');

        if (editGudangSelect) {
            editGudangSelect.addEventListener('change', function() {
                const gudangId = this.value;
                loadRuanganForEdit(gudangId);
            });
        }
    });

    // ===== FUNGSI UNTUK LOAD RUANGAN (Modal Tambah) =====
    function loadRuangan(gudangId) {
        const ruanganSelect = document.getElementById('ruangan_id');

        if (!gudangId) {
            ruanganSelect.innerHTML = '<option value="">Pilih Gudang Terlebih Dahulu</option>';
            return;
        }

        ruanganSelect.innerHTML = '<option>Memuat...</option>';

        fetch(`/gudangs/${gudangId}/ruangans`)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Response gagal');
                }
                return response.json();
            })
            .then(data => {
                ruanganSelect.innerHTML = '<option value="">Pilih Ruangan</option>';
                data.forEach(item => {
                    const option = document.createElement('option');
                    option.value = item.id;
                    option.textContent = item.nama_ruangan;
                    ruanganSelect.appendChild(option);
                });
            })
            .catch(error => {
                console.error('Error:', error);
                ruanganSelect.innerHTML = '<option value="">Gagal memuat ruangan</option>';
            });
    }
</script>
@endpush
