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
        height: 200px;
        width: 100%;
        text-align: center;
    }

    .discountLabel {
        position: absolute;
        background: red;
        color: #ffffff;
        border: 1px solid green;
        padding: 30px;
        border-radius: 100%;
        font-size: 20px;
    }
    .banner{
        height: 220px;
        width: 100%;
        border-radius: 0px 0px 15px 15px;
    }
</style>

<div class="productArea">



    <div class="row">
        <div class="col-md-3">
            <div class="productBox">
                দেশী পেঁয়াজ
                ১ কেজি<br />
                <img src="https://www.bibisena.com/images/IG4X1sugqU045zwXgUnPm7KDDFmXiO1ArI58s7I1.jpg"
                    style="width: 70px" alt="">
                <div class="discountLabel">
                    185
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <img class="banner" src="https://img.freepik.com/free-vector/islamic-style-ramadan-kareem-eid-decorative-banner_1017-31082.jpg" alt="">
        </div>
        <div class="col-md-3">
            <div class="productBox">
                দেশী পেঁয়াজ
                ১ কেজি
                <img src="https://www.bibisena.com/images/IG4X1sugqU045zwXgUnPm7KDDFmXiO1ArI58s7I1.jpg"
                    style="width: 70px" alt="">
                <div class="discountLabel">
                    185
                </div>
            </div>
        </div>
        @for ($i=1; $i<=5; $i++)
        <div class="col-md-3">
            <div class="productBox">
                দেশী পেঁয়াজ
                ১ কেজি
                <img src="https://www.bibisena.com/images/IG4X1sugqU045zwXgUnPm7KDDFmXiO1ArI58s7I1.jpg"
                    style="width: 70px" alt="">
                <div class="discountLabel">
                    185
                </div>
            </div>
        </div>
        @endfor
    </div>
</div>

<script src="http://127.0.0.1:8000/js/app.js?id=ff2420ecea5efcba17552eeef46983c8"></script>
