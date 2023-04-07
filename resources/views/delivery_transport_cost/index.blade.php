@extends('layouts.app')
@section('content_header')
    <h1>ডেলিভারি খরচ</h1>
@stop


@section('content')
    <style>
        .dashboardReportSubArea {
            background: #f8f8f8;
            padding: 10px;
            border: 1px solid #eeeeee;
        }
    </style>

    <div class="card">
        <div class="card-header" style=""><b>ডেলিভারি খরচ টেবিল</b></div>
        <div style="" class="dashboardReportSubArea">
            <div class="row mb-1">
                <div class="col-md-3 offset-md-9">
                    <div style="text-align: right">
                        <button class="btn btn-success" data-modal-title='ডেলিভারি খরচ যুক্ত করুন' data-modal-size="md"
                            data-toggle='modal' data-url="{{ route('delivery_transport_costs.create') }}">ডেলিভারি খরচ যুক্ত করুন
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body table-responsive">
            <table class="table table-bordered" style="text-align: center">
                <tr>
                    <td>#</td>
                    <td><b>পরিমান (টাকা)</b></td>
                    <td><b>নোট</b></td>
                    <td><b>তারিখ</b></td>
                    <td><b>যুক্ত করেছে</b></td>
                    <td><b>যুক্ত করা হয়েছে</b></td>
                </tr>
                @foreach ($costs as $cost)
                    <tr>
                        <td>{{ bnConvert()->number($cost->id) }}</td>
                        <td><b>{{ bnConvert()->number($cost->amount) }}</b> টাকা</td>
                        <td>{{ $cost->note }}</td>
                        <td><span
                            title="{{ $cost->date->format('d M Y h:i:s a') }}">{{ bnConvert()->date($cost->date->format('d M Y')) }}</span>
                        <td><span class="badge badge-secondary">{{ $cost->user->name }}</span></td>
                        <td><span
                            title="{{ $cost->created_at->format('d M Y H:i:s') }}">{{ bnConvert()->date($cost->created_at->diffForHumans()) }}</span>
                    </td>
                    </tr>
                @endforeach
            </table>
            {{$costs->links()}}
        </div>
    </div>
@stop
