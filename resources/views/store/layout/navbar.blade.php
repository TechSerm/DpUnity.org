<div class="custom-menu">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css">
    <header class="header" id="header">
        <nav class="cnav container">

            <a href="/" style="float: left" class=""><img src="https://bibisena.com/wp-content/uploads/2022/08/Test-8-1.png"
                    height="45px" alt=""> </a>
            
            <div class="nav-mobile-footer-menu" style="{{ $totalCart > 0 ? '' : 'display: none' }}" id="nav-menu">
                @include('store.layout.mobile_menu')
            </div>
            <div class="nav__menu" style="float: right" id="nav-menu">
                <ul class="nav__list">
                    <li class="nav__item">
                        <a href="{{route('home')}}" class="nav__link active-link">
                            <i class='bx bx-home-alt nav__icon'></i>
                            <span class="nav__name">হোম</span>
                        </a>
                    </li>

                    <li class="nav__item">
                        <a href="{{route('home')}}" class="nav__link">
                            <i class='fa fa-list nav__icon'></i>
                            <span class="nav__name">Category</span>
                        </a>
                    </li>


                    <li class="nav__item">
                        <a href="{{route('search')}}" class="nav__link">
                            <i class='fa fa-search nav__icon'></i>
                            <span class="nav__name">খুজুন</span>
                        </a>
                    </li>
                </ul>
            </div>
        </nav>
    </header>
</div>
