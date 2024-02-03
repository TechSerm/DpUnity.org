<div>
    <style>
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
    </style>

    <div class="checkout-detailss">
        {{-- <div class="details-header">
            আপনার তথ্য
        </div> --}}
        <div class="details-bodyy">
            <div style="text-align: center;margin-bottom: 15px;margin-top: -5px; font-weight: bold; color: #484646; padding: 15px;">
                অর্ডারটি কনফার্ম করতে আপনার নাম, ঠিকানা, মোবাইল নাম্বার, লিখে <span>অর্ডার কনফার্ম </span> করুন বাটনে ক্লিক করুন !
            </div>
            <div class="input-group input-group-margin">
                <input type="text" class="input-area @error('fullName') is-invalid @enderror"
                    wire:model.debounce.500ms="fullName" required id="inputField" />
                @error('fullName')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
                <label for="inputField" class="label">আপনার নাম <font color="red">*</font></label>
            </div>

            <div class="input-group input-group-margin">
                <input type="text" class="input-area @error('address') is-invalid @enderror"
                    wire:model.debounce.500ms="address" required id="address" />
                @error('address')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
                <label for="address" class="label">আপনার ঠিকানা <font color="red">*</font></label>
            </div>

            <div class="input-group input-group-margin">
                <input type="text" wire:model.debounce.500ms="phone"
                    class="input-area @error('phone') is-invalid @enderror" id="phone" required />
                @error('phone')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
                <label for="phone" class="label">আপনার মোবাইল <font color="red">*</font></label>
            </div>

            <div class="confirmButtonArea">
                <a href="" class="btn btn-lg btn-primary theme-bg mt-2" style="width: 100%" data-toggle="modal" data-target="#orderDetailsModal">অর্ডার
                    করুন</a>
            </div>
        </div>
    </div>

</div>
