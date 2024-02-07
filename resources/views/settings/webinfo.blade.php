

<div class="tab-pane fade show active" id="WebInfo" role="tabpanel" aria-labelledby="v-pills-WebInfo-tab">
    @foreach ($generalSettingOptions as $settingOption)
        <div class="form-group row">
            <label class="col-sm-2 col-form-label col-form-label-sm"
                for="{{ $settingOption->key }}"><b>{{ $settingOption->title }}:
                </b></label>
            <div class="col-sm-8">
                @if ($settingOption->isTextArea())
                    <textarea name="{{ $settingOption->key }}" placeholder="{{ $settingOption->title }}"
                        class="form-control form-control-sm" cols="30" rows="8">{{ $settingOption->value }}</textarea>
                @else
                    <input type="text" id="{{ $settingOption->key }}"
                        class="form-control form-control-sm colorpicker"
                        name="{{ $settingOption->key }}" value="{{ $settingOption->value }}"
                        placeholder="{{ $settingOption->title }}">
                @endif
            </div>
        </div>
    @endforeach
</div>

@push("scripts")


@endpush
