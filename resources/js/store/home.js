const Home = {
    pageNo: 1,
    url: null,
    pageStop: false,
    pageLoading: false,
    searchQuery: null,
    init: function(parm) {
        Store.home.pageNo = 1;
        Store.home.url = parm.url;
        Store.home.pageLoading = false;
        Store.home.pageStop = false;
    },
    loadMoreHomeProduct: function() {
        if (!this.isHomePage()) return;
        if (Store.home.pageLoading === true || Store.home.pageStop === true) return;
        Store.home.pageLoading = true;
        Store.home.pageNo += 1;
        console.log("home ajax call " + this.pageNo);
        $("#loader-area").show();
        $.get(Store.home.url, {
            page: Store.home.pageNo
        }, function(response) {
            $("#product-list").append(response);
            $("#loader-area").hide();
            Store.home.pageStop = response == "" ? true : false;
            Store.home.pageLoading = false;
            window.livewire.rescan();
        });
    },

    onPageScroll: function() {
        if ($(window).scrollTop() + window.innerHeight + 10 >= document.body.scrollHeight) {
            Store.home.loadMoreHomeProduct();
        }
    },

    isHomePage: function() {
        let uri = require('urijs')();
        return uri.segmentCoded(0) == '' ? true : false;
    }
}

$(document.body).on('touchmove', Home.onPageScroll); // for mobile
$(window).on('scroll', Home.onPageScroll);

module.exports = { Home };