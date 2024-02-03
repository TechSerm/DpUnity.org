<div class="home-list" style="background: #edfffc">
    @php
        $labelWidth = 4;
        $inputWidth = 6;
    @endphp
    <div class="home-list-header" style="background: #8e44ad; color: #ffffff">তথ্য গুলা দিয়ে আমাদের সহায়তা করুন</div>
    <div class="card-header  mb-3" style="background: #e67e22; color: #ffffff">
        তথ্য গুলা নেয়ার উদ্দেশ্য হচ্ছে আরও সঠিক এবং নিখুঁত ভাবে আপনার দরকারি পণ্য গুলা আপনার কাছে প্রদর্শন করা। তথ্য
        গুলা দিতে আপনার সর্বোচ্চ ৫ মিনিট লাগবে। বিবিসেনাকে আপনার আরও উপযোগী করে তুলতে আপনার তথ্য গুলা দিয়ে সহায়তা করুন।
    </div>
    {!! Form::open([
        'route' => ['survey_form_save.store'],
        'files' => true,
        'class' => 'form-horizontal',
    ]) !!}

    <div class="mb-3 row">
        <label for="address" class="col-sm-{{ $labelWidth }} col-form-label form-control-label">ঠিকানা <span
                style="color: red">*</span></label>
        <div class="col-sm-{{ $inputWidth }}">
            {!! Form::text('address', null, ['class' => 'form-control ', 'id' => 'address', 'required' => true]) !!}
        </div>
    </div>

    <div class="mb-3 row">
        <label for="mobile_number" class="col-sm-{{ $labelWidth }} col-form-label form-control-label">মোবাইল নম্বর
            <span style="color: red">*</span></label>
        <div class="col-sm-{{ $inputWidth }}">
            {!! Form::text('mobile_number', null, ['class' => 'form-control ', 'id' => 'mobile_number', 'required' => true]) !!}
        </div>
    </div>

    <div class="mb-3 row">
        <label for="total_member" class="col-sm-{{ $labelWidth }} col-form-label form-control-label">পরিবারের মোট
            সদস্য সংখ্যা <span style="color: red">*</span></label>
        <div class="col-sm-{{ $inputWidth }}">
            {!! Form::number('total_member', null, ['class' => 'form-control ', 'id' => 'total_member', 'required' => true]) !!}
        </div>
    </div>

    <div class="mb-3 row">
        <label for="member_under_18" class="col-sm-{{ $labelWidth }} col-form-label form-control-label">পরিবারে ১৮
            বছরের নিচে সদস্য সংখ্যা <span style="color: red">*</span></label>
        <div class="col-sm-{{ $inputWidth }}">
            {!! Form::number('member_under_18', null, [
                'class' => 'form-control ',
                'id' => 'member_under_18',
                'required' => true,
            ]) !!}
        </div>
    </div>

    <div class="mb-3 row">
        <label for="occupation" class="col-sm-{{ $labelWidth }} col-form-label form-control-label">পরিবারে যে আয় করে
            তার পেশা<span style="color: red">*</span></label>
        <div class="col-sm-{{ $inputWidth }}">
            {!! Form::text('occupation', null, ['class' => 'form-control ', 'id' => 'occupation', 'required' => true]) !!}
        </div>
    </div>

    <div class="mb-3 row">
        <label for="income" class="col-sm-{{ $labelWidth }} col-form-label form-control-label">মাসিক মোট
            আয়</label>
        <div class="col-sm-{{ $inputWidth }}">
            {!! Form::select(
                'income',
                [
                    '10<' => '১০ হাজার টাকার নিচে',
                    '10> & 20<' => '১০ থেকে ২০ হাজার টাকা',
                    '20> & 30<' => '২০ থেকে ৩০ হাজার টাকা',
                    '30> & 40<' => '৩০ থেকে ৪০ হাজার টাকা',
                    '40> & 50<' => '৪০ থেকে ৫০ হাজার টাকা',
                    '50>' => '৫০ হাজার টাকার উপরে',
                ],
                null,
                [
                    'placeholder' => 'নির্বাচন করুন',
                    'class' => 'form-control ',
                    'id' => 'income',
                ],
            ) !!}
        </div>
    </div>

    <div class="mb-3 row">
        <label for="time_save"
            class="col-sm-{{ $labelWidth }} col-form-label form-control-label">{{ App\Helpers\Constant::SITE_NAME }}
            থেকে বাজার করলে আপনার মূল্যবান সময় বাঁচবে ও কষ্ট কম হবে। আপনি কি একমত?</label>
        <div class="col-sm-{{ $inputWidth }}">
            {!! Form::select('time_save', ['yes' => 'হ্যাঁ', 'no' => 'না', 'unknown' => 'বুঝতে পারছি না'], null, [
                'placeholder' => 'নির্বাচন করুন',
                'class' => 'form-control ',
                'id' => 'time_save',
            ]) !!}
        </div>
    </div>

    <div class="mb-3 row">
        <label for="category" class="col-sm-{{ $labelWidth }} col-form-label form-control-label">বিবিসেনা থেকে আপনি
            কী কী বাজার করতে চান?</label>
        <div class="col-sm-{{ $inputWidth }}">
            @foreach ($categories as $category)
                {!! Form::checkbox('category[]', $category->name, false) !!} {{ $category->name }}<br />
            @endforeach
        </div>
    </div>

    <button type="submit" class="btn btn-primary">সাবমিট করুন</button>
    {!! Form::close() !!}

</div>
