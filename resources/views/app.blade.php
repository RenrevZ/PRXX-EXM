<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title inertia>{{ config('app.name', 'EXM') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="../../node_modules/flowbite/dist/flowbite.min.css">

    <!-- Scripts -->
    @routes
    @vite(['resources/js/app.js', "resources/js/Pages/{$page['component']}.vue"])
    @inertiaHead
    <script src="../../node_modules/flowbite/dist/flowbite.min.js"></script>
    <script src="../../node_modules/flowbite/dist/datepicker.min.js"></script>
    <script src="../../node_modules/flowbite/dist/datepicker.turbo.js"></script>
</head>

<body class="font-sans antialiased">
    @inertia

    <script src="../../node_modules/flowbite/dist/flowbite.js"></script>
    <script src="../../node_modules/flowbite/dist/datepicker.js"></script>
    <script src="../../node_modules/flowbite/dist/datepicker.turbo.js.map"></script>
</body>

</html>