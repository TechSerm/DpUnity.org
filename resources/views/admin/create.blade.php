{!! Form::open(['route' => ['admin.store'], 'data-function' => 'createProduct(form)' , 'files' => true, 'class' => 'form-horizontal']) !!}
    @csrf
    @include('admin._partialForm', ['submitButtomText' => 'Update'])
{!! Form::close() !!}
