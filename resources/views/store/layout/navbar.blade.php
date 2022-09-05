<div class="custom-menu">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css">
<header class="header" id="header">
    <nav class="nav container">
        <a href="/" class="nav__logo"><img src="https://bibisena.com/wp-content/uploads/2022/08/Test-8-1.png" height="60px" alt=""> </a>

        <div class="nav__menu" id="nav-menu">
            <ul class="nav__list">
                @if ($totalCart > 0)
                    <a href="{{route('cart')}}" class="cart"><i class="fa fa-shopping-bag" aria-hidden="true"></i> বাজার
                        <span style="float: right;">
                            <span class="amount">৳ {{convertBanglaNumber($totalCart)}}</span>
                        </span>
                    </a>
                @endif


                <li class="nav__item">
                    <a href="#home" class="nav__link active-link">
                        <i class='bx bx-home-alt nav__icon'></i>
                        <span class="nav__name">Home</span>
                    </a>
                </li>

                <li class="nav__item">
                    <a href="#about" class="nav__link">
                        <i class='bx bx-user nav__icon'></i>
                        <span class="nav__name">Category</span>
                    </a>
                </li>
            </ul>
        </div>

        <img src="assets/img/perfil.png" alt="" class="nav__img">
    </nav>
</header>
</div>