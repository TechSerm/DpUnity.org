{!! Form::open(['route' => ['products.store'], 'data-function' => 'createProduct(form)' , 'files' => true, 'class' => 'form-horizontal']) !!}
@include('product._partialForm', ['submitButtomText' => 'Update'])
{!! Form::close() !!}
