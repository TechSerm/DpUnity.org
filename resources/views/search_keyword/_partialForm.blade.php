@php
$labelWidth = 4;
$inputWidth = 6;
@endphp
<style>
    .select2-selection__choice__display {
        color: black;
        text-align: center;
        margin-left: 5px;
        padding: 5px 5px 3px 5px !important;
    }

    .select2-search__field {
        padding: 0px !important;
        border: 0px solid green !important;
        border-radius: 0px;
    }
</style>

<div class="mb-3 row ">
    <label for="key" class="col-sm-{{ $labelWidth }} col-form-label form-control-label">Key</label>
    <div class="col-sm-{{ $inputWidth }}">
        {!! Form::text('key', null, ['class' => 'form-control ', 'id' => 'name','readonly']) !!}
    </div>
</div>

<div class="mb-3 row">
    <label for="values" class="col-sm-{{ $labelWidth }} col-form-label form-control-label">Values</label>
    <div class="col-sm-{{ $inputWidth }}">
        <select class="form-control" id="values" name="values[]" multiple="multiple">
            @php
                $values = $searchKeyword->values;
            @endphp
            @foreach ($values as $value)
                <option value="{{$value->value}}" selected>{{$value->value}}</option>
            @endforeach
        </select>

    </div>
</div>

<div class="mb-3 row">
    <label for="inputPassword" class="col-sm-{{ $labelWidth }} col-form-label form-control-label"></label>
    <div class="col-sm-{{ $inputWidth }}">
        <button type="submit" class="btn btn-success">Save Keyword</button>
    </div>
</div>


<script>

    $("#values").select2({
        tags: true,
        tokenSeparators: []
    })
</script>
