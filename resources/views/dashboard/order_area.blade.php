
<style>
    .dashboardReportSubArea{
        background: #f8f8f8; 
        padding: 10px; 
        border: 1px solid #eeeeee;
    }
</style>

<div style="" class="dashboardReportSubArea">
    @php
        $allOrders = theme()->getLableCount("all orders");
        $processing = theme()->getLableCount("processing");
        $confirmed = theme()->getLableCount("confirmed");
        $shipped = theme()->getLableCount("shipped");
        $delivered = theme()->getLableCount("delivered");
        $completed = theme()->getLableCount("completed");
        $canceled = theme()->getLableCount("canceled");
    @endphp
    <div class="row">
        <div class="col-md-3 col-sm-6">
            <x-adminlte-small-box title="{{ $allOrders }}" text="All Orders" icon="fas fa-shopping-cart"
                theme="info" />
        </div>
        <div class="col-md-3 col-sm-6">
            <x-adminlte-small-box title="{{ $processing }}" text="Processing" icon="fas fa-clock"
                theme="secondary" />
        </div>
        <div class="col-md-3 col-sm-6">
            <x-adminlte-small-box title="{{ $confirmed }}" text="Confirmed" icon="fas fa-clock"
                theme="primary" />
        </div>
        <div class="col-md-3 col-sm-6">
            <x-adminlte-small-box title="{{ $shipped }}" text="Shipped" icon="fa fa-ship"
                theme="info" />
        </div>
        
        <div class="col-md-3 col-sm-6">
            <x-adminlte-small-box title="{{ $completed }}" text="Completed" icon="fas fa-check"
                theme="success" />
        </div>
        <div class="col-md-3 col-sm-6">
            <x-adminlte-small-box title="{{ $delivered }}" text="Delivered" icon="fas fa-check"
                theme="success" />
        </div>
        <div class="col-md-3 col-sm-6">
            <x-adminlte-small-box title="{{ $canceled }}" text="Canceled" icon="fas fa-times"
                theme="danger" />
        </div>
    </div>
</div>