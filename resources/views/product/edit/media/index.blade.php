<div class="card">
    <div class="card-header">
        Product Image
    </div>
    <div class="card-body" style="text-align: center">
        <img src="{{ $product->image }}" id="image-thumbnaill-preview"  class="img-thumbnail" alt="">
        <input type="file" accept="image/*" class="form-control mt-3" id="image" name="image" onchange="previewThumbnailFile(event)">
    </div>
</div>

<div class="card">
    <div class="card-header">
        <div class="float-left" style="padding-top: 7px;">
            Product Gallery
        </div>
        <div class="float-right">
            <a class="btn btn-secondary"
                href="{{ route('product_images.create', request()->route()->parameters()) }}"
                data-modal-header="Add Image" data-modal-size="500" data-toggle="modal">
                <i class="fa fa-plus"></i> Add Image
        </a>
        </div>
    </div>
    <div class="card-body">
        <div class="row" id="product_gallery_area">
            @php
                $productGalleryImages = $product->images;
            @endphp
            @foreach ($productGalleryImages as $image)
                <div class="col-md-6 text-center" id="image_{{$image->uuid}}">
                    <div class="card">
                        <div class="card-body" style="padding: 10px">
                            <img src="{{ $image->url }}" class="img-thumbnail" alt=""><br />
                            <a data-divid="image_{{$image->uuid}}" onclick="deleteGalleryImage(this)" title="Remove"
                                data-url="{{ route('product_images.destroy', array_merge(request()->route()->parameters(), ['product_image' => $image->uuid])) }}"
                                class="btn btn-sm btn-danger mt-2" style="padding: 0px 6px"><i class="fa fa-trash"></i>
                                Remove</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>


@push('scripts')
    <script>
        function previewFile(event) {

            var output = document.getElementById('image-preview');
            if (!event.target.files[0]) {
                // output.src = $('#img-preview-default').attr('src');
            } else output.src = URL.createObjectURL(event.target.files[0]);
            output.onload = function() {
                URL.revokeObjectURL(output.src) // free memory
            }
        }

        function previewThumbnailFile(event) {

            var output = document.getElementById('image-thumbnaill-preview');
            if (!event.target.files[0]) {
                // output.src = $('#img-preview-default').attr('src');
            } else output.src = URL.createObjectURL(event.target.files[0]);
            output.onload = function() {
                URL.revokeObjectURL(output.src) // free memory
            }
        }

        function uploadGallerySuccess(response) {
            console.log(response);
            var htmlTemplate = `
    <div class="col-md-6 text-center" id="image_${response.uuid}">
        <div class="card">
            <div class="card-body" style="padding: 10px">
                <img src="${response.url}" class="img-thumbnail" alt=""><br />
                <a data-divid="image_${response.uuid}" onclick="deleteGalleryImage(this)" title="Remove" data-url="${response.remove_url}"  class="btn btn-sm btn-danger mt-2" style="padding: 0px 6px"><i class="fa fa-trash"></i> Remove</a>
            </div>
        </div>
    </div>
`;

            // Append the HTML to the element with id "product_gallery_area" and replace its content
            $("#product_gallery_area").append(htmlTemplate);
        }

        function deleteGalleryImage(e) {
            let btn = $(e);
            Swal.fire({
                    title: 'Are you sure?',
                    text: "You want be delete this record!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Yes, delete it!',
                    showLoaderOnConfirm: true,
                    preConfirm: function() {
                        return new Promise(function(resolve) {
                            $.ajax({
                                url: btn.data('url'),
                                data: Helper.config.setToken(),
                                type: 'delete',
                                success: (response) => {
                                    let msg = response.message
                                    Swal.fire({
                                        title: 'Deleted!',
                                        text: msg,
                                        icon: 'success',
                                    });
                                    $("#"+btn.data('divid')).remove();
                                }
                            }).fail(function(error) {
                                Swal.fire({
                                    title: "Oops!!!",
                                    text: error.status + " - " + error.statusText,
                                    icon: 'error',
                                });
                            });
                        });
                    },
                    allowOutsideClick: () => !Swal.isLoading()
                });
            }
    </script>
@endpush
