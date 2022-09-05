const Loader = {
    top: {
        start: function() {
            $("#top-loader").show();
            $("#top-loader-message").show();
        },
        stop: function() {
            $("#top-loader").hide();
            $("#top-loader-message").hide();
        }
    },
    div: function(div) {
        div = (div instanceof jQuery) ? div : $("#" + div);
        div.html('<div style="text-align: center;"><i class="fa fa-spinner fa-pulse" style="font-size: 7em"></i></div>');
    }
}

module.exports = { Loader };