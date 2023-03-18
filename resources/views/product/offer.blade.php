<link rel="stylesheet" href="http://127.0.0.1:8000/vendor/adminlte/dist/css/adminlte.min.css">
<style>
    .productArea {
        padding: 5px;
        width: 70%;
        margin-left: 150px;
        border: 1px solid #f5f5f5;
    }

    .productAreaMiddle {}

    .productBox {
        background: #FDD4DA;
        height: 300px;
        width: 100%;
        text-align: center;
        margin-top: 5px;
        vertical-align: middle;
        overflow: hidden;
    }

    .productImg {
        height: 150px;
        width: 150px;
    }

    .priceBody{
        font-weight: bold;
        font-size: 14px;
        margin-top: 15px;
    }

    .discountLebel {
        position: absolute;
        text-align: center;
        color: #ffffff;
        margin-top: 10px;
        margin-left: -26px;
        background-color: #c0392b;
        width: 82px;
        transform: rotate(310deg);
        font-size: 12px;
        padding: 3px 0px 3px 3px;
        box-shadow: 0 2px 4px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
    }

    .priceLabel {
        background: #EF6F6C;
        border-radius: 100%;
        position: absolute;
        top: 70%;
        height: 70px;
        width: 70px;
        vertical-align: middle;
    }

    .banner {
        height: 630px;
        width: 100%;
        
        background: #F46F2E;
    }
</style>

<div class="productArea">
    <div class="row">
        <div class="col-md-3">
            <div class="row">
                <div class="col-md-12">
                    @include('product.offer_products')
                </div>
                <div class="col-md-12">
                    @include('product.offer_products')
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="banner">
                <img style="width: 50px; height: 70px" src="https://www.pngkey.com/png/full/160-1605477_mosque-chandelier-png-lantern-ramadan-png.png" alt="">
            </div>
        </div>
        <div class="col-md-3">
            <div class="row">
                <div class="col-md-12">
                    @include('product.offer_products')
                </div>
                <div class="col-md-12">
                    @include('product.offer_products')
                </div>
            </div>
        </div>
        @for ($i = 1; $i <= 8; $i++)
            <div class="col-md-3">
                @include('product.offer_products')
            </div>
        @endfor

    </div>
</div>

<script src="http://127.0.0.1:8000/js/app.js?id=ff2420ecea5efcba17552eeef46983c8"></script>
