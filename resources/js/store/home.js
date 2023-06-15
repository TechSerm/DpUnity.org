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
        $("#loader-area").show();
        $.get(Store.home.url, {
            page: Store.home.pageNo
        }, function(response) {
            $("#product-list").append(response);
            $("#loader-area").hide();
            Store.home.pageStop = response == "" ? true : false;
            Store.home.pageLoading = false;
            window.livewire.rescan();
            Store.home.updateProductImageSize();
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
    },

    updateProductImageSize: function() {

        let divWidth = $(".product-div").width();
        let diff = divWidth - 150;
        let heightWeight = Math.min(300, 150 + diff);
        $(".product-img").height(heightWeight).width(heightWeight);
        // $(".product-card-height").height(300 + diff);

        let heightWeightIsShowPage = Math.min(500, 350 + (divWidth - 350));
        $(".product-img-isShowPage").height(heightWeightIsShowPage).width(heightWeightIsShowPage);

        //console.log(divWidth);
        // console.log("height: " + ($(".product-div").height() - divWidth));
        //console.log(heightWeightIsShowPage);
        // $(".product-card-height-isShowPage").height(500 + diff);

    }
}

$(document.body).on('touchmove', Home.onPageScroll); // for mobile
$(window).on('scroll', Home.onPageScroll);

module.exports = { Home };