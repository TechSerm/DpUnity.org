<style>
    .drg {
        cursor: grab;
    }

    .drg:active {
        cursor: grabbing;
    }

    .drg-design {
        height: 110px;
        border-right: 1px solid #dddddd;
        margin: -10px 0px 0px -10px;
        padding: 5px;
        float: left;
        background-color: #f1f1f1
    }

    .drg:hover {
        background-color: #eeeeee;
    }
</style>
<table class="table" id="">
    <tbody id="sliderArea">
        @foreach ($sliders as $slider)
            <tr data-id="{{ $slider->uuid }}">
                <td>
                <td style="width: 40px;" class="drg"><i class="fas fa-grip-vertical"></i> </td>
                </td>
                <td>
                    <img src="{{ $slider->image }}" height="60px;" alt="">
                </td>
                <td>
                    <button data-toggle="modal" data-modal-title="Update Slider" data-modal-size="md"
                        data-url="{{ route('sliders.edit', $slider) }}"
                        class="edit_item_btn btn btn-primary btn-sm mr-1"><i class="fas fa-edit"
                            aria-hidden="true"></i></button>
                    <button data-url="{{ route('sliders.destroy', $slider) }}" class='btn btn-danger btn-action btn-sm'
                        data-toggle='delete'><i class='fa fa-trash'></i></button>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

<button class="btn btn-primary" id="updateOrderBtn" disabled onclick="updateSliderOrder()">Update Order</button>

@push('scripts')
    <script>
        var order = [];
        let sliderSortable = $("#sliderArea").sortable({
            group: 'list',
            animation: 200,
            handle: '.drg',
            removeCloneOnHide: true,
            ghostClass: 'blue-background-class',
            store: {
                get: function(sortable) {
                    return sortable.toArray();
                    order = localStorage.getItem(sortable.options.group.name);
                    return order ? order.split('|') : [];
                },
                set: function(sortable) {
                    order = sortable.toArray();
                    console.log(order);
                    $("#updateOrderBtn").prop('disabled', false);
                }
            },
        });

        function updateSliderOrder() {
            //var order = sortable.toArray();
            let data = {
                order: order
            };

            let btn = $("#updateOrderBtn");

            $(btn).prop("disabled", true);
            $(btn).html('<i class="fa fa-spinner fa-spin"></i> ' + $(btn).html());

            $.post("{{route('sliders.order_update')}}", Helper.config.setToken(data), function(data) {
                Helper.toast.success(data.message);
                location.reload();
            });
        }
    </script>
@endpush
