@extends('layouts.app')

@section('content')

<div class="max-w-5xl mx-auto">

    <div class="mb-8">

        <h1 class="text-3xl font-bold text-gray-800">

            Edit Obat

        </h1>

        <p class="text-gray-500">

            Perbarui informasi master obat.

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
        action="{{ route('obats.update', $obat->id) }}"
        method="POST"
        class="bg-white rounded-xl shadow p-8">

        @csrf
        @method('PUT')

        @include('obats._form')

    </form>

</div>

@endsection
