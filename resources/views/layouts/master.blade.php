<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Reservandonos</title>

        @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/css/normalize.css'])
        @yield('styles')
    </head>

<body>
<div class="container" id="app">
    <v-app>
        @yield('content')
    </v-app>
</div>
@yield('scripts')
</body>

</html>
