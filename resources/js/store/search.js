const Search = {
    searchUrl: null,
    searchQuery: null,
    pageStop: false,
    pageLoading: false,
    searchResultUrl: null,
    pageNo: null,
    init: function(parm) {
        this.searchUrl = parm.searchUrl;
        this.searchResultUrl = parm.searchResultUrl;
        this.searchQuery = parm.searchQuery;
        this.pageStop = false;
        this.pageLoading = false;
    },

    isSearchPage: function() {
        return window.location.href.indexOf("search") !== -1;
    },

    getSearchPageQueryUrl: function() {
        let pageUrl = new URL(this.searchResultUrl);
        pageUrl.searchParams.set('q', this.searchQuery ? this.searchQuery : '');
        return pageUrl;
    },

    chageSearchQuery: function() {
        history.replaceState({}, '', this.getSearchPageQueryUrl());
    },

    resetProductList: function() {
        this.pageNo = 1;
        this.pageStop = false;
        $("#searchResultProductList").html("");
    },

    setSearchQuery: function() {
        this.searchQuery = $("#search").val();
    },

    goSearchPage: function() {
        this.pageNo = 2;
        Turbolinks.visit(this.getSearchPageQueryUrl(), {
            action: "replace"
        });
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
        if (!this.isSearchPage()) return;
        this.goSearchPage();
    },

    isLoadDisable: function() {
        return this.pageLoading === true || this.pageStop === true;
    },

    loadProductPage: function() {
        if (this.isLoadDisable()) return;
        this.pageLoading = true;
        $("#search-loader-area").show();
        $.get(this.searchUrl, {
            page: this.pageNo,
            q: this.searchQuery
        }, function(response) {
            Store.search.renderProductPage(response);
        });
    },

    renderProductPage: function(response) {
        $("#searchResultProductList").append(response);
        $("#search-loader-area").hide();
        this.pageStop = response == "" ? true : false;
        this.pageLoading = false;
        this.pageNo += 1;
        window.livewire.rescan();
    },

    onSearchScroll: function() {
        if (window.location.href.indexOf("search") == -1) return;
        if ($(window).scrollTop() + window.innerHeight + 10 >= document.body.scrollHeight) {
            if ($("#search").val() !== Store.search.searchQuery) return;
            Store.search.loadProductPage();
        }
    },

    searchProduct: function() {
        this.setSearchQuery();
        this.goSearchPage();
    }
};

$(document.body).on('touchmove', Search.onSearchScroll); // for mobile
$(window).on('scroll', Search.onSearchScroll);

module.exports = { Search };