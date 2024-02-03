<form action="{{route('attributes.update', $attribute)}}" method="post" class="form">
    @csrf
    @method("PUT")
    <div>
        <label for="name" class="form-lsabel">Name*</label>
        <input type="text" value="{{$attribute->name}}" name="name" class="form-control">
    </div>
    <button type="submit" class="btn btn-success mt-4"><i class="fa fa-edit"></i> Update Attributes</button>
</form>