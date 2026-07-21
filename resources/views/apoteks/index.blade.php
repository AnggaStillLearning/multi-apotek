@extends('layouts.app')

@section('content')

<div class="space-y-6">

    {{-- Header --}}
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">

        <div>
            <h1 class="text-3xl font-bold text-gray-800">
                Data Apotek
            </h1>

            <p class="text-gray-500 mt-1">
                Kelola seluruh data apotek yang terdaftar pada sistem SIMA.
            </p>
        </div>

        <a href="{{ route('apoteks.create') }}"
           class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 transition text-white px-5 py-3 rounded-xl shadow">

            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5"
                 fill="none"
                 viewBox="0 0 24 24"
                 stroke="currentColor">

                <path stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      d="M12 4v16m8-8H4"/>

            </svg>

            Tambah Apotek

        </a>

    </div>

    {{-- Alert --}}
    @if(session('success'))

    <div
        class="bg-green-50 border border-green-200 text-green-700 rounded-xl px-5 py-4">

        {{ session('success') }}

    </div>

    @endif

    {{-- Card --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-200">

        {{-- Card Header --}}
        <div
            class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 p-6 border-b">

            <div>

                <h2 class="text-xl font-semibold text-gray-800">
                    Daftar Apotek
                </h2>

                <p class="text-gray-500 text-sm mt-1">
                    Seluruh apotek yang telah terdaftar.
                </p>

            </div>

            {{-- Search (UI Only) --}}
            <div class="relative">

                <input
                    type="text"
                    placeholder="Cari nama apotek..."
                    class="pl-10 pr-4 py-2 border rounded-xl w-72 focus:ring-2 focus:ring-blue-500 focus:outline-none">

                <svg xmlns="http://www.w3.org/2000/svg"
                     class="w-5 h-5 absolute left-3 top-2.5 text-gray-400"
                     fill="none"
                     viewBox="0 0 24 24"
                     stroke="currentColor">

                    <path stroke-linecap="round"
                          stroke-linejoin="round"
                          stroke-width="2"
                          d="M21 21l-4.35-4.35M11 18a7 7 0 100-14 7 7 0 000 14z"/>

                </svg>

            </div>

        </div>

        {{-- Table --}}
        <div class="overflow-x-auto">

            <table class="min-w-full">

                <thead class="bg-gray-50">

                    <tr>

                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-600">
                            Nama Apotek
                        </th>

                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-600">
                            Alamat
                        </th>

                        <th class="px-6 py-4 text-center text-sm font-semibold text-gray-600">
                            Aksi
                        </th>

                    </tr>

                </thead>

                <tbody class="divide-y divide-gray-100">

                    @forelse($apoteks as $apotek)

                    <tr class="hover:bg-blue-50 transition duration-200">

                        <td class="px-6 py-5">

                            <div class="flex items-center gap-3">

                                <div
                                    class="w-11 h-11 rounded-xl bg-blue-100 flex items-center justify-center">

                                    <svg xmlns="http://www.w3.org/2000/svg"
                                         class="w-6 h-6 text-blue-600"
                                         fill="none"
                                         viewBox="0 0 24 24"
                                         stroke="currentColor">

                                        <path stroke-linecap="round"
                                              stroke-linejoin="round"
                                              stroke-width="2"
                                              d="M19 11H5m7-7v14"/>

                                    </svg>

                                </div>

                                <div>

                                    <div class="font-semibold text-gray-800">

                                        {{ $apotek->nama_apotek }}

                                    </div>

                                    <div class="text-xs text-gray-500">

                                        Cabang Apotek

                                    </div>

                                </div>

                            </div>

                        </td>

                        <td class="px-6 py-5 text-gray-600">

                            {{ $apotek->alamat }}

                        </td>

                        <td class="px-6 py-5">

                            <div class="flex justify-center gap-3">

                                <a href="{{ route('apoteks.edit',$apotek->id) }}"
                                   class="px-4 py-2 rounded-lg bg-blue-100 text-blue-600 hover:bg-blue-600 hover:text-white transition">

                                    Edit

                                </a>

                                <form
                                    method="POST"
                                    action="{{ route('apoteks.destroy',$apotek->id) }}"
                                    onsubmit="return confirm('Yakin ingin menghapus apotek ini?')">

                                    @csrf
                                    @method('DELETE')

                                    <button
                                        class="px-4 py-2 rounded-lg bg-red-100 text-red-600 hover:bg-red-600 hover:text-white transition">

                                        Hapus

                                    </button>

                                </form>

                            </div>

                        </td>

                    </tr>

                    @empty

                    <tr>

                        <td colspan="3" class="py-16">

                            <div
                                class="flex flex-col items-center justify-center text-center">

                                <div
                                    class="w-20 h-20 rounded-full bg-gray-100 flex items-center justify-center mb-4">

                                    <svg xmlns="http://www.w3.org/2000/svg"
                                         class="w-10 h-10 text-gray-400"
                                         fill="none"
                                         viewBox="0 0 24 24"
                                         stroke="currentColor">

                                        <path stroke-linecap="round"
                                              stroke-linejoin="round"
                                              stroke-width="2"
                                              d="M19 11H5m7-7v14"/>

                                    </svg>

                                </div>

                                <h3
                                    class="text-lg font-semibold text-gray-700">

                                    Belum Ada Data Apotek

                                </h3>

                                <p class="text-gray-500 mt-2">

                                    Silakan tambahkan apotek pertama Anda.

                                </p>

                            </div>

                        </td>

                    </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection
