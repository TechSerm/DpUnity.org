<form action="{{route('attribute_values.update', $attributeValue)}}" method="post" class="form">
    @csrf
    @method("PUT")
    <div>
        <label for="name" class="form-lsabel">Name*</label>
        <input type="text" value="{{$attributeValue->name}}" name="name" class="form-control">
    </div>
    <button type="submit" class="btn btn-success mt-4"><i class="fa fa-edit"></i> Update Value</button>
</form>