<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ mix('js/app.js', 'build') }}" defer></script>

    <!-- Styles -->
    <link href="{{ mix('css/app.css', 'build') }}" rel="stylesheet">
</head>
<body id="app">
    @include('layouts.partials.header')
    <main class="app-content py-4">
        <div class="container">
            @section('breadcrumbs', Breadcrumbs::render())
            @yield('breadcrumbs')
            @include('flash::message')
            @yield('content')
        </div>
    </main>
    @include('layouts.partials.footer')
</body>
</html>
