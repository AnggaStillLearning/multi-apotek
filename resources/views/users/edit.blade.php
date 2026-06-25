@extends('layouts.app')

@section('content')

<h1 class="text-3xl font-bold mb-6">
    Edit Akun
</h1>

<div class="bg-white p-6 rounded-xl shadow">

<form method="POST"
      action="{{ route('users.update',$user->id) }}">

@csrf
@method('PUT')

<div class="mb-4">

<label>Nama</label>

<input
type="text"
name="name"
value="{{ old('name',$user->name) }}"
class="w-full border rounded p-2">

</div>

<div class="mb-4">

<label>Email</label>

<input
type="email"
name="email"
value="{{ old('email',$user->email) }}"
class="w-full border rounded p-2">

</div>

<div class="mb-4">

<label>Password Baru</label>

<input
type="password"
name="password"
class="w-full border rounded p-2">

<small class="text-gray-500">
Kosongkan jika tidak ingin mengganti password.
</small>

</div>

<div class="mb-4">

<label>Role</label>

<select
name="role"
class="w-full border rounded p-2">

<option value="admin_apotek"
{{ $user->role == 'admin_apotek' ? 'selected' : '' }}>

Admin Apotek

</option>

<option value="kasir"
{{ $user->role == 'kasir' ? 'selected' : '' }}>

Kasir

</option>

</select>

</div>

<div class="mb-4">

<label>Apotek</label>

<select
name="apotek_id"
class="w-full border rounded p-2">

@foreach($apoteks as $apotek)

<option
value="{{ $apotek->id }}"
{{ $user->apotek_id == $apotek->id ? 'selected' : '' }}>

{{ $apotek->nama_apotek }}

</option>

@endforeach

</select>

</div>

<button
class="bg-blue-600 text-white px-4 py-2 rounded">

Update

</button>

</form>

</div>

@endsection
