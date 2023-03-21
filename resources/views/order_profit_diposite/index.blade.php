@extends('layouts.app')
@section('content_header')
    <h1>Vendor Payments</h1>
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
        <div class="card-body">
            <div class="row">
                <div class="col-md-4 col-sm-4">
                    <x-adminlte-small-box
                        title="{{ bnConvert()->number($totalDipositeableProfit) }} টাকা ({{ bnConvert()->number($countDipositeableProfit) }})"
                        text="ক্যাশে জমা দেয়া বাকি আছে" icon="fa fa-credit-card" theme="danger" />
                </div>
                <div class="col-md-6 col-sm-6">
                    <x-adminlte-small-box title="{{ bnConvert()->number($totalDeliveryManHas) }} টাকা"
                        text="ডেলিভারি ম্যান এর কাছে আছে (বিক্রেতার টাকা + লাভ)" icon="fa fa-credit-card" theme="warning" />
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header" style=""><b>পেমেন্ট টেবিল</b></div>
        <div style="" class="dashboardReportSubArea">
            <div class="row">
                <div class="align-self-end ml-auto mb-4">
                    <button class="btn btn-success" data-modal-title='লাভ ক্যাশে জমা দিন' data-modal-size="md" data-toggle='modal'
                        data-url="{{ route('order_profit_diposites.create') }}">লাভ ক্যাশে জমা দিন</button>
                </div>
            </div>
            @include('order_profit_diposite.diposite_profit_table')

        </div>
    </div>
@stop



@push('scripts')
    <script>
        $(document).ready(function() {

            $(document).on('change', '#vendorPaymentCheckboxAll', function(e) {
                $('tbody tr td input[type="checkbox"]').prop('checked', $(this).prop('checked'));
                calculateSelectedOrder();
            });

            $(document).on('change', ".OrderProfitPaymentCheckbox", function(e) {
                calculateSelectedOrder();
            });

            function calculateSelectedOrder() {
                let totalSelectAmount = 0;
                let totalSelect = 0;
                let totalNoSelectAmount = 0;
                let totalNoSelect = 0;
                $('tbody tr td input[type="checkbox"]').each(function() {
                    let total = $(this).data('total');
                    if ($(this).prop("checked") == true) {
                        totalSelectAmount += total;
                        totalSelect++;
                    } else {
                        totalNoSelectAmount += total;
                        totalNoSelect++;
                    }
                });

                $("#totalSelectedAmount").html(totalSelectAmount);
                $("#totalSelected").html(totalSelect);
                $("#totalNoSelectedAmount").html(totalNoSelectAmount);
                $("#totalNoSelected").html(totalNoSelect);


            }


        });
    </script>
@endpush
