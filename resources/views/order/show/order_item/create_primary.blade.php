@php
$labelWidth = 4;
$inputWidth = 6;
@endphp

<div class="mb-3 row">
    <label for="inputPassword" class="col-sm-{{ $labelWidth }} col-form-label form-control-label">Select Product</label>
    <div class="col-sm-{{ $inputWidth }}">
        <select class="js-example-basic-single form-control" onchange="selectProduct()"  id="selectProduct" name="state">
            <option value="">Product</option>
        </select>
    </div>
</div>
<div id="orderItemForm">

</div>

<script>
    $('#selectProduct').select2({
        dropdownParent: Helper.currentModal().body,
        placeholder: 'Select Product',
        allowClear: true,
        templateResult: formatState,
        ajax: {
            url: "{{ route('orders.order_items.product_select2_data', request()->route()->parameters()) }}",
            dataType: 'json',
            delay: 250,
            processResults: function(response) {
                return {
                    results: $.map(response, function(product) {
                        return {
                            text: product.name,
                            id: product.id,
                            image: product.image,
                            price: product.price,
                            quantity: product.quantity,
                            unit: product.unit,
                        }
                    })
                };
            },
            cache: true
        }
    });

    function formatState (opt) {
        if (!opt.id) {
            return opt.text;
        }
        let $opt = $(
           `<div class="row p-2" style='border: 1px solid #eeeeee' border-width: '0px 0px 2px 0px'>
    <div class="col-md-3 col-sm-3 mt-1 col-3">
        <img class="img-fluid img-responsive rounded product-image" src="${opt.image}"></div>
    <div class="col-md-9 col-sm-9 col-9 mt-1">
        <div class="" style="font-size: 13px;font-weight: bold">
            ${opt.text}
        </div>
        <div style="font-size: 11px;font-weight: bold; color: #767575">৳ ${opt.price}  / ${opt.quantity} ${opt.unit} </div>
    </div>
</div>`
        );
        return $opt;
    }

</script>