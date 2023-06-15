@extends('layouts.app')
@section('content_header')
    <h1>All Products</h1>


@stop
@section('content')

    <style>
        .productPriceInput {
            font-weight: bold;
            font-size: 15px;
            color: #000000;
        }

        .productPriceCard {
            padding: 5px 10px 10px 10px;
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
        }

        .cartTr {
            /* box-shadow: 0px 0px 5px rgba(70, 8, 86, 0.3);  */
            border: 1px dashed #eeeeee;
            border-width: 0px 0px 1px 0px !important;
            margin-bottom: 6px;
            display: table-row;
            width: 100%;
        }

        .cartTr td {
            /* border: 1px solid #000000; */
        }

        footer {
            position: fixed;
            height: 60px;
            bottom: 0;
            width: 100%;
            border: 1px solid #c5c5c5;
            background: #aaaaaa;
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
            padding: 5px;
        }

        table {
            border: 1px solid #eeeeee;
            margin-top: 10px;
        }
    </style>

    <div class="row">
        <div class="col-md-12">
            <div class="card productPriceCard" style="padding: 15px;">
                <div class="row">
                    <div class="col-md-3">
                        <label>ক্যাটেগরি</label>
                        <select name="category_id" class="form-control mb-1" id="category">
                            <option value="">ক্যাটেগরি নির্বাচন করুন</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}"
                                    {{ isset(request()->category) && request()->category == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-3">
                        <button class="btn btn-primary mt-2" onclick="filterProduct()" type="submit">ফিল্টার করুন</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row" id="sortable_area">
        @foreach ($products as $product)
            <div class="col-md-3" data-id="{{ $product->id }}">
                <div class="card productPriceCard">
                    <div style="text-align: center">
                        <button class="btn btn-action btn-sm btn-secondary drg"><i
                                class="fas fa-grip-horizontal"></i></button>
                        <button data-url="{{ route('products.edit', $product) }}" class='btn btn-success btn-action btn-sm'
                            data-modal-title='Update Product <b># {{ $product->id }}</b>' data-modal-size='650'
                            data-toggle='modal'><i class='fa fa-edit'></i></button>
                        <button data-url="{{ route('products.history', $product) }}"
                            class='btn btn-primary btn-action btn-sm'
                            data-modal-title='Update Product <b>#{{ $product->id }}</b>' data-modal-size='1200'
                            data-toggle='modal'><i class='fa fa-history'></i></button>
                            <button data-url="{{ route('products.destroy', $product) }} " class='btn btn-danger btn-action btn-sm' data-callback='location.reload()' data-toggle='delete'><i class='fa fa-trash'></i></button>

                    </div>
                    <table>
                        <tr class="cartTr">
                            <td class="align-middle" style="padding: 5px; width: 70px">
                                <small> <img src="{{ $product->image }}" height="70px" width="70px" alt="">
                            </td>
                            <td class="align-middle" style="text-align: left">
                                <div class="" style="font-size: 13px;font-weight: bold">
                                    {{ $product->id }} - {{ $product->name }}
                                </div>
                                <div style="font-size: 11px;font-weight: bold; color: #767575">
                                    {{ bnConvert()->floatNumber($product->quantity) }}
                                    {{ bnConvert()->unit($product->unit) }}
                                    <br/>
                                    @php
                                        $totalOrder = $product->orders->sum('quantity');
                                    @endphp
                                    <span
                                    class="badge {{ $totalOrder == 0 ? 'badge-danger' : 'badge-success' }}">{{ bnConvert()->floatNumber($totalOrder) }} টি অর্ডার হয়েছে </span><br/>
                                    <span
                                        class="badge {{ $product->status == 'private' ? 'badge-danger' : 'badge-success' }}">{{ $product->status }}</span>
                                    <span
                                        class="badge {{ !$product->has_stock ? 'badge-danger' : 'badge-success' }}">{{ $product->has_stock ? 'স্টকে আছে' : 'স্টকে নাই' }}</span><br />
                                    @can('products_price.show_vendor')
                                        <span class="badge badge-info"
                                            style="background: {{ $product->vendor ? $product->vendor->color : '' }}">{{ $product->vendor->name ?? '' }}</span>
            @endif
            @if ($product->vendor)
                <br />
            @endif
            @php
                $categories = $product->categories;
            @endphp
            @foreach ($categories as $category)
                <span class="badge badge-secondary">{{ $category->name }}</span>
            @endforeach

        </div>
        </td>
        </tr>
        </table>
        <div class="row mt-2">
            <input type="number" name="product_id[]" value="{{ $product->id }}" id="" hidden>
            <div class="col-md-6 col-6">
                <small class="" style="font-weight: bold;">পাইকারি মূল্য</small>
                <input type="number" data-product_id="{{ $product->id }}"
                    data-default-value="{{ $product->wholesale_price }}" name="wholesale_price[]"
                    class="productPriceInput form-control mb-1" readonly value="{{ $product->wholesale_price }}">
            </div>
            <div class="col-md-6 col-6">
                <small class="" style="font-weight: bold;">বাজার দর</small>
                <input type="number" data-product_id="{{ $product->id }}"
                    data-default-value="{{ $product->market_sale_price }}" name="market_sale_price[]"
                    class="productPriceInput form-control mb-1" readonly value="{{ $product->market_sale_price }}">
            </div>
            <div class="col-md-12">
                <small><b>সর্বশেষ পরিবর্তন হয়েছে:</b>
                    {{ bnConvert()->date(($product->wholesale_price_last_update ? $product->wholesale_price_last_update : $product->updated_at)->diffForHumans()) }}</small>
            </div>
        </div>
        </div>
        </div>
        @endforeach
        <div style="margin-bottom: 300px; "></div>
        <footer class="fixed-bottom"><button type="submit" id="saveButton" style="width: 100%"
                class="btn btn-product-price btn-success" onclick="productSerialSave()" disabled>আপডেট করুন </button></footer>
    @stop

    @push('scripts')
        <script>
            function filterProduct() {
                let category = $("#category").val();

                var url = new URL("{{ route('products.order') }}");
                if (category) url.searchParams.set('category', category);
                window.location.href = url;
            }
            var productOrderData = {};

            function productSerialSave() {
                $("#saveButton").attr('disabled', false);
                $("#saveButton").html("Saving......")
                $.post("{{ route('products.order') }}", Helper.config.setToken(productOrderData), function(productOrderData) {
                    $(".result").html(productOrderData);
                    $("#saveButton").attr('disabled', true);
                    $("#saveButton").html("আপডেট করুন");
                    Helper.toast.success("Save Success");
                });
            }
            let seriesSortable = $("#sortable_area").sortable({
                group: 'list',
                animation: 200,
                handle: '.drg',
                removeCloneOnHide: true,
                ghostClass: 'blue-background-class',
                store: {
                    /**
                     * Get the order of elements. Called once during initialization.
                     * @param   {Sortable}  sortable
                     * @returns {Array}
                     */
                    get: function(sortable) {
                        //console.log(sortable.options.group.name);
                        return sortable.toArray();
                        var order = localStorage.getItem(sortable.options.group.name);
                        return order ? order.split('|') : [];
                    },
                    /**
                     * Save the order of elements. Called onEnd (when the item is dropped).
                     * @param {Sortable}  sortable
                     */
                    set: function(sortable) {
                        var order = sortable.toArray();
                        let data = {
                            products: order
                        };

                        productOrderData = data;

                        $("#saveButton").attr('disabled', false);

                        //console.log(data);
                        // $.post("{{ route('products.order') }}", Helper.config.setToken(data), function(data) {
                        //     $(".result").html(data);
                        // });
                        //return;
                        //localStorage.setItem(sortable.options.group.name, order.join('|'));
                    }
                },
                // Called when dragging element changes position
                onUpdate: function( /**Event*/ evt) {
                    //console.log(this.options.store.get());
                    //console.log(seriesSortable.sortable());
                    //console.log("update call");
                }
            });

            function updateProduct(e) {
                let form = Helper.form(e);
                form.submit({
                    success: {
                        'callback': function() {
                            location.reload();
                        }
                    }
                });
            }
        </script>
    @endpush
