@extends('layouts.app')

@section('content')

<div class="bg-white rounded-xl shadow p-6 max-w-3xl">

    <h1 class="text-2xl font-bold mb-6">

        Edit Gudang

    </h1>

    <form
        action="{{ route('gudangs.update',$gudang->id) }}"
        method="POST">

        @method('PUT')

        @include('gudangs._form')

    </form>

</div>

@endsection
