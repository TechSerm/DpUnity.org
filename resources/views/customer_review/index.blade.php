@extends('layouts.app')
@section('content_header')
    <h1>Customer Review</h1>
@stop
@section('content')

    <style>
        .mobile-area {
            display: block;
        }

        .mobile-block {

            display: block;
            font-size: 14px;
            margin-bottom: 10px;
            border-radius: 3px;
            box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.2), 0 1px 5px 0 rgba(0, 0, 0, 0.19);
        }

        .mobile-block .td1 {
            width: 90px;
            text-align: right;
        }

        .mobile-block tr {
            color: #000000;
        }

        .borderless td,
        .borderless th {
            border: none;
            padding: 5px;
            font-size: 12px;
        }

        .mobile-block table {
            background: #ffffff;
            margin-bottom: 0px;
            border-radius: 5px;
        }

        .mobile-block .span-block {
            background: #ffffff;
            border: 1px solid #eeeeee;
            border-radius: 5px;
            margin-right: 2px;
            padding: 5px;
            margin-bottom: 5px;
            color: #000000;
            font-size: 12px;
        }

        .mobile-block .button-area {
            position: absolute;
            margin-top: 5px;
            margin-left: -20px;
            text-align: right;
            width: 100%;
        }

        .mobile-block .btn {
            font-size: 13px;
            height: 27px;
            width: 30px;
        }

        .mobile-block .span-badge {
            margin-top: -11px;
            margin-bottom: -13px;
        }
    </style>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="align-self-end ml-auto mb-4">
                            <button class="btn btn-primary " data-url="{{ route('customer_reviews.create') }}"
                                data-modal-title="Create Product" data-modal-size="500" data-modal-title="Add Schedule Review"
                                data-toggle="modal">Add Schedule Review</button>
                        </div>
                    </div>

                    <div class="mobile-area">
                        <div class="row">
                            @foreach ($reviews as $review)
                                <div class="col-md-3">
                                    <div class=" mobile-block " style="">
                                        <div class="button-area">
                                            <a href="" data-modal-size="md" class="btn btn-success btn-sm mb-1"
                                                data-modal-header="পেমেন্ট #{{ bnConvert()->number($review->id) }}"
                                                data-toggle="modal"><i class="fa fa-plus"></i></a><br />
                                            <a href="" data-modal-size="md" class="btn btn-info btn-sm mb-1"
                                                data-modal-header="পেমেন্ট #{{ bnConvert()->number($review->id) }}"
                                                data-toggle="modal"><i class="fa fa-eye"></i></a><br />
                                            <a href="" data-modal-size="md" class="btn btn-success btn-sm mb-1"
                                                data-modal-header="পেমেন্ট #{{ bnConvert()->number($review->id) }}"
                                                data-toggle="modal"><i class="fa fa-eye"></i></a><br />

                                        </div>
                                        <table class="table borderless">
                                            <tr>
                                                <td class="td1">ID:</td>
                                                <td><b>{{ $review->id }}</b></td>
                                            </tr>
                                            <tr>
                                                <td class="td1">Category:</td>
                                                <td> <span class="badge badge-secondary" style="margin-top: -5px">{{ $review->order ? 'Order' : 'Regular' }}</span> </td>
                                            </tr>
                                            <tr>
                                                <td class="td1">Customer:</td>
                                                <td><b>{{ $review->customer->name }}</b> </td>
                                            </tr>
                                            <tr>
                                                <td class="td1">Time:</td>
                                                <td><b> {{$review->schedule_time ? $review->schedule_time->format('d M Y H:i:s') : ''}}</b> </td>
                                            </tr>
                                            <tr>
                                                <td class="td1">Status:</td>
                                                <td>
                                                    @if ($review->is_done)
                                                        <span class="badge badge-success span-badge">Done</span>
                                                    @elseif($review->is_pending)
                                                        <span class="badge badge-primary span-badge">Pending</span>
                                                    @else
                                                        <span class="badge badge-danger span-badge">Cancel</span>
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="td1">Assign By:</td>
                                                <td>{{ $review->assigned ? $review->assigned->name : '' }}</td>
                                            </tr>
                                        </table>

                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
