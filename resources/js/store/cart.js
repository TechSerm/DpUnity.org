const { Helper } = require("../helper/helper");

const Cart = {
    directOrder: function(btn) {
        let productId = $(btn).data("product_id");
        let csrf = $(btn).data("csrf");
        
        $(btn).prop("disabled", true);
        $(btn).html('<i class="fa fa-spinner fa-spin"></i>' + $(btn).html());
        $.post("/add_cart", {
            product_id: productId,
            _token: csrf
        }, function(response) {
            Helper.url.load(response.url, function(){
                document.body.scrollTop = document.documentElement.scrollTop = 0;
                window.livewire.rescan();
                Helper.toast.success(response.message);
            }, "loadBody");
            
        });
    },

}

module.exports = { Cart };