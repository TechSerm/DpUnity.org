{{ Form::model($brand, ['method' => 'PATCH', 'data-function' => 'updateProduct(form)' ,'route' => ['brands.update',request()->route()->parameters()],'files' => true,'class' => 'form-horizontal']) }}
    @include('brand._partialForm', ['submitButtomText' => 'Update']);
{!! Form::close() !!}
