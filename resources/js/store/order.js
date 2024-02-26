const Order = {
    create: function(btn) {
        let url = $(btn).data('url');
        let token = $(btn).data('token');
        $("#orderConfirmBtn").prop("disabled", true);
        $("#orderConfirmBtn").html('<i class="fa fa-spinner fa-spin"></i> প্রসেসিং হচ্ছে');
        $.post(url, {
            '_token': token
        }, function(response) {
            window.location.href = response.url;
            // Turbolinks.visit(response.url, {
            //     action: "replace"
            // });
        }).fail(function(error) {
            let response = JSON.parse(error.responseText);
            $("#orderConfirmBody").html(response.body);
            $("#orderConfirmResponseMessage").html(response.message);
            window.livewire.rescan();

            $("#orderConfirmBtn").html('অর্ডার কনফার্ম করুন');
            $("#orderConfirmBtn").prop("disabled", false);
        });
    },

}

module.exports = { Order };