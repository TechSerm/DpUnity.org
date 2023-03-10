<div class="row">
    <div class="col-md-3 col-sm-6">
        <x-adminlte-small-box title="{{ bnConvert()->number($totalProduct) }}" text="সর্বমোট পণ্য" icon="fas fa-gift" theme="info" />
    </div>
    <div class="col-md-3 col-sm-6">
        <x-adminlte-small-box title="{{ bnConvert()->number($totalActiveProduct) }}" text="সর্বমোট সচল পণ্য" icon="fas fa-gift" theme="success" />
    </div>
    <div class="col-md-3 col-sm-6">
        <x-adminlte-small-box title="{{ bnConvert()->number($totalCategory) }}" text="সর্বমোট ক্যাটাগরি" icon="fas fa-list" theme="info" />
    </div>
</div>
