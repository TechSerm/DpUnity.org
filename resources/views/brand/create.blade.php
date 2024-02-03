{!! Form::open(['route' => ['brands.store'], 'data-function' => 'createProduct(form)' , 'files' => true, 'class' => 'form-horizontal']) !!}
    @csrf
    @include('brand._partialForm', ['submitButtomText' => 'Update'])
{!! Form::close() !!}
