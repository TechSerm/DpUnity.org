const { Helper } = require("../helper/helper");

const Cart = {
    directOrder: function(btn) {
        let productId = $(btn).data("product_id");
        let csrf = $(btn).data("csrf");
        
        $(btn).prop("disabled", true);
        $(btn).html('<i class="fa fa-spinner fa-spin"></i> ' + $(btn).html());
        let quantity = parseInt($("#quantityVal").val());
        let data = {
            product_id: productId,
            _token: csrf
        };
        if(quantity){
            data['quantity'] = quantity;
        }

        $.post("/add_cart", data, function(response) {
            
            Helper.toast.success(response.message);
            Turbolinks.visit(response.url, {
                action: "replace"
            });
            
        });
    },

    addCartOrder: function(btn) {
        let productId = $(btn).data("product_id");
        let csrf = $(btn).data("csrf");
        
        $(btn).prop("disabled", true);
        let preHtml = $(btn).html();
        $(btn).html('<i class="fa fa-spinner fa-spin"></i> ' + $(btn).html());
        
        let quantity = parseInt($("#quantityVal").val());

        $.post("/add_cart", {
            product_id: productId,
            quantity: quantity,
            _token: csrf
        }, function(response) {
            Helper.toast.success(response.message);
            $(btn).html(preHtml);
            $(btn).prop("disabled", false);
        });
    },

}

module.exports = { Cart };