<div>
    <div
        style="text-align: center;margin-bottom: 15px;margin-top: -5px; font-weight: bold; color: #484646; padding: 15px;">
        অর্ডারটি কনফার্ম করতে আপনার নাম, ঠিকানা, মোবাইল নাম্বার, লিখে <span>অর্ডার কনফার্ম </span> করুন বাটনে
        ক্লিক করুন !
    </div>
    <div class="input-group input-group-margin">
        <input type="text" placeholder="আপনার নাম লিখুন" class="input-area @error('fullName') is-invalid @enderror"
            wire:model.debounce.500ms="fullName" required id="inputField" />
        @error('fullName')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
        <label for="inputField" class="label">আপনার নাম <font color="red">*</font></label>
    </div>

    <div class="input-group input-group-margin">
        <input type="text" placeholder="রোড নাম্বার , বাসা নাম্বার , সহ সম্পূর্ণ ঠিকানা"
            class="input-area @error('address') is-invalid @enderror" wire:model.debounce.500ms="address" required
            id="address" />
        @error('address')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
        <label for="address" class="label">আপনার ঠিকানা <font color="red">*</font></label>
    </div>

    <div class="input-group input-group-margin">
        <input type="text" placeholder="+88 বাদে বাকি ১১ ডিজিট " wire:model.debounce.500ms="phone"
            class="input-area @error('phone') is-invalid @enderror" id="phone" required />
        @error('phone')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
        <label for="phone" class="label">আপনার মোবাইল <font color="red">*</font></label>
    </div>

    <fieldset>
        <legend>
            ডেলিভারি জোন
        </legend>
        <div style="margin-top: -10px; font-size: 16px;">
            <div>
                <select wire:model.debounce.500ms="deliveryArea" id="deliveryArea" class="form-control" name="deliveryArea">
                    <option value="inside_dhaka">ঢাকার ভিতরে (<b>{{ bnConvert()->number(siteData()->insideDhakaDeliveryFee()) }} ৳</b>)</option>
                    <option value="outside_dhaka">ঢাকার বাহিরে (<b>{{ bnConvert()->number(siteData()->outSideDhakaDeliveryFee()) }} ৳</b>)</option>
                </select>
            </div>
        </div>
    </fieldset>
</div>
