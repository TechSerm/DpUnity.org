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
        padding: 0.5rem 1.5rem;
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
        background: #e4e4e4;
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
        padding-left: 0px!important;
        padding-right: 30px!important;
        /* border: 1px solid red; */
    }
</style>



<div class="custom-menu">

    <div class="utility-nav d-none d-md-block">
        <div class="container text-center">
            <p class="small" style="font-weight: bold">Welcome To TechSerm Ecommerce</p>

        </div>
    </div>

    <nav class="navbar navbar-expand-md navbar-light bg-light main-menu" style="box-shadow:none">
        <div class="container">
            <button type="button" id="sidebarCollapse" class="btn btn-link d-block d-md-none">
                <i class="bx bx-menu icon-single"></i>
            </button>

            <a class="navbar-brand" href="{{ route('home') }}">
                <img src="data:image/png;base64,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" height="60" alt="">
            </a>

            <ul class="navbar-nav ml-auto d-block d-md-none">
                <li class="nav-item">
                    <a class="btn btn-link" href="cart"><i class="bx bxs-cart icon-single"></i> <span
                            class="badge badge-danger">3</span></a>
                </li>
            </ul>

            <div class="collapse navbar-collapse">
                <form class="form-inline my-2 my-lg-0 mx-auto">
                    <input class="form-control" type="search" placeholder="Search for products..." aria-label="Search">
                    <button class="btn btn-success my-2 my-sm-0" type="submit"><i class="bx bx-search"></i></button>
                </form>

                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="btn btn-link" href="cart"><i class="bx bxs-cart icon-single"></i> <span
                                class="badge badge-danger">3</span></a>
                    </li>
                    <li class="nav-item ml-md-3">
                        <a class="btn btn-primary" href="#"><i class="bx bxs-user-circle mr-1"></i> Log In /
                            Register</a>
                    </li>
                </ul>
            </div>

        </div>
    </nav>

    <nav class="navbar navbar-expand-md  theme-bg sub-menu" style="">
        <div class="container">
            <div class="collapse navbar-collapse" id="navbar" style=" text-align: left!important">
                <ul class="navbar-nav  flex-wrap" style="">
                    @for ($i = 1; $i <= 15; $i++)
                        <li class="nav-item">
                            <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
                        </li>
                    @endfor
                    <li class="nav-item">
                        <a class="nav-link" href="#">Products</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Schoolss</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Publishers</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Contact</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="search-bar d-block d-md-none">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <form class="form-inline mb-3 mx-auto">
                        <input class="form-control" type="search" placeholder="Search for products..."
                            aria-label="Search">
                        <button class="btn btn-success" type="submit"><i class="bx bx-search"></i></button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Sidebar -->
    <nav id="sidebar">
        <div class="sidebar-header">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-10 pl-0">
                        <a class="btn btn-primary" href="#"><i class="bx bxs-user-circle mr-1"></i> Log In</a>
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

            <li class="active">
                <a href="#"><i class="bx bx-home mr-3"></i> Home</a>
            </li>
            <li>
                <a href="#"><i class="bx bx-carousel mr-3"></i> Products</a>
            </li>
            <li>
                <a href="#"><i class="bx bx-book-open mr-3"></i> Schoolss</a>
            </li>
            <li>
                <a href="#"><i class="bx bx-crown mr-3"></i> Publishers</a>
            </li>
            <li>
                <a href="#pageSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"><i
                        class="bx bx-help-circle mr-3"></i>
                    Support</a>
                <ul class="collapse list-unstyled" id="pageSubmenu">
                    <li>
                        <a href="#">Delivery Information</a>
                    </li>
                    <li>
                        <a href="#">Privacy Policy</a>
                    </li>
                    <li>
                        <a href="#">Terms & Conditions</a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="#"><i class="bx bx-phone mr-3"></i> Contact</a>
            </li>
        </ul>

        <h6 class="text-uppercase mb-1">Categories</h6>
        <ul class="list-unstyled components mb-3">
            <li>
                <a href="#">Category 1</a>
            </li>
            <li>
                <a href="#">Category 1</a>
            </li>
            <li>
                <a href="#">Category 1</a>
            </li>
            <li>
                <a href="#">Category 1</a>
            </li>
            <li>
                <a href="#">Category 1</a>
            </li>
            <li>
                <a href="#">Category 1</a>
            </li>
        </ul>

        <ul class="social-icons">
            <li><a href="#" target="_blank" title=""><i class="bx bxl-facebook-square"></i></a></li>
            <li><a href="#" target="_blank" title=""><i class="bx bxl-twitter"></i></a></li>
            <li><a href="#" target="_blank" title=""><i class="bx bxl-linkedin"></i></a></li>
            <li><a href="#" target="_blank" title=""><i class="bx bxl-instagram"></i></a></li>
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
