<style>
    .sidebar {
        height: 100%;
        background: #ffffff;
        color: #000000;
        position: fixed;
        margin-top: 0px;
        padding-bottom: 80px;
        overflow-y: scroll;
        width: 240px;
        z-index: 1005;
        border: 1px solid #eeeeee;
        border-width: 1px 1px 0px 0px;
    }

    .storeSidebarActiveContent {
        margin-left: 240px;
    }

    @media only screen and (max-width: 600px) {
        .storeSidebarActiveContent {
            margin-left: 0px;
            overflow-y: hidden;
            opacity: 0.1;
        }

        .sidebarOpen {
            overflow: hidden;
        }
    }

    .sidebar::-webkit-scrollbar {
        width: 5px;
    }

    .sidebar::-webkit-scrollbar-track {
        -webkit-box-shadow: inset 0 0 6px rgba(0, 0, 0, 0.3);
        border-radius: 0px;
    }

    .sidebar::-webkit-scrollbar-thumb {
        border-radius: 10px;
        -webkit-box-shadow: inset 0 0 6px rgba(0, 0, 0, 0.5);
    }

    .sidebar .link{
        border: 1px solid #eeeeee;
        border-radius: 5px;
        width: 220px;
        display: block;
        padding: 5px;
        margin: 5px 10px 5px 5px;
        color: #000000;
        font-size: 18px;
    }
    .sidebar .link:hover{
        text-decoration: none;
        background: #f5f5f5;
    }

</style>


<div class="sidebar" id="shopSidebar">
    <a href="/" class="link"><i class="fa fa-home" aria-hidden="true"></i> হোম</a>
    <a href="/categories" class="link"><i class="fa fa-list-alt" aria-hidden="true"></i> ক্যাটেগরি</a>
    <a href="" class="link"><i class="fa fa-shopping-cart" aria-hidden="true"></i> অর্ডার</a>
    <a href="/admin" data-turbolinks="false" class="link"><i class="fa fa-user" aria-hidden="true"></i> অ্যাডমিন প্যানেল</a>
</div>

@push('scripts')
    <script>
        Store.menu.initSidebar();
    </script>
@endpush
