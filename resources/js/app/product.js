const Product = {
    calculateProductPrice: function () {
        let wholesalePrice = $("#wholesale_price").val();
        let profit = $("#profit").val();
        wholesalePrice = wholesalePrice ? parseInt(wholesalePrice) : 0;
        profit = profit ? parseInt(profit) : 0;
        let price = wholesalePrice + profit;
        $("#price").val(price);
    },
    edit: require('./product_edit.js').Edit,
    update: function (e) {
        let form = Helper.form(e);
        form.append('description', this.edit.getEditorData());
        form.submit({
            success: {
                callback: function (response) {

                }
            }
        });
    },
    updateToggle: function (e) {
        let input = $(e);
        let url = input.data('url');
        let data = {
            url: input.data('url')
        };

        if (input.data('type') == "hot_deals") {
            data['hot_deals_enable'] = input.is(":checked");
        } else if (input.data('type') == "status") {
            data['status_enable'] = input.is(":checked");
        }

        $.post(url, Helper.config.setToken(data), function (data) {
            Helper.toast.success(data.message);
        });
    }
};

module.exports = {
    Product
};