@extends('layouts.app')

@section('content')

<div class="max-w-5xl mx-auto">

    <div class="bg-white rounded-xl shadow-sm border">

        <div class="border-b px-6 py-4">
            <h1 class="text-xl font-semibold">
                Tambah Supplier
            </h1>
        </div>

        <form
            action="{{ route('suppliers.store') }}"
            method="POST"
            class="p-6"
        >
            @csrf

            @include('suppliers._form')

        </form>

    </div>

</div>

@endsection
