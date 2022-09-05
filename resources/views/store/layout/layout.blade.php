<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" href="{{mix('css/store.css')}}">
    
    <title>@yield('title')</title>
    @livewireStyles
</head>

<body>
    @livewire('shop-footer')

    <div class="container" style="margin-top: 70px;">
        @yield('content')
    </div>
    {{-- @livewire('shop-footer') --}}

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->

    @livewireScripts
    <script src="{{ mix('js/app.js') }}"></script>
    @stack('scripts')

</body>

</html>
