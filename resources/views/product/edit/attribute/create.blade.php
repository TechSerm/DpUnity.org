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

<form action="{{ route('product_attributes.store',request()->route()->parameters()) }}" method="post">
    @csrf
    <div class="mb-3 row">
        <label for="categories" class="col-sm-3 col-form-label form-control-label" for="image">Attribute</label>
        <div class="col-sm-9">
            <select class="form-control" id="select_attribute" onchange="selectAttribute()" name="attribute_id">
                <option value="">Select Attribute</option>
                @foreach ($attribtues as $attribtue)
                    <option value="{{ $attribtue->uuid }}">{{ $attribtue->name }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="mb-3 row">
        <label for="categories" class="col-sm-3 col-form-label form-control-label" for="image">Values</label>
        <div class="col-sm-9">
            <select class="form-control" id="attribute_values" name="attribute_values[]" disabled multiple="multiple">
            </select>
        </div>
    </div>

    <div class="mb-3 row">
        <label for="categories" class="col-sm-3 col-form-label form-control-label" for="image"></label>
        <div class="col-sm-9">
            <button type="submit" class="btn btn-success">Add Attribute</button>
        </div>
    </div>
</form>

<script>
    function selectAttribute() {
        $('#attribute_values').val("");
        let attribute = $("#select_attribute").val();
        if (attribute == "") {
            $("#attribute_values").attr("disabled", "true");
        } else {
            $("#attribute_values").prop("disabled", false);
        }

        initAttributeSelect2();
    }

    function initAttributeSelect2() {
        $('#attribute_values').select2({
            dropdownParent: Helper.currentModal().body,
            placeholder: 'Select Values',
            allowClear: true,
            ajax: {
                url: "{{ route('product_attributes.select2_data') }}",
                data: {
                    'attribtue': $("#select_attribute").val()
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
                cache: false
            }
        });
    }

    initAttributeSelect2();
    
</script>
