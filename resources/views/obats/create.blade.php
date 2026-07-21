@extends('layouts.app')

@section('content')

<div class="max-w-5xl mx-auto">

    <div class="mb-8">

        <h1 class="text-3xl font-bold text-gray-800">

            Tambah Obat

        </h1>

        <p class="text-gray-500">

            Tambahkan master obat baru.

        </p>

    </div>

    @if($errors->any())

    <div class="mb-6 rounded-lg bg-red-100 border border-red-300 p-4">

        <ul class="list-disc list-inside text-red-700">

            @foreach($errors->all() as $error)

                <li>{{ $error }}</li>

            @endforeach

        </ul>

    </div>

    @endif

    <form
        action="{{ route('obats.store') }}"
        method="POST"
        class="bg-white rounded-xl shadow p-8">

        @include('obats._form')

    </form>

</div>

@endsection
