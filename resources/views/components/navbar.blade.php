@php

$stokNotif = \App\Models\Obat::where(
    'apotek_id',
    auth()->user()->apotek_id
)
->whereColumn(
    'stok',
    '<=',
    'stok_minimum'
)
->count();

$expiredNotif = \App\Models\Obat::where(
    'apotek_id',
    auth()->user()->apotek_id
)
->whereBetween(
    'tanggal_kadaluarsa',
    [now(), now()->addDays(30)]
)
->count();

$totalNotif = $stokNotif + $expiredNotif;

@endphp

<div class="relative group">

    <button
        class="relative flex items-center justify-center
               w-10 h-10 rounded-full
               hover:bg-gray-100 transition">

        <svg xmlns="http://www.w3.org/2000/svg"
             class="w-6 h-6 text-gray-700"
             fill="none"
             viewBox="0 0 24 24"
             stroke="currentColor">

            <path stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="M15 17h5l-1.405-1.405A2.032
                  2.032 0 0118 14.158V11a6.002
                  6.002 0 00-4-5.659V5a2
                  2 0 10-4 0v.341C7.67
                  6.165 6 8.388 6 11v3.159c0
                  .538-.214 1.055-.595
                  1.436L4 17h5m6 0v1a3
                  3 0 11-6 0v-1m6 0H9" />
        </svg>

        @if($totalNotif > 0)

        <span
            class="absolute top-0 right-0
                   bg-red-500 text-white
                   text-xs font-bold
                   rounded-full
                   min-w-[20px]
                   h-5
                   flex items-center justify-center">

            {{ $totalNotif }}

        </span>

        @endif

    </button>

    <div
        class="hidden group-hover:block
               absolute right-0 mt-2
               w-80 bg-white
               rounded-xl shadow-xl
               border z-50">

        <div class="px-4 py-3 border-b">

            <h3 class="font-semibold text-gray-800">
                Notifikasi
            </h3>

        </div>

        @if($stokNotif > 0)

        <div class="px-4 py-3 border-b">

            <div class="font-medium text-red-600">
                ⚠ Stok Kritis
            </div>

            <div class="text-sm text-gray-600">
                {{ $stokNotif }} obat perlu restock
            </div>

        </div>

        @endif

        @if($expiredNotif > 0)

        <div class="px-4 py-3">

            <div class="font-medium text-yellow-600">
                ⏳ Mendekati Kadaluarsa
            </div>

            <div class="text-sm text-gray-600">
                {{ $expiredNotif }} obat perlu diperiksa
            </div>

        </div>

        @endif

        @if($totalNotif == 0)

        <div class="px-4 py-6 text-center text-gray-500">

            Tidak ada notifikasi

        </div>

        @endif

    </div>

</div>
