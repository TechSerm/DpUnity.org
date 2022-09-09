const Home = {
    pageNo: 1,
    pageStop: false,
    pageLoading: false,
    init: function() {
        Store.home.pageNo = 2;
        // alert("initial page working");
        console.log("new page working " + this.pageNo);
    },
    loadHomeProduct: function(url) {
        if (Store.home.pageLoading === true || Store.home.pageStop === true) return;
        Store.home.pageLoading = true;
        Store.home.pageNo += 1;
        console.log("ajax call " + this.pageNo);
        $.get(url, {
            page: Store.home.pageNo
        }, function(response) {
            $("#product-list").append(response);
            $("#loader-area").hide();
            Store.home.pageLoading = response == "" ? true : false;
            Store.home.pageLoading = false;
            window.livewire.rescan();
        });
    }
}

module.exports = { Home };