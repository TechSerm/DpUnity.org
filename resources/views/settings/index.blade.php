@extends('layouts.app')



@section('content')
    <div class="content">
        <section class="">
            <div class="col-md-6">
                <h4>General settings</h4>
            </div>
        </section>
            <div class="content_body">
                <form action="#" method="POST" enctype="multipart/form-data">
                    {{-- <input type="hidden" name="_token" value=""> --}}

                    <div class="card border-light mt-3 shadow mb-5">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="nav flex-column nav-pills left_tab_nav" id="tab" role="tablist"
                                        aria-orientation="vertical">
                                        <a class="nav-link active" id="WebInfo-tab" data-toggle="pill" href="#WebInfo"
                                            role="tab" aria-controls="WebInfo" aria-selected="true">Web Info</a>
                                        <a class="nav-link" id="LogoFavicon-tab" data-toggle="pill" href="#LogoFavicon"
                                            role="tab" aria-controls="LogoFavicon" aria-selected="false">Logo &
                                            Favicons</a>
                                        <a class="nav-link" id="Shop-tab" data-toggle="pill" href="#Shop" role="tab"
                                            aria-controls="Shop" aria-selected="false">Shop</a>
                                        <a class="nav-link" id="SEO-tab" data-toggle="pill" href="#SEO" role="tab"
                                            aria-controls="SEO" aria-selected="false">SEO</a>
                                        <a class="nav-link" id="SocialLinks-tab" data-toggle="pill" href="#SocialLinks"
                                            role="tab" aria-controls="SocialLinks" aria-selected="false">Social
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
                            <button class="btn btn-success create_btn">Update</button>
                            <br>
                            <small><b>NB: *</b> marked are required field.</small>
                        </div>
                    </div>
                </form>

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

                
            </div>
    </div>
@endsection
