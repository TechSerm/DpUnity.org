@php
    $labelWidth = 4;
    $inputWidth = 6;
@endphp


<div class="mb-3 row ">
    <label for="name" class="col-sm-{{$labelWidth}} col-form-label form-control-label">Name</label>
    <div class="col-sm-{{$inputWidth}}">
        {!! Form::text('name', null , ['class' => "form-control ", 'id' => 'name']) !!}
    </div>
</div>

<div class="mb-3 row ">
    <label for="email" class="col-sm-{{$labelWidth}} col-form-label form-control-label">E-mail</label>
    <div class="col-sm-{{$inputWidth}}">
        {!! Form::text('email', null , ['class' => "form-control ", 'id' => 'email']) !!}
    </div>
</div>


<div class="mb-3 row ">
    <label for="phone" class="col-sm-{{$labelWidth}} col-form-label form-control-label">Mobile</label>
    <div class="col-sm-{{$inputWidth}}">
        {!! Form::text('phone', null , ['class' => "form-control ", 'id' => 'phone']) !!}
    </div>
</div>

<div class="mb-3 row ">
    <label for="role_name" class="col-sm-{{$labelWidth}} col-form-label form-control-label">Type</label>
    <div class="col-sm-{{$inputWidth}}">
        {!! Form::text('role_name', null , ['class' => "form-control ", 'id' => 'role_name']) !!}
    </div>
</div>

<div class="mb-3 row ">
    <label for="street" class="col-sm-{{$labelWidth}} col-form-label form-control-label">Street</label>
    <div class="col-sm-{{$inputWidth}}">
        {!! Form::text('street', null , ['class' => "form-control ", 'id' => 'street']) !!}
    </div>
</div>

<div class="mb-3 row ">
    <label for="post_code" class="col-sm-{{$labelWidth}} col-form-label form-control-label">Postal Code</label>
    <div class="col-sm-{{$inputWidth}}">
        {!! Form::text('post_code', null , ['class' => "form-control ", 'id' => 'post_code']) !!}
    </div>
</div>

<div class="mb-3 row ">
    <label for="city" class="col-sm-{{$labelWidth}} col-form-label form-control-label">City</label>
    <div class="col-sm-{{$inputWidth}}">
        {!! Form::text('city', null , ['class' => "form-control ", 'id' => 'city']) !!}
    </div>
</div>
<div class="mb-3 row required">
    <label for="password" class="col-sm-{{$labelWidth}} col-form-label form-control-label">Password</label>
    <div class="col-sm-{{$inputWidth}}">
        {!! Form::password('password', null , ['class' => "form-control ", 'id' => 'password']) !!}
    </div>
</div>

<div class="mb-3 row required">
    <label for="password_confirmation" class="col-sm-{{$labelWidth}} col-form-label form-control-label">Confirm Password</label>
    <div class="col-sm-{{$inputWidth}}">
        {!! Form::password('password_confirmation', null , ['class' => "form-control ", 'id' => 'password_confirmation']) !!}
    </div>
</div>


<div class="mb-3 row">
    <label for="image" class="col-sm-{{$labelWidth}} col-form-label form-control-label" for="image">Image</label>
    <div class="col-sm-{{$inputWidth}}">
        <input type="file" name="image" id="image" onchange="previewFile(event)">
        <img src="{{ isset($user) ? $user->image : url('images/default.png') }}" id="image-preview" height="180px" width="180px" class="img-thumbnail mt-2" alt="">
    </div>
</div>

<div class="mb-3 row">
    <label for="inputPassword" class="col-sm-{{$labelWidth}} col-form-label form-control-label"></label>
    <div class="col-sm-{{$inputWidth}}">
        <button type="submit" class="btn btn-success">Save User</button>
    </div>
</div>




