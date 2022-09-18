const Search = {
    searchUrl: null,
    searchQuery: null,
    pageStop: false,
    pageLoading: false,
    pageNo: null,
    init: function(parm) {
        this.searchUrl = parm.searchUrl;
        this.searchQuery = parm.searchQuery;
        this.pageNo = 1;
        console.log("page init success");
    },
    setSearchQuery: function(searchQuery) {
        this.searchQuery = searchQuery
    },
    delay: function(callback, ms) {
        var timer = 0;
        return function() {
            var context = this,
                args = arguments;
            clearTimeout(timer);
            timer = setTimeout(function() {
                callback.apply(context, args);
            }, ms || 0);
        };
    },
    loadInitPage: function() {
        Store.home.pageStop = false;
        this.pageNo = 1;
        $("#product-list").html("");
        // console.log("congratulations page start " + Store.home.pageNo);
        this.getProductPage();
    },
    loadProductPage: function() {
        // console.log("load product page working", this.pageLoading, this.pageStop);
        if (this.pageLoading === true || this.pageStop === true) return;
        //console.log("not wokirng");

        this.pageNo += 1;

        console.log("ajax page " + this.pageNo);
        this.getProductPage();
    },
    getProductPage: function() {
        this.pageLoading = true;
        $("#loader-area").show();
        $.get(this.searchUrl, {
            page: this.pageNo,
            q: this.searchQuery
        }, function(response) {
            $("#product-list").append(response);
            $("#loader-area").hide();
            Store.search.pageStop = response == "" ? true : false;
            Store.search.pageLoading = false;
            window.livewire.rescan();
        });
    },
    onSearchScroll: function() {
        if ($(window).scrollTop() + window.innerHeight + 10 >= document.body.scrollHeight) {
            if ($("#search").val() !== Store.search.searchQuery) return;
            Store.search.loadProductPage();
        }
    }
};

$(window).keyup('#search', Search.delay(function() {
    $("#product-list").html("working " + $("#search").val());
    Search.setSearchQuery($("#search").val());
    console.log("key success");
    Search.loadInitPage();
}, 500));

$(document.body).on('touchmove', Search.onSearchScroll); // for mobile
$(window).on('scroll', Search.onSearchScroll);


module.exports = { Search };