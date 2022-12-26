<div>
    <style>
        .input-group {
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
            border: 1px solid royalblue;
            box-shadow: 1px 5px 7px -2px rgba(170, 170, 170, 0.74);
        }

        .input-group .label {
            color: #595858;
            position: absolute;
            font-weight: bold;
            left: 13px;
            background: #ffffff;
            top: -8px;
            padding: 0 3px;
            font-size: 14px;
        }

        .input-group .is-invalid {
            border: 1px solid red;
        }

        .input-group .is-invalid:focus {
            border: 1px solid red;
        }

        .input-group .input-area:focus+.label {
            top: -8px;
            padding: 0 3px;
            font-size: 14px;
            color: royalblue;
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
            <div style="text-align: center;margin-bottom: 15px;margin-top: -5px; font-weight: bold; color: #484646">
                আপনার অর্ডার করা পণ্য আপনার কাছে পৌঁছানোর জন্য আপনি নিচের তথ্য গুলা পূরণ করেন !
            </div>
            <div class="input-group">
                <input type="text" class="input-area @error('fullName') is-invalid @enderror"
                    wire:model.debounce.500ms="fullName" required id="inputField" />
                @error('fullName')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
                <label for="inputField" class="label">নাম <font color="red">*</font></label>
            </div>

            <div class="input-group">
                <input type="text" class="input-area @error('address') is-invalid @enderror"
                    wire:model.debounce.500ms="address" required id="address" />
                @error('address')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
                <label for="address" class="label">বাড়ির ঠিকানা <font color="red">*</font></label>
                <small id="addressHelp" class="form-text text-muted">বাড়ির ঠিকানা হিসেবে আপনি আপনার বাড়ির নাম্বার / মসজিদ / মাদ্রাসা / কবরস্থান / দোকানের নাম যেকোনোটি ব্যাবহার করতে পারেন। ডেলিভারির সময় আমাদের ডেলিভারি ম্যান উক্ত ঠিকানায় গিয়ে আপনার সাথে যোগাযোগ করবে।</small>
            </div>

            <div class="input-group">
                <input type="text" wire:model.debounce.500ms="phone"
                    class="input-area @error('phone') is-invalid @enderror" id="phone" required />
                @error('phone')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
                <label for="phone" class="label">মোবাইল নাম্বার <font color="red">*</font></label>
                <small id="phoneHelp" class="form-text text-muted">মোবাইল নাম্বার টি অবশ্যই বাংলাদেশী মোবাইল নাম্বার হতে হবে। ডেলিভারির সময় এই নাম্বারটিতে যোগাযোগ করা হবে। </small>

            </div>
        </div>
    </div>

</div>
