
<style>
    .dashboardReportSubArea{
        background: #f8f8f8; 
        padding: 10px; 
        border: 1px solid #eeeeee;
    }
</style>
@can('dashboard.profit.all_status')
<div style="" class="dashboardReportSubArea">
    <div class="row">
        <div class="col-md-3 col-sm-6">
            <x-adminlte-small-box title="{{ $order['total_order'] }}" text="সর্বমোট অর্ডার" icon="fas fa-shopping-cart"
                theme="info" />
        </div>
        <div class="col-md-3 col-sm-6">
            <x-adminlte-small-box title="{{ $order['pending'] }}" text="পেন্ডিং অর্ডার" icon="fas fa-clock"
                theme="warning" />
        </div>
        <div class="col-md-3 col-sm-6">
            <x-adminlte-small-box title="{{ $order['processing'] }}" text="প্রস্তুতি চলছে" icon="fas fa-clock"
                theme="info" />
        </div>
        <div class="col-md-3 col-sm-6">
            <x-adminlte-small-box title="{{ $order['canceled'] }}" text="বাতিল করা হয়েছে" icon="fas fa-times"
                theme="danger" />
        </div>
        <div class="col-md-3 col-sm-6">
            <x-adminlte-small-box title="{{ $order['complete'] }}" text="ডেলিভারি সম্পন্ন হয়েছে" icon="fas fa-check"
                theme="success" />
        </div>
    </div>
</div>
<div style="" class="dashboardReportSubArea">
    <div class="row">
        
        <div class="col-md-3 col-sm-6">
            <x-adminlte-small-box title="{{ $order['vendor_payment_pending'] }}" text="বিক্রেতার বাকি আছে"
                icon="fas fa-times" theme="danger" />
        </div>
        <div class="col-md-3 col-sm-6">
            <x-adminlte-small-box title="{{ $order['vendor_payment_send'] }}" text="বিক্রেতাকে পাঠানো হয়েছে"
                icon="fas fa-clock" theme="warning" />
        </div>
        <div class="col-md-3 col-sm-6">
            <x-adminlte-small-box title="{{ $order['vendor_payment_complete'] }}" text="বিক্রেতা পেয়েছে"
                icon="fas fa-check" theme="success" />
        </div>
    </div>
</div>
@endcan
@can('dashboard.profit')
<div class="dashboardReportSubArea mt-3">
    <div class="row">
        <div class="col-md-3 col-sm-6">
            <x-adminlte-small-box title="{{ $profit['product_profit'] }}" text="পণ্যে লাভ"
                icon="fas fa-check" theme="success" />
        </div>
        <div class="col-md-3 col-sm-6">
            <x-adminlte-small-box title="{{ $profit['profit_percent'] }}" text="পণ্যে শতকরা লাভ "
                icon="fas fa-check" theme="success" />
        </div>
        @if(!(isset(request()->vendor) && request()->vendor != ""))
        <div class="col-md-3 col-sm-6">
            <x-adminlte-small-box title="{{ $profit['delivery_profit'] }}" text="সর্বমোট ডেলিভারি"
                icon="fas fa-check" theme="success" />
        </div>
        <div class="col-md-3 col-sm-6">
            <x-adminlte-small-box title="{{ $profit['total_profit'] }}" text="সর্বমোট (লাভ + ডেলিভারি)"
                icon="fas fa-check" theme="success" />
        </div>
        @endif
    </div>
</div>
@endcan
@can('dashboard.profit.cashier')
<div class="dashboardReportSubArea mt-3">
    <div class="row">
        <div class="col-md-3 col-sm-6">
            <x-adminlte-small-box title="{{ $profit['total_profit'] }}" text="ক্যাশ এ যুক্ত হবে"
                icon="fas fa-check" theme="success" />
        </div>
    </div>
</div>
@endcan
