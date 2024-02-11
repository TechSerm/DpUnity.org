<div class="tab-pane fade" id="LogoFavicon" role="tabpanel" aria-labelledby="LogoFavicon-tab">
    <div class="row">
        @foreach ($logoSettingOptions as $settingOption)
            <div class="col-md-4 text-center">
                <div class="img_group">
                    <img class="img-thumbnail uploaded_img sized_image preview_image" id="preview_{{ $settingOption->key }}" src="{{ $settingOption->value }}">
                    <div class="form-group">
                        <label><b>{{ $settingOption->title }}</b></label>
                        <div class="custom-file text-left">
                            <input type="file" name="{{ $settingOption->key }}"
                                class="custom-file-input image_upload" accept="image/*" name="logo">
                            <label class="custom-file-label">Choose
                                file...</label>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach

    </div>
</div>

@push('scripts')
    <script>
        $('.custom-file-input').on('change', function(e) {
            // Get the selected file
            var file = e.target.files[0];

            // Check if a file is selected
            if (file) {
                // Create a FileReader object
                var reader = new FileReader();
                let preview = $('#preview_'+ $(this).attr("name"));

                // Set a callback function to execute when the file is loaded
                reader.onload = function(e) {
                    // Set the source of the image element to the loaded file data
                    preview.attr('src', e.target.result);
                };

                // Read the file as a data URL (base64 encoded image)
                reader.readAsDataURL(file);
            } else {
                // Clear the image source if no file is selected
                preview.attr('src', '');
            }
        });
    </script>
@endpush
