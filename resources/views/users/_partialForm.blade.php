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


<div class="mb-3 row required">
    <label for="password" class="col-sm-{{$labelWidth}} col-form-label form-control-label">Role</label>
    <div class="col-sm-{{$inputWidth}}">
        <select name="role_name" id="role_name" required class="form-control">
            <option value="">Select Role</option>
            <option value="admin" {{$user->role_name == "admin" ? 'selected' : ''}}>Admin</option>
            <option value="user" {{$user->role_name == "user" ? 'selected' : ''}}>Normal User</option>
        </select>
    </div>
</div>

<div class="mb-3 row required">
    <label for="password" class="col-sm-{{$labelWidth}} col-form-label form-control-label">Password</label>
    <div class="col-sm-{{$inputWidth}}">
        <input type="password" class="form-control" name="password" id="password">
    </div>
</div>

<div class="mb-3 row required">
    <label for="password_confirmation" class="col-sm-{{$labelWidth}} col-form-label form-control-label">Confirm Password</label>
    <div class="col-sm-{{$inputWidth}}">
        <input type="password" class="form-control" name="password_confirmation" id="password_confirmation">
    </div>
</div>


<div class="mb-3 row">
    <label for="inputPassword" class="col-sm-{{$labelWidth}} col-form-label form-control-label"></label>
    <div class="col-sm-{{$inputWidth}}">
        <button type="submit" class="btn btn-success">Save User</button>
    </div>
</div>




