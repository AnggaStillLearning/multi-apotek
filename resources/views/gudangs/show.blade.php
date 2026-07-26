@extends('layouts.app')

@section('content')

@if(session('success'))
<div class="mb-5 rounded-lg bg-green-100 border border-green-300 text-green-700 px-4 py-3">
    {{ session('success') }}
</div>
@endif

@if(session('error'))
<div class="mb-5 rounded-lg bg-red-100 border border-red-300 text-red-700 px-4 py-3">
    {{ session('error') }}
</div>
@endif

<div class="mb-6">

    <a href="{{ route('gudangs.index') }}" class="text-sm text-blue-600 hover:underline">
        &larr; Kembali ke Daftar Gudang
    </a>

    <div class="flex items-center justify-between mt-2">

        <div>

            <h1 class="text-3xl font-bold text-gray-800">
                {{ $gudang->nama_gudang }}
            </h1>

            <p class="text-gray-500 mt-1">
                {{ $gudang->apotek->nama_apotek }}
                @if($gudang->alamat)
                    &middot; {{ $gudang->alamat }}
                @endif
            </p>

        </div>

        <a
            href="{{ route('gudangs.edit', $gudang) }}"
            class="px-5 py-3 border rounded-xl hover:bg-gray-100">

            Edit Gudang

        </a>

    </div>

</div>

<div class="bg-white rounded-xl shadow overflow-hidden">

    <div class="flex items-center justify-between p-6 border-b">

        <h2 class="text-xl font-semibold">
            Ruangan di Gudang Ini
        </h2>

        <button
            type="button"
            onclick="openRuanganModal()"
            class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg">

            + Tambah Ruangan

        </button>

    </div>

    <table class="min-w-full">

        <thead class="bg-gray-100">
            <tr>
                <th class="px-6 py-3 text-left">Nama Ruangan</th>
                <th class="px-6 py-3 text-left">Keterangan</th>
                <th class="px-6 py-3 text-center">Aksi</th>
            </tr>
        </thead>

        <tbody>

            @forelse($gudang->ruangans as $ruangan)

            <tr class="border-t hover:bg-gray-50">

                <td class="px-6 py-4">{{ $ruangan->nama_ruangan }}</td>

                <td class="px-6 py-4">{{ $ruangan->keterangan ?? '-' }}</td>

                <td class="px-6 py-4 text-center">

                    <a
                        href="{{ route('ruangans.edit', $ruangan) }}"
                        class="text-blue-600 hover:underline">

                        Edit

                    </a>

                    |

                    <form
                        action="{{ route('ruangans.destroy', $ruangan) }}"
                        method="POST"
                        class="inline"
                        onsubmit="return confirm('Yakin ingin menghapus ruangan ini?')">

                        @csrf
                        @method('DELETE')

                        <button type="submit" class="text-red-600 hover:underline">
                            Hapus
                        </button>

                    </form>

                </td>

            </tr>

            @empty

            <tr>
                <td colspan="3" class="text-center py-10 text-gray-500">
                    Belum ada ruangan di gudang ini.
                </td>
            </tr>

            @endforelse

        </tbody>

    </table>

</div>

{{-- Modal Tambah Ruangan --}}
<div
    id="ruanganModal"
    class="fixed inset-0 bg-black/50 hidden items-center justify-center z-50">

    <div class="bg-white rounded-xl shadow-xl w-full max-w-lg">

        <form
            method="POST"
            action="{{ route('gudangs.ruangans.store', $gudang) }}">

            @csrf

            <div class="flex items-center justify-between p-6 border-b">

                <h2 class="text-xl font-semibold">
                    Tambah Ruangan
                </h2>

                <button
                    type="button"
                    onclick="closeRuanganModal()"
                    class="text-gray-500 hover:text-black text-xl">

                    &times;

                </button>

            </div>

            <div class="p-6 space-y-5">

                <div>

                    <label class="block text-sm font-medium mb-2">
                        Nama Ruangan
                    </label>

                    <input
                        type="text"
                        name="nama_ruangan"
                        class="w-full border rounded-lg p-3"
                        required>

                    @error('nama_ruangan')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror

                </div>

                <div>

                    <label class="block text-sm font-medium mb-2">
                        Keterangan
                    </label>

                    <textarea
                        name="keterangan"
                        rows="3"
                        class="w-full border rounded-lg p-3"></textarea>

                </div>

            </div>

            <div class="flex justify-end gap-3 border-t p-6">

                <button
                    type="button"
                    onclick="closeRuanganModal()"
                    class="px-4 py-2 rounded-lg bg-gray-300 hover:bg-gray-400">

                    Batal

                </button>

                <button
                    type="submit"
                    class="px-4 py-2 rounded-lg bg-blue-600 text-white hover:bg-blue-700">

                    Simpan

                </button>

            </div>

        </form>

    </div>

</div>

<script>
    function openRuanganModal() {
        const modal = document.getElementById('ruanganModal');
        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }

    function closeRuanganModal() {
        const modal = document.getElementById('ruanganModal');
        modal.classList.remove('flex');
        modal.classList.add('hidden');
    }

    @if($errors->any())
        openRuanganModal();
    @endif
</script>

@endsection
