<style>
    .IftarArea {}

    .IftarArea .coverImage {
        z-index: 300;
    }

    .IftarArea .header {

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

<div class="home-list IftarArea">
    <div style="coverImage">
        <img class=""
            src="{{asset('assets/img/ramadan_bd.webp')}}"
            style="width: 100%;height: 140px;" alt="">
    </div>

    <div style="background: #9fa8d2; margin-left: -2px;padding: 15px;">
        <div class="card header" style="">
            ইফতারের বাজার
        </div>
        <div class="home-list-body" style="margin-right: -19px;margin-left: -10px;">
            <div class="card-header  mb-3" style="background: #e67e22; color: #ffffff">
                ইফতার সামগ্রী অর্ডার করলে আপনাকে অবশ্যই বিকাল ৫ টার মধ্যে অর্ডার করতে হবে।  বিকাল ৫ টার পর অর্ডার করলে আপনার অর্ডারটি পরের দিন দেয়া হবে। 
            </div>
            <div class="row no-gutters" style="">
                @include('store.product.single_product_page', ['products' => $iftarCategoryProducts])
            </div>
        </div>
    </div>
</div>
