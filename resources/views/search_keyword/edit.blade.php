{{ Form::model($searchKeyword, ['method' => 'PATCH', 'data-function' => 'updateSearchKeyword(form)' ,'route' => ['search-keywords.update',request()->route()->parameters()],'files' => true,'class' => 'form-horizontal']) }}
@include('search_keyword._partialForm', ['submitButtomText' => 'Update']);
{!! Form::close() !!}
