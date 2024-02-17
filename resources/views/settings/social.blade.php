<div class="tab-pane fade" id="SocialLinks" role="tabpanel" aria-labelledby="SocialLinks-tab">
    @foreach ($socialSettingOptions as $settingOption)
    <div class="form-group row">
        <label class="col-sm-2 col-form-label col-form-label-sm"><b>{{ $settingOption->title }}:
            </b></label>
        <div class="col-sm-8">
            <input type="text" class="form-control form-control-sm" placeholder="Enter {{ $settingOption->title }}" name="{{ $settingOption->key }}"
                value="{{ $settingOption->value }}">
        </div>
    </div>
    @endforeach
</div>
