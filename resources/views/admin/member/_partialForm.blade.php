@php
    $isReadOnly = $member ? '' : '';
@endphp
<div class="row">
    <div class="col-md-12 mb-3">
        {!! Form::label('organization_id', 'প্রতিষ্ঠানের আইডি') !!}
        {!! Form::text('organization_id', null, [
            'class' => 'form-control',
            'placeholder' => 'প্রতিষ্ঠানের আইডি',
            'required',
            $isReadOnly,
        ]) !!}
    </div>

    <div class="col-md-12 mb-3">
        {!! Form::label('is_approved', 'অবস্থা') !!}
        {!! Form::select(
            'is_approved',
            [
                '0' => 'Pending',
                '1' => 'Approved',
            ],
            null,
            ['class' => 'form-control', 'required'],
        ) !!}
    </div>

    <div class="col-md-12 mb-3">
        {!! Form::label('name', 'নাম') !!}
        {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'নাম', 'required', $isReadOnly]) !!}
    </div>

    <div class="col-md-12 mb-3">
        {!! Form::label('father_name', 'পিতার নাম') !!}
        {!! Form::text('father_name', null, [
            'class' => 'form-control',
            'placeholder' => 'পিতার নাম',
            'required',
            $isReadOnly,
        ]) !!}
    </div>

    <div class="col-md-12 mb-3">
        {!! Form::label('mother_name', 'মাতার নাম') !!}
        {!! Form::text('mother_name', null, [
            'class' => 'form-control',
            'placeholder' => 'মাতার নাম',
            'required',
            $isReadOnly,
        ]) !!}
    </div>
</div>

<div class="row">
    <div class="col-md-12 mb-3">
        {!! Form::label('date_of_birth', 'জন্ম তারিখ') !!}
        {!! Form::date('date_of_birth', $member ? $member->date_of_birth->format('Y-m-d') : null, [
            'class' => 'form-control',
            'required',
            $isReadOnly,
        ]) !!}
    </div>

    <div class="col-md-12 mb-3">
        {!! Form::label('nationality', 'জাতীয়তা') !!}
        {!! Form::select(
            'nationality',
            [
                '' => '-- জাতীয়তা নির্বাচন করুন --',
                'Bangladeshi' => 'বাংলাদেশী',
                'Indian' => 'ভারতীয়',
                'Pakistani' => 'পাকিস্তানি',
                'Nepalese' => 'নেপালী',
                'Sri Lankan' => 'শ্রীলঙ্কান',
                'Other' => 'অন্যান্য',
            ],
            null,
            ['class' => 'form-control', 'required', $isReadOnly],
        ) !!}
    </div>

    <div class="col-md-12 mb-3">
        {!! Form::label('religion', 'ধর্ম') !!}
        {!! Form::select(
            'religion',
            [
                '' => '-- ধর্ম নির্বাচন করুন --',
                'Islam' => 'ইসলাম',
                'Hinduism' => 'হিন্দু ধর্ম',
                'Christianity' => 'খ্রিস্টধর্ম',
                'Buddhism' => 'বৌদ্ধধর্ম',
                'Other' => 'অন্যান্য',
            ],
            null,
            ['class' => 'form-control d-block w-100', 'required', $isReadOnly],
        ) !!}
    </div>

    <div class="col-md-12 mb-3">
        {!! Form::label('present_address', 'বর্তমান ঠিকানা') !!}
        {!! Form::textarea('present_address', null, [
            'class' => 'form-control',
            'required',
            'cols' => 30,
            'rows' => 2,
            $isReadOnly,
        ]) !!}
    </div>

    <div class="col-md-12 mb-3">
        {!! Form::label('permanent_address', 'স্থায়ী ঠিকানা') !!}
        {!! Form::textarea('permanent_address', null, [
            'class' => 'form-control',
            'cols' => 30,
            'rows' => 2,
            'required',
            $isReadOnly,
        ]) !!}
    </div>

    <div class="col-md-12 mb-3">
        {!! Form::label('occupation', 'পেশা') !!}
        {!! Form::text('occupation', null, [
            'class' => 'form-control',
            'placeholder' => 'উদাহরণ: প্রবাসী',
            'required',
            $isReadOnly,
        ]) !!}
    </div>

    <div class="col-md-12 mb-3">
        {!! Form::label('nid', 'জাতীয় পরিচয়পত্র (এনআইডি)') !!}
        {!! Form::text('nid', null, [
            'class' => 'form-control',
            'placeholder' => 'জাতীয় পরিচয়পত্র নম্বর',
            $isReadOnly,
        ]) !!}
    </div>

    <div class="col-md-12 mb-3">
        {!! Form::label('mobile', 'মোবাইল নম্বর') !!}
        {!! Form::tel('mobile', null, ['class' => 'form-control', 'placeholder' => '', 'required', $isReadOnly]) !!}
    </div>

    <div class="col-md-12 mb-3">
        {!! Form::label('blood_group', 'রক্তের গ্রুপ') !!}
        {!! Form::select(
            'blood_group',
            [
                '' => 'রক্তের গ্রুপ নির্বাচন করুন',
                'A+' => 'A+',
                'A-' => 'A-',
                'B+' => 'B+',
                'B-' => 'B-',
                'AB+' => 'AB+',
                'AB-' => 'AB-',
                'O+' => 'O+',
                'O-' => 'O-',
            ],
            null,
            ['class' => 'form-control d-block w-100', $isReadOnly],
        ) !!}
    </div>
</div>

<div class="row">
    <div class="col-md-12 mb-3">
        {!! Form::label('image', 'ছবি') !!}
        {!! Form::file('image', [
            'class' => 'form-control',
            'onchange' => "previewFile(event, 'image_preview')",
            $isReadOnly,
        ]) !!}
        @php
            $image = asset('images/default.png');
            if ($member && $member->image) {
                $image = $member->image->src();
            }
        @endphp
        <img src="{{ $image }}" id="image_preview" class="img-thumbnail mt-2" width="100px" alt="">
    </div>
    @php
        $signature = asset('images/default.png');
        if ($member && $member->signature) {
            $signature = $member->signature->src();
        }
    @endphp
    <div class="col-md-6 mb-3">
        {!! Form::label('signature', 'স্বাক্ষর') !!}
        {!! Form::file('signature', [
            'class' => 'form-control',
            'onchange' => "previewFile(event, 'thumbnail_preview')",
            $isReadOnly,
        ]) !!}
        <img src="{{ $signature }}" id="thumbnail_preview" class="img-thumbnail mt-2" width="100px" alt="">
    </div>
</div>

<hr class="mb-4">

{!! Form::submit('Update', ['class' => 'btn btn-primary btn-lg btn-block']) !!}
