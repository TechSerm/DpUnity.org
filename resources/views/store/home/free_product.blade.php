<div class="home-list IftarArea" style="background: #046349">
    <div style="coverImage">
        <img class=""
            src="{{asset('assets/img/free.png')}}"
            style="width: 100%;" alt="">
    </div>
<style>
    .offerUl li {
        padding: 3px 0px 3px 0px;
    }
</style>
    <div style="background: #fffff; padding: 0px;">
        <div class="card header" style="font-weight: bold; padding: 5px; background: #c0392b; color: #ffffff">
            বিবিসেনায় ফ্রি পটেটো চিপস অফার
        </div>
        <div class="home-list-body" style="">
            <div class="card-headerr  mb-3" style="padding: 5px;background: #e74c3c; color: #ffffff">
                <ul class="offerUl" style="margin-left: -20px;margin-bottom: 0px">
                    <li> এই অফারটি পেতে আপনাকে অন্য কোনো পণ্য অর্ডার করা লাগবে না।</li>
                    <li> বিবিসেনা মোবাইল এপ (<a style="color: green; font-weight: bold" href='https://app.bibisena.com/'>app.bibisena.com</a>) দিয়ে অর্ডার করতে হবে।</li>
                    <li> কোন ডেলিভারি ফী দিতে হবে না।</li>
                    <li> অর্ডার করার সাথে সাথে ডেলিভারি ম্যান পটেটো চিপস টি আপনার ঠিকানায় পৌঁছাই দিবে, আপনাকে কোন টাকা দিতে হবে না।</li>
                    <li> একটি নাম্বার এবং একটি মোবাইল থেকে একবার অর্ডার করা যাবে।</li>
                </ul>
            </div>
            <div class="row no-gutters" style="padding: 5px;">
                @livewire('shop-product', ['product' => $freeProduct])
            </div>
        </div>
    </div>
</div>
