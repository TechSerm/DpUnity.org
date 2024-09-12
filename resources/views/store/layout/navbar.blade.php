<style>
    .cnav .cbtn {
        padding: 10px 4px 10px 4px;
        background-color: #F47375;
        border: 1px solid #aaaaaa;
        color: #ffffff;
        font-weight: bold;
        border-radius: 5px;
        margin-right: 5px;
        width: 130px;
    }

    .cnav .leftSide {
        width: 50%;
    }

    .cnav .rightSide {
        width: 50%;
    }

    .cnav .logo {
        height: 50px;
        margin-top: 0px;
    }

    .nav__menu {
        width: 80% !important;
    }

    @media screen and (max-width: 767px) {
        .cbtn {
            display: none;
        }

        .navlink-desktop {
            display: none;
        }


        .cnav .leftSide {
            width: 30%;
        }

        .cnav .rightSide {
            width: 65%;
        }

        .cnav .logo {
            height: 35px;
            margin-top: 5px;
        }

        .nav__menu {
            width: 100% !important;
        }
    }

    .cbtn:focus {
        outline: none;
    }

    .cbtn.active {
        background: #6352b9;
        color: #ffffff;
    }


    .btn .bx {
        vertical-align: inherit;
        margin-top: -3px;
        font-size: 1.15rem;
    }

    .form-control {
        height: calc(2.5rem + 2px);
        padding: 0.5rem 0.5rem;
        font-size: 1rem;
        line-height: 1.5;
        border-radius: 0.3rem;
    }

    .btn {
        font-size: 1rem;
        padding: 0.5rem 0.75rem;
        font-size: 1rem;
        line-height: 1.5;
        border-radius: 0.25rem;
    }

    .bx.icon-single {
        font-size: 1.5rem;
    }

    .form-inline .form-control {
        border-top-right-radius: 0;
        border-bottom-right-radius: 0;
    }

    .form-inline .btn {
        border-top-left-radius: 0;
        border-bottom-left-radius: 0;
    }

    /* Small devices (landscape phones, 576px and up) */
    @media (min-width: 576px) {}

    /* Medium devices (tablets, 768px and up) */
    @media (min-width: 768px) {
        .form-inline .form-control {
            width: 210px;
        }
    }

    /* Large devices (desktops, 992px and up) */
    @media (min-width: 992px) {
        .form-inline .form-control {
            width: 440px;
        }
    }

    /* Extra large devices (large desktops, 1200px and up) */
    @media (min-width: 1200px) {
        .form-inline .form-control {
            width: 600px;
        }
    }

    .sub-menu.navbar-light .navbar-nav .active>.nav-link,
    .sub-menu.navbar-light .navbar-nav .nav-link.active,
    .sub-menu.navbar-light .navbar-nav .nav-link.show,
    .sub-menu.navbar-light .navbar-nav .show>.nav-link {
        border-bottom: 3px solid #007bff;
        color: #007bff;
    }

    .navbar .navbar-toggler {
        border: none;
    }

    .navbar-light .navbar-toggler:focus {
        outline: none;
    }

    .navbar {
        padding: 1rem;
    }

    .main-menu {
        position: relative;
        z-index: 3;
        background: #ffffff;
    }

    .sub-menu {
        position: relative;
        z-index: 2;
    }

    /* Medium devices (tablets, 768px and up) */
    @media (min-width: 768px) {
        .sub-menu {
            padding: 0 1rem;
        }

        .sub-menu.navbar-expand-md .navbar-nav .nav-link {
            padding: 1rem 1.5rem;
        }
    }

    .navbar.bg-light {
        background: #fff !important;
        box-shadow: 0px 2px 15px 0px rgba(0, 0, 0, 0.1);
    }

    .user-dropdown .nav-link {
        padding: 0.15rem 0;
    }

    #sidebar {
        background: #fff;
        height: 100%;
        left: -100%;
        top: 0;
        bottom: 0;
        overflow: auto;
        position: fixed;
        transition: 0.4s ease-in-out;
        width: 84%;
        z-index: 5001;
        box-shadow: 0px 0px 20px rgba(0, 0, 0, 0.3);
        padding: 1.25rem 1rem 1rem;
    }

    #sidebar.active {
        left: 0;
    }

    #sidebar .sidebar-header {
        background: #fff;
        border-bottom: 1px solid #e4e4e4;
        padding-bottom: 1.5rem;
    }

    #sidebar ul.components {
        padding: 20px 0;
        border-bottom: 1px solid #e4e4e4;
        margin-bottom: 40px;
    }

    #sidebar ul p {
        color: #fff;
        padding: 10px;
    }

    #sidebar ul li a {
        padding: 10px 16px;
        font-size: 1.1em;
        display: block;
        color: #000;
    }

    #sidebar ul li a:hover {
        color: #7386d5;
        background: #fff;
    }

    #sidebar ul li.active>a,
    #sidebar a[aria-expanded="true"] {
        color: #007bff;
        background: #e6f2ff;
        border-radius: 6px;
    }

    a[data-toggle="collapse"] {
        position: relative;
    }

    #sidebar .links .dropdown-toggle::after {
        display: block;
        position: absolute;
        top: 50%;
        right: 20px;
        transform: translateY(-50%);
    }

    section {
        padding: 6rem;
        background: #e4e4e4;
        margin-bottom: 30px;
        position: relative;
        z-index: 1;
    }

    .overlay {
        background: rgba(0, 0, 0, 0.7);
        height: 100vh;
        left: 0;
        position: fixed;
        top: 0;
        -webkit-transition: all 0.5s ease-in-out;
        transition: all 0.5s ease-in-out;
        z-index: -1;
        width: 100%;
        opacity: 0;
    }

    .overlay.visible {
        opacity: 1;
        z-index: 5000;
    }

    /* .mobiHeader .menuActive~.overlay {
    opacity: 1;
    width: 100%;
} */

    ul.social-icons {
        list-style-type: none;
        padding-left: 0;
        margin-bottom: 0;
    }

    ul.social-icons li {
        display: inline-block;
        margin-right: 0px;
        margin-bottom: 0;
    }

    #sidebar ul.social-icons li a {
        font-size: 24px;
    }

    .utility-nav {
        background: #ffffff;
        padding: 0.5rem 1rem;
    }

    .utility-nav p {
        margin-bottom: 0;
    }

    .search-bar {
        position: relative;
        z-index: 2;
        box-shadow: 0px 2px 15px 0px rgba(0, 0, 0, 0.1);
    }

    .search-bar .form-control {
        width: calc(100% - 45px);
    }

    .avatar {
        border-radius: 50%;
        width: 4.5rem;
        height: 4.5rem;
        margin-right: 8px;
    }

    .avatar.avatar-xs {
        width: 2.25rem;
        height: 2.25rem;
    }

    .user-dropdown .dropdown-menu {
        left: auto;
        right: 0;
    }

    .navbar-nav {
        padding-top: 10px;
        padding-bottom: 10px;
    }

    .nav-link {
        font-weight: 600;
        font-size: 16px;
        padding: 5px 15px !important;
        padding-left: 0px !important;
        padding-right: 30px !important;
        /* border: 1px solid red; */
    }

    .navbar .rightBtn {
        font-weight: 600;
        padding-top: 25px;
        height: 70px;
    }

    .custom-nav-item {}

    .navbar-logo {
        max-height: 60px;
        width: 120%;
        height: auto;
    }

    @media (max-width: 1200px) {

        /* For large desktops */
        .navbar-logo {
            max-height: 50px;
        }
    }

    @media (max-width: 992px) {

        /* For tablets and small desktops */
        .navbar-logo {
            max-height: 40px;
        }
    }

    @media (max-width: 768px) {

        /* For tablets and small devices */
        .navbar-logo {
            max-height: 35px;
        }

        .main-menu {
            padding: 0px;
        }

    }

    @media (max-width: 576px) {

        /* For small mobile devices */
        .navbar-logo {
            max-height: 30px;
        }
    }

    @media (max-width: 400px) {

        /* For extra small mobile devices */
        .navbar-logo {
            max-height: 25px;
        }
    }

    .top-right-icons {
        top: 10px;
        text-align: right;
        padding-right: 15px;

    }

    .top-right-icons a {
        color: #333;
        font-size: 16px;
    }

    .btn-nav {

        padding: 10px 20px;
        border-radius: 5px;
        font-size: 16px;
        border: none;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    /* Button hover effect */
    .btn-nav:hover {
        background-color: #0056b3;
        color: #fff;
    }

    /* Styles for tablets and small desktops (max-width: 992px) */
    @media (max-width: 992px) {
        .btn-nav {
            padding: 8px 16px;
            font-size: 14px;
            border-radius: 4px;
        }
    }

    /* Styles for tablets and small devices (max-width: 768px) */
    @media (max-width: 768px) {
        .btn-nav {
            padding: 8px;
            font-size: 13px;
        }
    }
</style>



<div class="custom-menu">

    @if (theme()->headline() != '')
        <div class="utility-nav d-none d-md-block">
            <div class="container text-center">
                <p class="small" style="font-weight: bold">{{ theme()->headline() }}</p>
            </div>
        </div>
    @endif

    {{-- <div class="utility-nav">
        <div class="container">
            <div class="top-right-icons">
                <a href="#" class="text-dark mr-3"><i class="fas fa-phone"></i></a> <!-- Phone Icon -->
                <a href="#" class="text-dark mr-3"><i class="fas fa-envelope"></i></a> <!-- Email Icon -->
                <a href="#" class="text-dark"><i class="fas fa-shopping-cart"></i></a> <!-- Cart Icon -->
            </div>
        </div>
    </div> --}}

    <nav class="navbar navbar-expand-md main-menu" style="box-shadow:none;">

        <div class="container">

            <button type="button" id="sidebarCollapse" class="btn btn-link d-block d-md-none">
                <i class="bx bx-menu icon-single"></i>
            </button>

            <a class="navbar-brand" href="{{ route('home.index') }}">
                <img src="{{ theme()->logo() }}" class="navbar-logo" alt="">
            </a>

            <ul class="navbar-nav ml-auto d-block d-md-none mr-2">

                <a href="">
                    <li class="btn btn-danger btn-nav btn-sm custom-nav-item nav-item" style="">
                        @if (auth()->check())
                            <form method="POST" class="btn btn-danger btn-nav" style="padding: 5px"
                                action="{{ route('logout') }}">
                                @csrf
                                <a href="" class="btn-danger btn-nav" style=""
                                    onclick="event.preventDefault(); this.closest('form').submit();">
                                    <i class="fas fa-sign-out-alt"></i> সাইন আউট
                                </a>
                            </form>
                        @endif
                    </li>
                </a>
                <a data-turbolinks="{{ auth()->check() ? 'false' : 'true' }}"
                    href="{{ route(auth()->check() ? 'profile.index' : 'login') }}">
                    <li class="btn btn-primary btn-nav custom-nav-item nav-item">
                        <i class="bx bxs-user mr-1"></i>
                        {{ auth()->check() ? 'প্রোফাইল' : 'লগ ইন' }}
                    </li>
                </a>
            </ul>

            <div class="collapse navbar-collapse">
                <div class="form-inline my-2 my-lg-0 mx-auto">

                </div>
                <div style="">
                    <ul class="navbar-nav">
                        {{-- <li class="btn custom-nav-item nav-item">
                            <a class="" href="tel:{{ theme()->mobile() }}">
                                <span class="rightBtn">
                                    <i class="bx bxs-phone mr-1"></i>{{ theme()->mobile() }}
                                </span>
                            </a>
                        </li> --}}
                        <li class="btn custom-nav-item nav-item">
                            @if (auth()->check())
                                <form method="POST" class="btn btn-danger btn-nav" style="padding: 0px"
                                    action="{{ route('logout') }}">
                                    @csrf
                                    <a href="" class="btn-danger btn-nav" style=""
                                        onclick="event.preventDefault(); this.closest('form').submit();">
                                        <i class="fas fa-sign-out-alt"></i> সাইন আউট
                                    </a>
                                </form>
                            @endif

                            <a class="btn btn-primary btn-nav"
                                data-turbolinks="{{ auth()->check() ? 'false' : 'true' }}"
                                href="{{ route(auth()->check() ? 'profile.index' : 'login') }}"><i
                                    class="bx bxs-user mr-1"></i> {{ auth()->check() ? 'প্রোফাইল' : 'লগ ইন' }} </a>
                        </li>

                    </ul>
                </div>
            </div>

        </div>
    </nav>
    <div class="navlink-desktop">
        <nav class="navbar navbar-expand-md navlink-desktop theme-bg sub-menu" style="">
            <div class="container">
                <div class="collapse navbar-collapse" id="navbar" style=" text-align: left!important">
                    <ul class="navbar-nav  flex-wrap" style="">
                        @php
                            $headers = theme()->header();
                        @endphp

                        @foreach ($headers as $header)
                            <li class="nav-item">
                                <a class="nav-link" href="{{ $header->url }}"> {{ $header->title }}</a>
                            </li>
                        @endforeach

                    </ul>
                </div>
            </div>
        </nav>
    </div>

    <!-- Sidebar -->
    <nav id="sidebar">
        <div class="sidebar-header">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-10 pl-0">
                        <a class="btn btn-success" href="tel:{{ theme()->mobile() }}"><i class="bx bxs-phone mr-2"></i>
                            Hot Line</a>
                        <a class="btn btn-primary" href="{{ route('home.index') }}"><i class="bx bx-home mr-1"></i>
                            Home</a>
                    </div>
                    <div class="col-2 text-left">
                        <button type="button" id="sidebarCollapseX" class="btn btn-link">
                            <i class="bx bx-x icon-single"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <ul class="list-unstyled components links">

            <li class="">
                <a href="{{ route('home.index') }}"><i class="bx bx-home mr-3"></i> Home</a>
            </li>

            <li style="">

                <ul class="list-unstyled" style="padding-left: 35px" id="pageSubmenu">

                    @foreach ($headers as $key => $header)
                        @php
                            if ($key == 0) {
                                continue;
                            }
                        @endphp
                        <li class="" style="border-top: 1px solid #eeeeee">
                            <a href="{{ $header->url }}"> {{ $header->title }}</a>
                        </li>
                    @endforeach
                </ul>
            </li>
        </ul>

    </nav>
</div>
@push('scripts')
    <script>
        $(document).ready(function() {
            $("#sidebarCollapse").on("click", function() {
                $("#sidebar").addClass("active");
            });

            $("#sidebarCollapseX").on("click", function() {
                $("#sidebar").removeClass("active");
            });

            $("#sidebarCollapse").on("click", function() {
                if ($("#sidebar").hasClass("active")) {
                    $(".overlay").addClass("visible");
                    console.log("it's working!");
                }
            });

            $("#sidebarCollapseX").on("click", function() {
                $(".overlay").removeClass("visible");
            });
        });
    </script>
@endpush
