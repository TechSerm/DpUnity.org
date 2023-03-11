{{ Form::model($product, ['method' => 'POST','data-function' => 'confirmProduct(form)','route' => ['temporary_products.confirm',request()->route()->parameters()],'files' => true,'class' => 'form-horizontal']) }}

@if (count($similarProducts) > 0)
    @include('temporary_product.similar_product')
@else
<div class="card-header bg-success mb-2" style="font-weight:bold">
    এই পণ্যটির সাথে অন্য পণ্যের মিল পাওয়া যাই নি!
</div>
@endif


@include('temporary_product._confirmPartialForm', ['submitButtomText' => 'Update'])
{!! Form::close() !!}
