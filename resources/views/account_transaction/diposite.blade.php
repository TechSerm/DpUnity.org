{!! Form::open(['route' => ['account_transaction.diposite'] , 'files' => true, 'class' => 'form-horizontal']) !!}

@include('account_transaction._partialForm', ['submitButtomText' => 'জমা করুন'])

{!! Form::close() !!}