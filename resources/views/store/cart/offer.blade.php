@php
    $limit = env('OFFER_MIN');
@endphp
@if ($totalCartPrice < $limit)
    <div class="alert alert-warning" style="text-align: center; font-weight: bold" role="alert">
        বিবিসেনায় {{ bnConvert()->number($limit) }} টাকা বা তার বেশি বাজার করলেই একটি আকর্ষণীয় পানির বোতল ফ্রি। ফ্রি
        পানির বোতল পেতে আপনাকে আরো {{ bnConvert()->number($limit - $totalCartPrice) }} টাকার বাজার করতে হবে।<br />
        <img src="{{ asset('assets/img/water_bottle.png') }}" height="70px;" alt="">
    </div>
@else
    <div class="alert alert-success" style="text-align: center; font-weight: bold" role="alert">
        স্বাগতম, আপনি একটি আকর্ষণীয় পানির বোতল ফ্রি পাচ্ছেন।<br />
        <img src="{{ asset('assets/img/water_bottle.png') }}" height="70px;" alt="">
    </div>
@endif
