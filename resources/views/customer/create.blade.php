{!! Form::open(['route' => ['categories.store'], 'data-function' => 'createProduct(form)' , 'files' => true, 'class' => 'form-horizontal']) !!}
@include('customer._partialForm')
{!! Form::close() !!}