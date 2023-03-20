{!! Form::open(['route' => ['account_transaction.withdraw'] , 'files' => true, 'class' => 'form-horizontal']) !!}
<x-adminlte-small-box title="{{bnConvert()->number($accountBalance)}} টাকা" text="সর্বোচ্চ তুলতে পারবেন"
                icon="fas fa-check" theme="warning" />
@include('account_transaction._partialForm', ['submitButtomText' => 'তুলুন'])

{!! Form::close() !!}