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


    <div class="row">
        @if (auth()->user()->isVendor() &&
                count($vendors) == 0 &&
                count($vendorPayments))
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header" style=""><b>{{ auth()->user()->name }}</b></div>
                    <div style="" class="dashboardReportSubArea">
                        <div class="row">
                            <div class="col-md-12 col-sm-12">
                                <x-adminlte-small-box title="সুখবর" text="আপনার সবগুলো অর্ডার এর টাকা পরিশুধ করা হয়েছে"
                                    icon="fas fa-check" theme="success" />

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
        @foreach ($vendors as $vendor)
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header" style=""><b>{{ $vendor['name'] }}</b></div>
                    <div style="" class="dashboardReportSubArea">
                        <div class="row">
                            @if (count($vendor['not_send_ids']) > 0)
                                <div class="col-md-6 col-sm-6">
                                    <a href="{{ route('vendor_payments.send_payment', ['vendor_id' => $vendor['vendor_id']]) }}"
                                        data-modal-size="md" data-modal-header="{{ $vendor['name'] }}" data-toggle="modal">
                                        <x-adminlte-small-box
                                            title="{{ bnConvert()->number($vendor['not_send']) }} টাকা ({{ bnConvert()->number(count($vendor['not_send_ids'])) }})"
                                            text="বিক্রেতার বাকি আছে" icon="fas fa-times" theme="danger" />
                                    </a>
                                </div>
                            @endif
                            @if (count($vendor['send_ids']) > 0)
                                <div class="col-md-6 col-sm-6">
                                    <a href="{{ route('vendor_payments.send_pending_payment', ['vendor_id' => $vendor['vendor_id']]) }}"
                                        data-modal-size="md" data-modal-header="{{ $vendor['name'] }}" data-toggle="modal">
                                        <x-adminlte-small-box
                                            title="{{ bnConvert()->number($vendor['send']) }} টাকা ({{ bnConvert()->number(count($vendor['send_ids'])) }})"
                                            text="বিক্রেতাকে পাঠানো হয়েছে" icon="fas fa-clock" theme="warning" />
                                    </a>
                                </div>
                            @endif

                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="card">
        <div class="card-header" style=""><b>পেমেন্ট টেবিল</b></div>
        <div style="" class="dashboardReportSubArea">
            @include('vendor_payment.payment_list')
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

            $(document).on('change', ".vandorPaymentCheckbox", function(e) {
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

                $("#totalSelectedAmount").html(convertToBanglaNumber(totalSelectAmount));
                $("#totalSelected").html(convertToBanglaNumber(totalSelect));
                $("#totalNoSelectedAmount").html(convertToBanglaNumber(totalNoSelectAmount));
                $("#totalNoSelected").html(convertToBanglaNumber(totalNoSelect));


            }

            function convertToBanglaNumber(number) {
                const banglaDigits = ['০', '১', '২', '৩', '৪', '৫', '৬', '৭', '৮', '৯'];
                const englishNumberString = number.toString();
                let banglaNumberString = '';

                for (let i = 0; i < englishNumberString.length; i++) {
                    const englishDigit = parseInt(englishNumberString[i]);
                    if (isNaN(englishDigit)) {
                        banglaNumberString += englishNumberString[i];
                    } else {
                        banglaNumberString += banglaDigits[englishDigit];
                    }
                }

                return banglaNumberString;
            }


        });
    </script>
@endpush
