@php

use App\Models\Obat;

$stokNotif = 0;
$expiredNotif = 0;
$totalNotif = 0;

if(auth()->check()){

    $stokNotif = Obat::where(
        'apotek_id',
        auth()->user()->apotek_id
    )
    ->whereColumn(
        'stok',
        '<=',
        'stok_minimum'
    )
    ->count();

    $expiredNotif = Obat::where(
        'apotek_id',
        auth()->user()->apotek_id
    )
    ->whereBetween(
        'tanggal_kadaluarsa',
        [now(), now()->addDays(30)]
    )
    ->count();

    $totalNotif =
    $stokNotif + $expiredNotif;

}

@endphp

<div
class="flex justify-end items-center gap-6">

    {{-- ================= NOTIFIKASI ================= --}}

    <div
    class="relative"
    x-data="{ notif:false }">

        <button
        @click="notif=!notif"
        class="relative w-11 h-11
               rounded-full
               bg-white
               shadow
               hover:bg-gray-100
               transition">

            🔔

            @if($totalNotif)

            <span
            class="absolute
                   -top-1
                   -right-1
                   bg-red-500
                   text-white
                   text-xs
                   w-5
                   h-5
                   rounded-full
                   flex
                   items-center
                   justify-center">

                {{ $totalNotif }}

            </span>

            @endif

        </button>

        <div
        x-show="notif"
        @click.outside="notif=false"
        x-transition
        class="absolute
               right-0
               mt-3
               w-80
               bg-white
               rounded-2xl
               shadow-xl
               border
               overflow-hidden"
        style="display:none">

            <div
            class="px-5 py-4
                   border-b">

                <h3
                class="font-bold">

                    Notifikasi

                </h3>

            </div>

            @if($stokNotif)

            <div
            class="px-5 py-4
                   border-b
                   hover:bg-gray-50">

                <div class="font-semibold text-red-600">

                    ⚠ Stok Kritis

                </div>

                <div class="text-sm text-gray-500">

                    {{ $stokNotif }}
                    obat perlu direstock.

                </div>

            </div>

            @endif

            @if($expiredNotif)

            <div
            class="px-5 py-4
                   hover:bg-gray-50">

                <div
                class="font-semibold
                       text-yellow-600">

                    ⏳ Kadaluarsa

                </div>

                <div
                class="text-sm
                       text-gray-500">

                    {{ $expiredNotif }}
                    obat mendekati kadaluarsa.

                </div>

            </div>

            @endif

            @if($totalNotif==0)

            <div
            class="p-6
                   text-center
                   text-gray-400">

                Tidak ada notifikasi.

            </div>

            @endif

        </div>

    </div>

    {{-- ================= PROFILE ================= --}}

    <div
    class="relative"
    x-data="{ profile:false }">

        <button
        @click="profile=!profile"
        class="flex
               items-center
               gap-3
               bg-white
               rounded-full
               shadow
               pl-2
               pr-4
               py-2
               hover:bg-gray-50">

            <div
            class="w-11
                   h-11
                   rounded-full
                   bg-blue-600
                   text-white
                   flex
                   items-center
                   justify-center
                   font-bold">

                {{ strtoupper(substr(auth()->user()->name,0,1)) }}

            </div>

            <div class="text-left">

                <div
                class="font-semibold">

                    {{ auth()->user()->name }}

                </div>

                <div
                class="text-xs
                       text-gray-500">

                    {{ ucwords(str_replace('_',' ',auth()->user()->role)) }}

                </div>

            </div>

        </button>

        <div
        x-show="profile"
        @click.outside="profile=false"
        x-transition
        class="absolute
               right-0
               mt-3
               w-72
               bg-white
               rounded-2xl
               shadow-xl
               border"
        style="display:none">

            <div
            class="p-5
                   border-b">

                <div
                class="flex
                       items-center
                       gap-3">

                    <div
                    class="w-14
                           h-14
                           rounded-full
                           bg-blue-600
                           text-white
                           flex
                           items-center
                           justify-center
                           text-xl
                           font-bold">

                        {{ strtoupper(substr(auth()->user()->name,0,1)) }}

                    </div>

                    <div>

                        <div
                        class="font-bold">

                            {{ auth()->user()->name }}

                        </div>

                        <div
                        class="text-sm
                               text-gray-500">

                            {{ auth()->user()->email }}

                        </div>

                    </div>

                </div>

            </div>

            <div class="py-2">

                <a
                href="{{ route('profile.edit') }}"
                class="block
                       px-5
                       py-3
                       hover:bg-gray-100">

                    👤 Profil Saya

                </a>

                <a
                href="#"
                class="block
                       px-5
                       py-3
                       hover:bg-gray-100">

                    ⚙ Pengaturan

                </a>

            </div>

            <div
            class="border-t
                   p-3">

                <form
                method="POST"
                action="{{ route('logout') }}">

                    @csrf

                    <button
                    class="w-full
                           bg-red-500
                           hover:bg-red-600
                           text-white
                           rounded-xl
                           py-3">

                        Logout

                    </button>

                </form>

            </div>

        </div>

    </div>

</div>
