<form action="{{ route('product_images.store', request()->route()->parameters()) }}" data-page-reload="false" data-callback="uploadGallerySuccess" method="post">
    @csrf

    <div class="mb-3 row">
        <label for="image" class="col-sm-4 col-form-label form-control-label" for="image">Image</label>
        <div class="col-sm-6">
            <input type="file" accept="image/*" name="image" id="image" onchange="previewFile(event)">
            <img  src="{{ url('images/default.png') }}" id="image-preview" height="180px" width="180px" class="img-thumbnail mt-2" alt="">
        </div>
    </div>

    <div class="mb-3 row">
        <label for="categories" class="col-sm-4 col-form-label form-control-label" for=""></label>
        <div class="col-sm-8">
            <button type="submit" class="btn btn-success">Add Image</button>
        </div>
    </div>
</form>
