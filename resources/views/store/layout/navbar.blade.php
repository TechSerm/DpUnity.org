<div class="custom-menu">
    
    <header class="header" id="header">
        <nav class="cnav">
            <style>

            </style>
            <div style="float:left; width: 30%">
                <div class="pl-0 d-flex align-items-center" style="float:left">
                    <span class="sliderIcon mr-2 mt-1" style="font-size: 30px" id="toggleIcon"
                        onclick="Store.menu.sidebarToggle()"><i class="fa fa-bars"></i></span>
                    <a href="/" class="d-block py-10px mr-3 ml-0 mt-1" style="float: left" class=""> <img
                            height="35px" src="{{ asset('assets/img/bibisena_logo.png') }}" alt=""></a>

                </div>
            </div>
            <div style="float: right; width: 63%">
                @include('store.layout.search_box')
            </div>

            @livewire('shop-footer')

        </nav>

    </header>
</div>
