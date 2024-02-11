<form action="{{ route('sliders.store') }}" method="post" class="form">
    @php
        $labelWidth = 4;
        $inputWidth = 6;
    @endphp

    @csrf

    <div class="mb-3 row ">
        <label for="name" class="col-sm-{{ $labelWidth }} col-form-label form-control-label">Title</label>
        <div class="col-sm-{{ $inputWidth }}">
            {!! Form::text('title', null, ['class' => 'form-control ', 'id' => 'name']) !!}
        </div>
    </div>


    <div class="mb-3 row">
        <label for="image" class="col-sm-{{ $labelWidth }} col-form-label form-control-label"
            for="image">Slider</label>
        <div class="col-sm-{{ $inputWidth }}">
            <input type="file" name="image" id="image" onchange="previewFile(event)">
            <img src="{{ url('images/default.png') }}" id="image-preview" height="180px" width="180px"
                class="img-thumbnail mt-2" alt="">
        </div>
    </div>

    <div class="mb-3 row">
        <label for="inputPassword" class="col-sm-{{ $labelWidth }} col-form-label form-control-label"></label>
        <div class="col-sm-{{ $inputWidth }}">
            <button type="submit" class="btn btn-success">Add Slider</button>
        </div>
    </div>
</form>

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
    </script>
@endpush
