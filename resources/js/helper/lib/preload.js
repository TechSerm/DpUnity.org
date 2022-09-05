
//single page load
$(document).ready(function() {
    $('body').on('click', 'a', function(e) {
        var self = $(this);
        var link = $(this).attr("href");
        var target = $(this).attr("target");
        var modal = $(this).attr("modal");
        var callback = $(this).attr("callback");
        if (target == "_blank") {
            if (link == "#") return;
            window.open(link, '_blank');
            return;
        }
        e.preventDefault();
        if (modal == "true") {
            modalType = $(this).attr("modal-type");
            modalWidth = $(this).attr("modal-width");
            modalHeader = $(this).attr("modal-header");
            new Modal(modalType, modalWidth).load(link, modalHeader);
            return;
        }
        if (link == "#") return;
        if (!url.checkValidUrl(link)) return;
        if (link.indexOf(document.domain) >= 0) {
            if ($(this).attr("logout-btn")) return;
            e.preventDefault();
            url.load(link, function(response) {
                if (self.link != url.get()) $(window).scrollTop(0);
                if (self.attr("callback")) {
                    eval(self.attr("callback"));
                }
            });
        } else {
            e.preventDefault();
            window.open(link, '_blank');
        }
    });
    $(window).on('popstate', function(event) {
        url.load(url.get(), function(response) {});
    });
});
