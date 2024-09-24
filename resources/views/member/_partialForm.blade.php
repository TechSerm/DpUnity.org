@php
    $isReadOnly = $member ? 'disabled' : '';
@endphp
<style>
    input[type="checkbox"] {
        width: 15px;
        height: 15px;
        transform: scale(1.5); /* Scale the checkbox */
        -webkit-transform: scale(1.5); /* For Safari */
        margin: 5px;
    }
</style>

<div class="row">

    @if ($member && $member->organization_id != '')
        <div class="col-md-6 mb-3">
            {!! Form::label('organization_id', 'আইডি') !!}
            {!! Form::text('organization_id', null, [
                'class' => 'form-control',
                'placeholder' => 'আইডি',
                'required',
                $isReadOnly,
            ]) !!}
        </div>
    @endif
    <div class="col-md-6 mb-3">
        {!! Form::label('category', 'ক্যাটেগরি') !!}
        {!! Form::select(
            'category',
            [
                '' => '-- ক্যাটেগরি নির্বাচন করুন --',
                'soddosho' => 'সদস্য',
                'data_soddosho' => 'দাতা সদস্য',
                'shohojoddha' => 'সহযোদ্ধা',
                'shuvokankkhi' => 'শুভাকাঙ্ক্ষী',
            ],
            null,
            ['class' => 'form-control d-block w-100', 'required', $isReadOnly],
        ) !!}
    </div>
    <div class="col-md-12 mb-3">
        {!! Form::label('name', 'নাম') !!}
        {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'নাম', 'required', $isReadOnly]) !!}
    </div>

    <div class="col-md-6 mb-3">
        {!! Form::label('father_name', 'পিতার নাম') !!}
        {!! Form::text('father_name', null, [
            'class' => 'form-control',
            'placeholder' => 'পিতার নাম',
            'required',
            $isReadOnly,
        ]) !!}
    </div>

    <div class="col-md-6 mb-3">
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
    <div class="col-md-4 mb-3">
        {!! Form::label('date_of_birth', 'জন্ম তারিখ') !!}
        {!! Form::date('date_of_birth', $member ? $member->date_of_birth->format('Y-m-d') : null, [
            'class' => 'form-control',
            'required',
            $isReadOnly,
        ]) !!}
    </div>

    <div class="col-md-4 mb-3">
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

    <div class="col-md-4 mb-3">
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

    <div class="col-md-6 mb-3">
        {!! Form::label('present_address', 'বর্তমান ঠিকানা') !!}
        {!! Form::textarea('present_address', null, [
            'class' => 'form-control',
            'required',
            'cols' => 30,
            'rows' => 2,
            $isReadOnly,
        ]) !!}
    </div>

    <div class="col-md-6 mb-3">
        {!! Form::label('permanent_address', 'স্থায়ী ঠিকানা') !!}
        {!! Form::textarea('permanent_address', null, [
            'class' => 'form-control',
            'required',
            'cols' => 30,
            'rows' => 2,
            $isReadOnly,
        ]) !!}
    </div>

    <div class="col-md-6 mb-3">
        {!! Form::label('occupation', 'পেশা') !!}
        {!! Form::text('occupation', null, [
            'class' => 'form-control',
            'placeholder' => 'উদাহরণ: প্রবাসী',
            'required',
            $isReadOnly,
        ]) !!}
    </div>

    <div class="col-md-6 mb-3">
        {!! Form::label('nid', 'জাতীয় পরিচয়পত্র (এনআইডি)') !!}
        {!! Form::text('nid', null, [
            'class' => 'form-control',
            'placeholder' => 'জাতীয় পরিচয়পত্র নম্বর',
            $isReadOnly,
        ]) !!}
    </div>

    <div class="col-md-6 mb-3">
        {!! Form::label('mobile', 'মোবাইল নম্বর') !!}
        {!! Form::tel('mobile', null, ['class' => 'form-control', 'placeholder' => '', 'required', $isReadOnly]) !!}
    </div>

    <div class="col-md-6 mb-3">
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
    <div class="col-md-6 mb-3">
        {!! Form::label('image', 'ছবি') !!}
        {!! Form::file('image', [
            'class' => 'form-control',
            'required',
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
            'required',
            'onchange' => "previewFile(event, 'thumbnail_preview')",
            $isReadOnly,
        ]) !!}
        <img src="{{ $signature }}" id="thumbnail_preview" class="img-thumbnail mt-2" width="100px" alt="">
    </div>
    <div class="col-md-12">
        <input type="checkbox" {{$isReadOnly != '' ? 'checked':''}} required   {{$isReadOnly}}>
        আমি এই মর্মে অঙ্গীকার করছি যে, 'দৌলতপুর প্রবাসী সামাজিক সংগঠনে’র যাবতীয় গঠনতন্ত্র মেনে চলবো। সংগঠনের কার্যক্রম
        পরিপন্থী কোন কাজ আমার দ্বারা হবে না। আমার দ্বারা সংগঠনের কোনো ক্ষতি হলে, সংগঠন আমার সদস্য প্রতি স্থগিত বা বাতিল
        করার ক্ষমতা রাখে।

        আমি সংগঠনের সকল নিয়ম-কানুন সুস্থভাবে জেনে বুঝে সংগঠনের সদস্য হতে আগ্রহ প্রকাশে নিম্নে স্বাক্ষর করলাম।
    </div>
</div>


<hr class="mb-4">
@if (!$member)
    {!! Form::submit('জমা দিন', ['class' => 'btn btn-primary btn-lg btn-block']) !!}
@endif
