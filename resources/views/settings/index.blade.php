@extends('layouts.app')



@section('content')
   
    <div class="card mt-2">
        <div class="card-header">
            Settings
        </div>
        <form action="{{ route('admin.settings.update') }}" data-reset="false" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3">
                        <div class="nav flex-column nav-pills left_tab_nav" id="tab" role="tablist"
                            aria-orientation="vertical">
                            <a class="nav-link active" id="WebInfo-tab" data-toggle="pill" href="#WebInfo" role="tab"
                                aria-controls="WebInfo" aria-selected="true">Web Info</a>
                            <a class="nav-link" id="LogoFavicon-tab" data-toggle="pill" href="#LogoFavicon" role="tab"
                                aria-controls="LogoFavicon" aria-selected="false">Logo &
                                Favicons</a>
                            <a class="nav-link" id="SocialLinks-tab" data-toggle="pill" href="#SocialLinks" role="tab"
                                aria-controls="SocialLinks" aria-selected="false">Social
                                Links</a>
                        </div>
                    </div>

                    <div class="col-md-9">
                        <div class="tab-content" id="tabContent">
                            @include('settings.webinfo')
                            @include('settings.logo')
                            @include('settings.shop')
                            @include('settings.seo')
                            @include('settings.social')
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-footer">
                <button type="submit" class="btn btn-success create_btn">Update</button>
                <br>
                <small><b>NB: *</b> marked are required field.</small>
            </div>
        </form>
    </div>


    <div class="modal fade detailsModal" tabindex="-1" role="dialog" aria-labelledby="detailsModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="detailsModalLabel">Details Item</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="detailsModalContent">
                </div>
            </div>
        </div>
    </div>
@endsection
