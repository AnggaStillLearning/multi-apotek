@extends('layouts.app')

@section('content')

<div class="bg-white rounded-xl shadow p-6 max-w-3xl">

    <h1 class="text-2xl font-bold mb-6">

        Tambah Gudang

    </h1>

    <form
        action="{{ route('gudangs.store') }}"
        method="POST">

        @include('gudangs._form')

    </form>

</div>

@endsection
