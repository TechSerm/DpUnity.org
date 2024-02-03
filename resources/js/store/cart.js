const { Helper } = require("../helper/helper");

const Cart = {
    directOrder: function(btn) {
        let productId = $(btn).data("product_id");
        let csrf = $(btn).data("csrf");
        $.post("/add_cart", {
            product_id: productId,
            _token: csrf
        }, function(response) {
            Helper.url.load(response.url, function(){}, "loadBody");
            Helper.toast.success(response.message);
        });
    },

}

module.exports = { Cart };