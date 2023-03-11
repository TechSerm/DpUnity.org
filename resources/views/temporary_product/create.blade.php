{!! Form::open(['route' => ['temporary_products.store'], 'data-function' => 'createProduct(form)' , 'files' => true, 'class' => 'form-horizontal']) !!}
@include('temporary_product._partialForm', ['submitButtomText' => 'Update'])
{!! Form::close() !!}
