@php
    $labelWidth = 4;
    $inputWidth = 6;
@endphp

<form method="post" action="{{ route('admin.transaction.diposite.store') }}">
    @csrf
    <div class="mb-3 row required">
        <label for="type" class="col-sm-{{ $labelWidth }} col-form-label form-control-label">ধরন</label>
        <div class="col-sm-{{ $inputWidth }}">
            <select name="type" id="type" required class="form-control">
                <option value="">Select Type</option>
                <option value="member" selected>Member</option>
                <option value="unknown">Unknown</option>
            </select>
        </div>
    </div>

    <div class="mb-3 row required" id="memberField" style="">
        <label for="member_id" class="col-sm-{{ $labelWidth }} col-form-label form-control-label">মেম্বার</label>
        <div class="col-sm-{{ $inputWidth }}">
            <select name="member_id" id="member_id" class="form-control">
                <option value="">Select Member</option>
                @foreach ($members as $member)
                    <option value="{{ $member->id }}">{{ $member->name }} ({{ $member->organization_id }})</option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="mb-3 row required" id="nameField" style="display: none;">
        <label for="name" class="col-sm-{{ $labelWidth }} col-form-label form-control-label">নাম</label>
        <div class="col-sm-{{ $inputWidth }}">
            <input type="text" class="form-control" name="name" id="name">
        </div>
    </div>

    <div class="mb-3 row required" id="mobileField" style="display: none;">
        <label for="mobile" class="col-sm-{{ $labelWidth }} col-form-label form-control-label">মোবাইল</label>
        <div class="col-sm-{{ $inputWidth }}">
            <input type="text" class="form-control" name="mobile" id="mobile">
        </div>
    </div>

    <div class="mb-3 row required">
        <label for="amount" class="col-sm-{{ $labelWidth }} col-form-label form-control-label">পরিমাণ</label>
        <div class="col-sm-{{ $inputWidth }}">
            <input type="number" class="form-control" name="amount" id="amount">
        </div>
    </div>

    <div class="mb-3 row required">
        <label for="note" class="col-sm-{{ $labelWidth }} col-form-label form-control-label">নোট</label>
        <div class="col-sm-{{ $inputWidth }}">
            <textarea name="note" class="form-control" id="note" cols="20" rows="5"></textarea>
        </div>
    </div>

    <div class="mb-3 row">
        <label for="submitButton" class="col-sm-{{ $labelWidth }} col-form-label form-control-label"></label>
        <div class="col-sm-{{ $inputWidth }}">
            <button type="submit" class="btn btn-success">জমা করুন</button>
        </div>
    </div>
</form>

<script>
    $('#type').on('change', function() {
        var selectedType = $(this).val();
        if (selectedType === 'member') {
            $('#memberField').show();
            $('#nameField, #mobileField').hide();
        } else if (selectedType === 'unknown') {
            $('#memberField').hide();
            $('#nameField, #mobileField').show();
        } else {
            $('#memberField, #nameField, #mobileField').hide();
        }
    });
</script>
