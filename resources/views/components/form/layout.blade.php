<div class="mb-3 row">
    @php
        $label = $attributes['label'] ?? ucwords($name);
        $requried = in_array('required', $attributes) ? true : false;
        $label .= $requried ? ' <font color="red" title="Requried">*</font>' : '';
        $options = array_merge(['class' => 'form-control' . ($errors->has($name) ? ' is-invalid' : '')], $attributes);
        
    @endphp

    <label for="name" class="col-sm-3 col-form-label form-control-label">
        {!! $label !!}
    </label>
    <div class="col-sm-3">
        @yield('type', ['options' => $options])
        @error('name')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>
