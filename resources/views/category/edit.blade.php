{{ Form::model($category, ['method' => 'PATCH', 'data-function' => 'updateProduct(form)' ,'route' => ['categories.update',request()->route()->parameters()],'files' => true,'class' => 'form-horizontal']) }}
@include('category._partialForm', ['submitButtomText' => 'Update']);
{!! Form::close() !!}
