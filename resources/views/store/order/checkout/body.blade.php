<div>
    <style>
        fieldset {
            border: 1px solid #aaaaaa;
            font-size: 14px;
            border-radius: 5px;
            border-radius: 5px;
            padding: 10px 5px 15px 10px;
            margin-top: -10px;
        }

        legend {
            background-color: #ffffff;
            color: #595858;
            width: 90px;
            font-size: 15px;
            padding: 2px;
            margin-left: 3px;
            border-radius: 5px;
            font-weight: bold;
        }

        .input-group-margin {
            position: relative;
            margin-bottom: 20px;
        }

        .input-group .input-area {
            outline: none;
            border: 1px solid #aaaaaa;
            padding: 16px 10px;
            font-size: 14px;
            border-radius: 5px;
            width: 100%;
        }

        .input-group .input-area:valid+.label {
            top: -8px;
            padding: 0 3px;
            font-size: 14px;
            color: #595858;
        }

        .input-group .input-area:focus {
            border: 1px solid var(--theme-color);
            box-shadow: 1px 5px 7px -2px rgba(170, 170, 170, 0.74);
        }

        .input-group .label {
            color: #595858;
            position: absolute;
            font-weight: bold;
            left: 13px;
            background: #ffffff;
            top: -11px;
            padding: 0 3px;
            font-size: 15px;
        }

        .input-group .is-invalid {
            border: 1px solid red;
        }

        .input-group .is-invalid:focus {
            border: 1px solid red;
        }

        .input-group .input-area:focus+.label {
            top: -11px;
            padding: 0 3px;
            font-size: 15px;
            color: var(--theme-color);
            font-weight: bold;
        }

        .checkout-details {
            padding: 2px;
            border: 1px solid #eeeeee;
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
            border-radius: 5px;
        }

        .checkout-details .details-header {
            background-color: #8e44ad;
            color: #ffffff;
            text-align: center;
            font-size: 18px;
            font-weight: bold;
            padding: 15px 5px 15px 5px;
            border-radius: 5px 5px 5px 5px;
        }

        .form-text {
            margin-left: 5px;
        }

        .details-body {
            padding: 0px;
        }

        .orderBtn {
            width: 100%;
            padding: 12px;
            border-width: 0px;
            color: #ffffff;
            border-radius: 5px;
            font-size: 16px;
            margin: 10px 0px 10px 0px;
            font-weight: bold;
        }

        .orderBtn:hover {
            filter: brightness(90%);
        }
        .invalid-feedback{
            margin-left: 10px;
        }
    </style>

    <div class="checkout-detailss">
        {{-- <div class="details-header">
            আপনার তথ্য
        </div> --}}
        <div class="details-bodyy">
            
            <div class="" id="orderConfirmBody">
                @include('store.order.checkout.body_livewire')
            </div>
            <span class="invalid-feedback" style="display: block" id="" role="alert">
                <strong id="orderConfirmResponseMessage"></strong>
            </span>
            <button href="" class="orderBtn theme-bg mt-4" style="width: 100%"
                data-token="{{ csrf_token() }}" id="orderConfirmBtn" data-url="{{ route('store.order') }}"
                onclick="Store.order.create(this)" data-target="#orderDetailsModal">অর্ডার কনফার্ম করুন</button>

        </div>
    </div>

</div>
