@extends('store.layout.layout')
@section('title', 'সদস্য গণের তালিকা' . ' - ' . theme()->title())
@section('content')
<style>
    .member-card{
        height: 350px;
    }
</style>
    <div class="store-card">
        <div class="header text-center">
            <h4 style="font-weight: bold">
                {{ $category->toBangla() }}দের তালিকা
            </h4>
        </div>
        <div class="body">
            <div class="row">
                @foreach ($members as $member)
                    <div class="col-md-3">
                        <div class="card member-card mb-3">
                            <img src="{{ $member->cover_photo }}" alt="Cover" class="card-img-top">
                            <div class="card-body text-center">
                                <img src="{{ $member->image->src() }}"
                                    style="width:100px; max-height: 105px; margin-top:-65px" alt="User"
                                    class="img-fluid img-thumbnail rounded-circle border-1 mb-3">
                                <h5 class="card-title">{{ $member->name }}</h5>
                                <div class="text-muted font-size-sm">{{ $member->permanent_address }}</div>
                                <div class="text-secondary mb-1">{{ $member->present_address }} </div>
                            </div>
                            <div class="card-footer text-center">
                                <a href="{{route('members.profile', ['member' => $member->organization_id])}}" class="btn btn-info btn-sm" type="button"><i class="fa fa-eye"></i> বিস্তারিত দেখুন</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

@stop
