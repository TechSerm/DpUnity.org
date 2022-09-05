{{ Form::model($product, ['method' => 'PATCH', 'data-function' => 'updateProduct(form)' ,'route' => ['products.update',request()->route()->parameters()],'files' => true,'class' => 'form-horizontal']) }}
@include('product._partialForm', ['submitButtomText' => 'Update']);
{!! Form::close() !!}
