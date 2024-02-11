@extends('layouts.app')
@section('content')
<style>
    .attributeTable li {
        padding: 8px 0;
        border-bottom: 1px solid #ddd;
    }
</style>
    <div class="row">

        <div class="col-md-4" style="margin-top: 10px;">
            <div class="card">
                <div class="card-header align-items-center">
                    <div class="float-left" style="padding-top: 7px;">
                        Create Attributes
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{route('attributes.store')}}" method="post" class="form">
                        @csrf
                        <div>
                            <label for="name" class="form-lsabel">Name*</label>
                            <input type="text" name="name" class="form-control">
                        </div>
                        <button type="submit" class="btn btn-success mt-3"><i class="fa fa-plus"></i> Create Attributes</button>
                    </form>
                </div>
            </div>
            <div class="card">
                <div class="card-header align-items-center">
                    <div class="float-left" style="padding-top: 7px;">
                        Create Attributes Value
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{route('attribute_values.store')}}" method="post" class="form">
                        @csrf
                        
                        <div>
                            <label for="name" class="form-label">Select Attribute*</label>
                            <select name="attribute" class="form-control" id="">
                                <option value="">Select Attribute</option>
                                @foreach ($attributes as $attribute)
                                    <option value="{{ $attribute->uuid }}">{{ $attribute->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label for="name" class="form-label mt-3">Name*</label>
                            <input type="text" name="name" class="form-control">
                        </div>
                        <button type="submit" class="btn btn-success mt-3"><i class="fa fa-plus"></i> Create Value</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-8" style="margin-top: 10px;">
            <div class="card">
                <div class="card-header align-items-center">
                    <div class="float-left" style="padding-top: 7px;">
                        Attributes List
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-bordered attributeTable">
                        <thead>
                            <tr>
                                <th scope="col">Name</th>
                                <th scope="col">Values</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($attributes as $attribute)
                            @php
                                $values = $attribute->values;
                            @endphp
                            <tr>
                                <td>{{ $attribute->name }}</td>
                                <td>
                                    <ul>
                                        @foreach ($values as $value)
                                        <li>
                                            <div>
                                                <span>{{$value->name}}</span>
                                                <div class="float-right" style="width: 80px">
                                                    <button data-toggle="modal" data-modal-title="Update Attribute Value" data-modal-size="sm" data-url="{{route('attribute_values.edit', $value)}}" class="edit_item_btn btn btn-primary btn-sm mr-1"><i class="fas fa-edit"
                                                            aria-hidden="true"></i></button>
                                                    <button data-toggle="delete" data-url="{{route('attribute_values.destroy', $value)}}" class="btn btn-danger btn-sm"><i class="fas fa-trash" aria-hidden="true"></i></button>
                                                </div>
                                            </div>
                                        </li>
                                        @endforeach
                                    </ul>
                                </td>
                                <td style="width: 130px">
                                    <button data-toggle="modal" data-modal-title="Update Attribute" data-modal-size="sm" data-url="{{route('attributes.edit', $attribute)}}" class="edit_item_btn btn btn-primary btn-sm mr-1"><i class="fas fa-edit"
                                        aria-hidden="true"></i></button>
                                    <button data-toggle="delete" title="Delete Attribute" data-url="{{route('attributes.destroy', $attribute)}}" class="btn btn-danger btn-sm"><i class="fas fa-trash" aria-hidden="true"></i></button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

@stop
