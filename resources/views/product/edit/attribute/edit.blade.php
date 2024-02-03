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

<form action="{{ route('product_attributes.update',request()->route()->parameters()) }}" method="post">
    @csrf
    @method('PUT')
    <div class="mb-3 row">
        <label for="categories" class="col-sm-3 col-form-label form-control-label" for="name">Attribute</label>
        <div class="col-sm-9">
            <input type="text" value="{{ $attribute->name }}" class="form-control" id="select_attribute" disabled>
        </div>
    </div>
    <div class="mb-3 row">
        <label for="categories" class="col-sm-3 col-form-label form-control-label" for="attribute_values">Values</label>
        <div class="col-sm-9">
            <select class="form-control" id="attribute_values" name="attribute_values[]" multiple="multiple">
                @php
                    $attributeValues = $attribute->values;
                @endphp
                @foreach ($attributeValues as $attributesValue)
                    <option value="{{ $attributesValue->value->uuid }}" selected>{{ $attributesValue->name }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="mb-3 row">
        <label for="categories" class="col-sm-3 col-form-label form-control-label" for="image"></label>
        <div class="col-sm-9">
            <button type="submit" class="btn btn-success">Update Attribute</button>
        </div>
    </div>
</form>

<script>
    $('#attribute_values').select2({
        dropdownParent: Helper.currentModal().body,
        placeholder: 'Select Values',
        allowClear: true,
        ajax: {
            url: "{{ route('product_attributes.select2_data') }}",
            data: {
                'attribtue': "{{ $attribute->attribute->uuid }}"
            },
            dataType: 'json',
            delay: 250,
            processResults: function(response) {
                return {
                    results: $.map(response, function(res) {
                        return {
                            text: res.name,
                            id: res.uuid,
                        }
                    })
                };
            },
            cache: true
        }
    });
</script>
