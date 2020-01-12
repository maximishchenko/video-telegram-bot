<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ mix('js/app.js', 'build') }}"></script>
    <script src="{{ mix('js/main.js', 'build') }}"></script>


    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>



    <!-- Styles -->
    <link href="{{ mix('css/app.css', 'build') }}" rel="stylesheet">

</head>
<body id="app">
{{--    @include('layouts.partials.header')--}}
    @if (Auth::user())
        @include('layouts.partials.sidebar')
    @endif
    <main class="app-content py-4" style="margin-left: 50px;">
        <div class="container">
            @yield('breadcrumbs')
            @include('layouts.partials.flash')
{{--            @include('layouts.partials.tabs')--}}
            @yield('content')
        </div>
    </main>
    @include('layouts.partials.footer')
</body>
</html>
