<div class="alert alert-warning">Need to create new customer</div>
{!! Form::open(['route' => ['customer_reviews.add_customer'], 'data-page-reload' => 'false' , 'data-modal-close' => 'false', 'data-load-modal-with-response' => 'true' , 'files' => true, 'class' => 'form-horizontal']) !!}
@include('customer._partialForm')
{!! Form::close() !!}