<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="turbolinks-cache-control" content="no-cache">
    <link rel="icon" type="image/x-icon" href="{{ metaData()->getFavicon() }}">
    <title> @yield('title') - {{ metaData()->getWebsiteTitle() }} </title>
    {{-- <link rel="stylesheet" href="{{ mix('css/store.css') }}"> --}}
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.cdnfonts.com/css/solaimanlipi" rel="stylesheet">

    <style>
        body {
            font-family: 'SolaimanLipi', sans-serif;
        }
    </style>

    <title>@yield('title')</title>
    @livewireScripts
    {{-- 
    <script src="https://cdn.jsdelivr.net/gh/livewire/turbolinks@v0.1.x/dist/livewire-turbolinks.js"
        data-turbolinks-eval="false"></script> --}}

    <script src="{{ mix('js/store.js') }}"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-autocomplete/1.0.7/jquery.auto-complete.min.js"></script>
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/jquery-autocomplete/1.0.7/jquery.auto-complete.min.css">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">
    <link rel="stylesheet" href="/vendor/fontawesome-free/css/all.min.css">



</head>

<body>

    @include('store.layout.navbar')
    @yield('fullContant')
    <div class="container mx-auto 
        mt-[90px]  min-h-screen p-4
    " id="loadBody">
        @yield('content')
    </div>
    @include('store.layout.footer')
</body>
@stack('scripts')

<script>
    Store.home.updateProductImageSize();
    Helper.initBodyAction();
</script>

</html>
