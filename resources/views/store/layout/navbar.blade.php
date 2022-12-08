<div class="custom-menu">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css">
    <header class="header" id="header">
        <nav class="cnav">
            
            <div class="pl-0 d-flex align-items-center" style="float:left">
                <span class="mr-2 mt-1" style="font-size: 30px" id="toggleIcon" onclick="Store.menu.sidebarToggle()"><i class="fa fa-bars"></i></span>
                <a href="/" class="d-block py-10px mr-3 ml-0" style="float: left" class=""> <img height="45px"
                    src="{{ asset('assets/img/bibisena_logo.png') }}" alt=""></a>

            </div>

            @include('store.layout.mobile_menu')

            <div class="nav__menu" style="float: right" id="nav-menu">
                <ul class="nav__list">
                    <li class="nav__item">
                        <a href="{{ route('home') }}" class="nav__link active-link">
                            <i class='bx bx-home-alt nav__icon'></i>
                            <span class="nav__name">হোম</span>
                        </a>
                    </li>

                    {{-- <li class="nav__item">
                        <a href="{{ route('home') }}" class="nav__link">
                            <i class='fa fa-list nav__icon'></i>
                            <span class="nav__name">Category</span>
                        </a>
                    </li> --}}

                    <li class="nav__item">
                        <a href="{{ route('search') }}" class="nav__link">
                            <i class='fa fa-search nav__icon'></i>
                            <span class="nav__name">খুজুন</span>
                        </a>
                    </li>
                </ul>
            </div>
        </nav>
        
    </header>
</div>


