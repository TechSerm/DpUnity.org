{!! Form::open(['route' => ['products.store'], 'data-function' => 'createProduct(form)' , 'files' => true, 'class' => 'form-horizontal']) !!}
@include('shipping._partialForm', ['submitButtomText' => 'Create Product'])
{!! Form::close() !!}
