const Product = {
    calculateProductPrice: function() {
        let wholesalePrice = $("#wholesale_price").val();
        let profit = $("#profit").val();
        wholesalePrice = wholesalePrice ? parseInt(wholesalePrice) : 0;
        profit = profit ? parseInt(profit) : 0;
        let price = wholesalePrice + profit;
        $("#price").val(price);
    }
};

export default Product;