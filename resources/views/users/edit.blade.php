{{ Form::model($user, ['method' => 'PATCH', 'data-function' => 'updateProduct(form)' ,'route' => ['users.update',request()->route()->parameters()],'files' => true,'class' => 'form-horizontal']) }}
@include('users._partialForm', ['submitButtomText' => 'Update'])
{!! Form::close() !!}
