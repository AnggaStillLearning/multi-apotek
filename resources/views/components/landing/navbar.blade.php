<nav class="bg-white shadow-sm sticky top-0 z-50">

    <div
        class="max-w-7xl
               mx-auto
               px-6
               py-4
               flex
               justify-between
               items-center">

        <div
            class="flex
                   items-center
                   gap-3">

            <div
                class="w-12
                       h-12
                       rounded-xl
                       bg-green-600
                       text-white
                       flex
                       items-center
                       justify-center
                       text-2xl">

                💊

            </div>

            <div>

                <h1
                    class="font-bold
                           text-2xl
                           text-green-700">

                    Multi Apotek

                </h1>

                <p
                    class="text-xs
                           text-gray-500">

                    Monitoring Obat

                </p>

            </div>

        </div>

        <div
            class="hidden
                   md:flex
                   gap-8
                   font-medium">

            <a
                href="/"
                class="hover:text-green-600">

                Home

            </a>

            <a
                href="#obat"
                class="hover:text-green-600">

                Cari Obat

            </a>

            <a
                href="#apotek"
                class="hover:text-green-600">

                Apotek

            </a>

            <a
                href="#tentang"
                class="hover:text-green-600">

                Tentang

            </a>

        </div>

        <a
            href="{{ route('login') }}"
            class="bg-green-600
                   hover:bg-green-700
                   transition
                   text-white
                   px-6
                   py-2
                   rounded-xl">

            Login

        </a>

    </div>

</nav>
