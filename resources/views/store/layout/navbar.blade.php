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
        width: 80%!important;
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
            width: 100%!important;
        }
    }

    .cbtn:focus {
        outline: none;
    }

    .cbtn.active {
        background: #6352b9;
        color: #ffffff;
    }
</style>
<div class="custom-menu">

    <header class="header" id="header">
        <nav class="cnav">
            <div class="container">
                <div class="leftSide" style="float:left;">
                    <div class="pl-0 d-flex align-items-center" style="float:left">
                        <a href="/" class="py-10px mr-3 ml-0 " style="float: left" class=""> <img
                                class="logo" src="{{ asset('assets/img/bibisena_logo.jpg') }}" alt=""></a>
                        {{-- <a href="/" class="btn cbtn {{ request()->segment(1) == '' ? 'active' : '' }}"><i
                                class="fa fa-home" aria-hidden="true"></i> হোম</a>
                        <a href="/categories"
                            class="btn cbtn {{ request()->segment(1) == 'categories' ? 'active' : '' }}"><i
                                class="fa fa-list-alt" aria-hidden="true"></i> ক্যাটেগরি</a>
                        <a href="{{ route('store.order.list') }}"
                            class="btn cbtn {{ request()->segment(1) == 'order' ? 'active' : '' }}"><i
                                class="fa fa-shopping-cart" aria-hidden="true"></i> অর্ডার</a> --}}


                    </div>
                </div>
                <div style="float: right;" class="rightSide">
                    @include('store.layout.search_box')
                </div>
            </div>
            @livewire('shop-footer')
        </nav>
    </header>
</div>
