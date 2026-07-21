@php

$stokNotif = 0;
$expiredNotif = 0;
$totalNotif = 0;

@endphp
<div class="flex justify-end items-center gap-6">
    {{-- ================= NOTIFIKASI ================= --}}
    <div class="relative" x-data="{ notif: false }">
        <button
            @click="notif = !notif"
            class="relative w-11 h-11 rounded-full bg-white shadow hover:bg-gray-100 transition"
        >
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0a3 3 0 11-6 0m6 0H9"/>
            </svg>

            @if($totalNotif)
                <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs w-5 h-5 rounded-full flex items-center justify-center">
                    {{ $totalNotif }}
                </span>
            @endif
        </button>

        <div
            x-show="notif"
            @click.outside="notif = false"
            x-transition
            class="absolute right-0 mt-3 w-80 bg-white rounded-2xl shadow-xl border overflow-hidden"
            style="display:none"
        >
            <div class="px-5 py-4 border-b">
                <h3 class="font-bold">Notifikasi</h3>
            </div>

            @if($stokNotif)
                <div class="px-5 py-4 border-b hover:bg-gray-50">
                    <div class="font-semibold text-red-600">
                        <!-- Stok Kritis Icon -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 inline mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                        </svg>
                        Stok Kritis
                    </div>
                    <div class="text-sm text-gray-500">
                        {{ $stokNotif }} obat perlu direstock.
                    </div>
                </div>
            @endif

            @if($expiredNotif)
                <div class="px-5 py-4 border-b hover:bg-gray-50">
                    <div class="font-semibold text-yellow-600">
                        <!-- Kadaluarsa Icon -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 inline mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        Kadaluarsa
                    </div>
                    <div class="text-sm text-gray-500">
                        {{ $expiredNotif }} obat mendekati kadaluarsa.
                    </div>
                </div>
            @endif

            @if($totalNotif == 0)
                <div class="p-6 text-center text-gray-400">
                    Tidak ada notifikasi.
                </div>
            @endif
        </div>
    </div>

    {{-- ================= PROFILE ================= --}}
    <div class="relative" x-data="{ profile: false }">
        <button
            @click="profile = !profile"
            class="flex items-center gap-3 bg-white rounded-full shadow pl-2 pr-4 py-2 hover:bg-gray-50"
        >
            <div class="w-11 h-11 rounded-full bg-blue-600 text-white flex items-center justify-center font-bold">
                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
            </div>
            <div class="text-left">
                <div class="font-semibold">{{ auth()->user()->name }}</div>
                <div class="text-xs text-gray-500">{{ ucwords(str_replace('_', ' ', auth()->user()->role)) }}</div>
            </div>
        </button>

        <div
            x-show="profile"
            @click.outside="profile = false"
            x-transition
            class="absolute right-0 mt-3 w-72 bg-white rounded-2xl shadow-xl border"
            style="display:none"
        >
            <div class="p-5 border-b">
                <div class="flex items-center gap-3">
                    <div class="w-14 h-14 rounded-full bg-blue-600 text-white flex items-center justify-center text-xl font-bold">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>
                    <div>
                        <div class="font-bold">{{ auth()->user()->name }}</div>
                        <div class="text-sm text-gray-500">{{ auth()->user()->email }}</div>
                    </div>
                </div>
            </div>

            <div class="py-2">
                <a href="{{ route('profile.edit') }}" class="block px-5 py-3 hover:bg-gray-100">
                    <!-- Profile Icon -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 inline mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                    Profil Saya
                </a>
                <a href="#" class="block px-5 py-3 hover:bg-gray-100">
                    <!-- Settings Icon -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 inline mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                    Pengaturan
                </a>
            </div>

            <div class="border-t p-3">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="w-full bg-red-500 hover:bg-red-600 text-white rounded-xl py-3">
                        <!-- Logout Icon -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 inline mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                        </svg>
                        Logout
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
