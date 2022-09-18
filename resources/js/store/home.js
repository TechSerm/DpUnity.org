const Home = {
    pageNo: 1,
    pageStop: false,
    pageLoading: false,
    searchQuery: null,
    init: function() {
        Store.home.pageNo = 1;
        Store.home.pageLoading = false;
        Store.home.pageStop = false;
    },
    loadHomeProduct: function(url) {
        if (Store.home.pageLoading === true || Store.home.pageStop === true) return;
        Store.home.pageLoading = true;
        Store.home.pageNo += 1;
        console.log("ajax call " + this.pageNo);
        $("#loader-area").show();
        $.get(url, {
            page: Store.home.pageNo
        }, function(response) {
            $("#product-list").append(response);
            $("#loader-area").hide();
            Store.home.pageStop = response == "" ? true : false;
            Store.home.pageLoading = false;
            window.livewire.rescan();
        });
    },

    loadSearchInitPage: function(url, searchQuery) {
        Store.home.pageStop = false;
        this.pageNo = 1;

        $("#product-list").html("");
        $("#loader-area").show();

        console.log("congratulations page start " + Store.home.pageNo);

        $.get(url, {
            page: Store.home.pageNo,
            q: searchQuery
        }, function(response) {
            $("#product-list").append(response);
            $("#loader-area").hide();
            Store.home.pageLoading = response == "" ? true : false;
            Store.home.pageLoading = false;
            window.livewire.rescan();
        });
    },
}

module.exports = { Home };