@extends('layouts.app')

@section('content')

<div class="flex justify-between items-center mb-6">

    <h1 class="text-3xl font-bold">
        Data Akun
    </h1>

    <a href="{{ route('users.create') }}"
       class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg">

        + Tambah Akun

    </a>

</div>

@if(session('success'))

<div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">

    {{ session('success') }}

</div>

@endif

<div class="bg-white rounded-xl shadow overflow-hidden">

    <table class="w-full">

        <thead class="bg-gray-100">

            <tr>

                <th class="p-4">No</th>
                <th class="p-4">Nama</th>
                <th class="p-4">Email</th>
                <th class="p-4">Role</th>
                <th class="p-4">Apotek</th>
                <th class="p-4">Aksi</th>

            </tr>

        </thead>

        <tbody>

            @forelse($users as $user)

            <tr class="border-t">

                <td class="p-4">

                    {{ $loop->iteration }}

                </td>

                <td class="p-4">

                    {{ $user->name }}

                </td>

                <td class="p-4">

                    {{ $user->email }}

                </td>

                <td class="p-4">

                    @if($user->role == 'admin_apotek')

                        <span class="bg-blue-100 text-blue-700 px-3 py-1 rounded-full text-sm">

                            Admin Apotek

                        </span>

                    @elseif($user->role == 'kasir')

                        <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-sm">

                            Kasir

                        </span>

                    @endif

                </td>

                <td class="p-4">

                    {{ $user->apotek->nama_apotek ?? '-' }}

                </td>

                <td class="p-4 flex gap-2">

                    <a href="{{ route('users.edit',$user->id) }}"
                       class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded">

                        Edit

                    </a>

                    <form action="{{ route('users.destroy',$user->id) }}"
                          method="POST">

                        @csrf
                        @method('DELETE')

                        <button
                            onclick="return confirm('Yakin ingin menghapus akun ini?')"
                            class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded">

                            Hapus

                        </button>

                    </form>

                </td>

            </tr>

            @empty

            <tr>

                <td colspan="6"
                    class="text-center p-6 text-gray-500">

                    Belum ada data akun.

                </td>

            </tr>

            @endforelse

        </tbody>

    </table>

</div>

@endsection
