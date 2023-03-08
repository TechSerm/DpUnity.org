<style>
    .ramadanArea {}

    .ramadanArea .coverImage {
        z-index: 300;
    }

    .ramadanArea .header {

        text-align: center !important;
        background: rgba(29, 23, 42, 0.9);
        padding: 10px;
        font-size: 25px;
        color: #ffffff;
        font-weight: bold;
        margin-top: -55px;
        margin-bottom: 15px;
        box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);

    }
</style>

<div class="home-list ramadanArea">
    <div style="coverImage">
        <img class=""
            src="{{asset('assets/img/ramadan_bd.webp')}}"
            style="width: 100%;height: 140px;" alt="">
    </div>

    <div style="background: #9fa8d2; margin-left: -2px;padding: 15px;">
        <div class="card header" style="">
            <div style="font-size: 12px;">বিবিসেনায় সাশ্রয় মূল্যে করুন</div> 
            রমজানের বাজার
        </div>
        <div class="home-list-body" style="margin-right: -19px;margin-left: -10px;">
            <div class="row no-gutters" style="">
                @include('store.product.single_product_page', ['products' => $ramadanCategoryProducts])
            </div>
        </div>
    </div>
</div>
