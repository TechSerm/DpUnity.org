{!! Form::open(['route' => ['users.store'], 'data-function' => 'createProduct(form)' , 'files' => true, 'class' => 'form-horizontal']) !!}
    @include('users._partialForm')
{!! Form::close() !!}
