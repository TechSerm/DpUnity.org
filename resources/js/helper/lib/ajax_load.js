const { Helper } = require("../helper");

//single page load
$(document).ready(function() {
    $('body').on('click', 'a', function(e) {
        return;
        var self = $(this);
        var link = $(this).attr("href");
        /*
        - if link is null like
        - <a onclick="">link</a>
        */
        if (link == null || link == "") {
            e.preventDefault();
            return;
        }
        if ($(this).data('reload') == true) return;
        if (link.startsWith("#")) return;
        if ($(this).attr("target") == "_blank") {
            //window.open(link, '_blank');
            return;
        }
        if ($(this).data('toggle') == 'tab') return;
        if ($(this).data('toggle') == 'modal') return;
        if ($(this).data('function') != null) {
            e.preventDefault();
            eval($(this).data('function'));
            return;
        }
        link = Helper.url.build(new URL(link, location.origin).href);
        if (!Helper.url.checkValidUrl(link)) return;
        if (link.indexOf(document.domain) >= 0) {
            e.preventDefault();
            /*
             * check scrape area field is in link
             */
            let scrapeArea = $(this).data('scrape-area');
            scrapeArea = scrapeArea != null ? scrapeArea : "app-body";
            Helper.div(scrapeArea).load({
                url: link,
                loader: "top",
                changeUrl: true,
                scrapeArea: scrapeArea
            }, function(response) {
                if (self.link != Helper.url.get()) $(window).scrollTop(0);
                if (self.attr("callback")) {
                    try {
                        eval(self.attr("callback"));
                    } catch (e) {}
                }
            });
        } else {
            e.preventDefault();
            window.open(link, '_blank');
        }
    });
});
$(window).on('load', function() {
    $("body").fadeIn(2000);
});