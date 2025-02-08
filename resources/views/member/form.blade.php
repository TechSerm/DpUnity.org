@extends('store.layout.layout')
@section('title', 'সদস্য নিবন্ধন ফরম' . ' - ' . metaData()->getWebsiteTitle())
@section('content')

    <div class="store-card">
        <div class="header text-center">
            <h4 style="font-weight: bold">
                সদস্য নিবন্ধন ফরম
            </h4>
        </div>
        <div class="body p-3">
            @if (auth()->check())
                @php
                    $member = auth()->user()->member();
                @endphp
                @if ($member)
                    <div class="text-center">
                        @if ($member->is_approved == false)
                            <h1 style="text-align: center;color: #e67e22">
                                <i class="fa fa-clock"></i><br />
                            </h1>
                            <h4 style="color: #e67e22">আপনার রেজিস্ট্রেশন টি সম্পন্ন হয়েছে । আপনার তথ্যগুলো যাচাই এর জন্য
                                পেন্ডিং আছে। অ্যাডমিন থেকে যাচাই এর পর আপনাকে মেম্বার বানানো হবে। </h4>
                        @else
                            <h1 style="text-align: center;color: #27ae60">
                                <i class="fa fa-check"></i><br />
                            </h1>
                            <h4 style="color: #27ae60">স্বাগতম আপনার তথ্যগুলো যাচাই এর পর আপনাকে সদস্য বানানো হয়েছে। </h4>
                        @endif

                    </div>
                    <hr>
                    @include('member.readonly_form')
                @else
                    <div class="text-center">
                        <h1 style="text-align: center;color: #8e44ad">
                            <i class="fa fa-info-circle"></i><br />
                        </h1>
                        <h4 style="color: #8e44ad">
                            সদস্য হওয়ার জন্য ফর্ম টি সঠিক ভাবে পূরণ করুন। </h4>
                    </div>
                    <hr>
                    @include('member.create_form')
                @endif
            @else
            <div class="text-center mt-3">
                <h1 style="text-align: center;">
                    <i class="fa fa-exclamation-triangle"></i><br />
                </h1>
                <h4 style="">
                    সদস্য ফর্ম দেখতে এবং পূরণ করতে আপনাকে লগইন করতে হবে।  
                </h4>
                <a class="btn btn-info" href="{{route('login')}}"><i class="fas fa-sign-in-alt"></i> লগইন করুন</a>
            </div>

            @endif



        </div>
    </div>

@stop
@push('scripts')
    <script>
        function createMember(e) {
            let form = Helper.form(e);
            form.submit({
                success: {
                    callback: function(response) {
                        window.location.reload();
                    }
                }
            });
        }

        function previewFile(event, imageId) {

            var output = document.getElementById(imageId);
            if (!event.target.files[0]) {
                // output.src = $('#img-preview-default').attr('src');
            } else output.src = URL.createObjectURL(event.target.files[0]);
            output.onload = function() {
                URL.revokeObjectURL(output.src) // free memory
            }
        }
    </script>
@endpush
