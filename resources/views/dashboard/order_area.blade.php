
<style>
    .dashboardReportSubArea{
        background: #f8f8f8; 
        padding: 10px; 
        border: 1px solid #eeeeee;
    }
</style>
@can('dashboard.profit.all_status')
{{-- <div style="" class="dashboardReportSubArea">
    <div class="row">
        <div class="col-md-3 col-sm-6">
            <x-adminlte-small-box title="{{ $order['total_order'] }}" text="Processing" icon="fas fa-shopping-cart"
                theme="info" />
        </div>
        <div class="col-md-3 col-sm-6">
            <x-adminlte-small-box title="{{ $order['pending'] }}" text="Confirmed" icon="fas fa-clock"
                theme="warning" />
        </div>
        <div class="col-md-3 col-sm-6">
            <x-adminlte-small-box title="{{ $order['processing'] }}" text="Shipped" icon="fas fa-clock"
                theme="info" />
        </div>
        <div class="col-md-3 col-sm-6">
            <x-adminlte-small-box title="{{ $order['canceled'] }}" text="Canceled" icon="fas fa-times"
                theme="danger" />
        </div>
        <div class="col-md-3 col-sm-6">
            <x-adminlte-small-box title="{{ $order['complete'] }}" text="Completed" icon="fas fa-check"
                theme="success" />
        </div>
        <div class="col-md-3 col-sm-6">
            <x-adminlte-small-box title="{{ $order['complete'] }}" text="Delivered" icon="fas fa-check"
                theme="success" />
        </div>
    </div>
</div> --}}
@endcan