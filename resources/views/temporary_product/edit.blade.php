{{ Form::model($product, ['method' => 'PATCH', 'data-function' => 'updateProduct(form)' ,'route' => ['temporary_products.update',request()->route()->parameters()],'files' => true,'class' => 'form-horizontal']) }}
@include('temporary_product._partialForm', ['submitButtomText' => 'Update'])
{!! Form::close() !!}
