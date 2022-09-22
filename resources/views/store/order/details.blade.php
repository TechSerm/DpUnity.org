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

            border-radius: 5px;
        }

        .checkout-details .details-header {
            background-color: #8e44ad;
            color: #ffffff;
            text-align: center;
            padding: 5px;
            margin-bottom: 15px;
            border-radius: 5px;
        }

        .form-text {
            margin-left: 5px;
        }

        .details-body {
            padding: 7px;
        }
    </style>

    <div class="checkout-details">
        <div class="details-header">
            আপনার অর্ডার করা পণ্য আপনার কাছে পৌঁছানোর জন্য আপনি নিচের তথ্য গুলা পূরণ করেন !
        </div>
        <div class="details-body">
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
                <input type="text" class="input-area @error('address') is-invalid @enderror" wire:model.debounce.500ms="address" required id="address" />
                @error('address')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
                <label for="address" class="label">বাড়ির ঠিকানা <font color="red">*</font></label>
                <small id="addressHelp" class="form-text text-muted">বাড়ির ঠিকানা হিসেবে আপনি আপনার বাড়ির নম্বর অথবা
                    বাড়ির পাশের স্কুল , মশিদ, মাদ্রাসা , কবরস্থ , দুকান যেকুনু টি বেবহার করতে পারেন। তাহলে আমাদের
                    ডেলিভারি দিতে সুবিধা হব।</small>
            </div>

            <div class="input-group">
                <input type="text" wire:model.debounce.500ms="phone"
                    class="input-area @error('phone') is-invalid @enderror" id="phone" required />
                @error('phone')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
                <label for="phone" class="label">ফোন নম্বর <font color="red">*</font></label>
                <small id="phoneHelp" class="form-text text-muted">মোবাইল নম্বর টি অবসসই বাংলাদেশী মোবাইল নম্বর হতে হবে।
                    ডেলিভারি এর সময় আমরা এই নম্বর টিতে যুগাযুগ করবো </small>

            </div>

            <div wire:loading>Searching users...</div>
        </div>
    </div>

</div>
