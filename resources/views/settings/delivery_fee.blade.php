<div class="tab-pane fade" id="DeliveryFee" role="tabpanel" aria-labelledby="SocialLinks-tab">
    @foreach ($delivaryFeeSettingOptions as $settingOption)
    <div class="form-group row">
        <label class="col-sm-2 col-form-label col-form-label-sm"><b>{{ $settingOption->title }}:
            </b></label>
        <div class="col-sm-8">
            <input type="number" class="form-control form-control-sm" placeholder="Enter {{ $settingOption->title }}" name="{{ $settingOption->key }}"
                value="{{ $settingOption->value }}">
        </div>
    </div>
    @endforeach
</div>
