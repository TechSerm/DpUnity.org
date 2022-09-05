{!! Form::open(['route' => ['categories.store'], 'data-function' => 'createProduct(form)' , 'files' => true, 'class' => 'form-horizontal']) !!}
@include('category._partialForm', ['submitButtomText' => 'Update'])
{!! Form::close() !!}
