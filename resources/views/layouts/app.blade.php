<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Multi Apotek</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100">

<div class="flex">

    @include('components.sidebar')

    <div class="flex-1">

        @include('components.navbar')

        <main class="p-6">
            @yield('content')
        </main>

    </div>

</div>

</body>
</html>
