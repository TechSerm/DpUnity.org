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
    $(window).on('popstate', function(e) {
        Helper.url.load(Helper.url.get(), (response) => {});
    });
    /*
     * Modal button action
     */
    $('body').on('click', 'button[data-toggle="modal"]', function(e) {
        require('./modal.js').ModalBuild.setUp($(this));
    });
    /*
     * Modal link action
     */
    $('body').on('click', 'a[data-toggle="modal"]', function(e) {
        require('./modal.js').ModalBuild.setUpLink($(this));
    });
    /*
     * Delete button action
     */
    $('body').on('click', 'button[data-toggle="delete"]', function(e) {
        require('./form_build.js').FormBuild.delete($(this));
    });
    /*
     * Confirm button action
     */
    $('body').on('click', 'button[data-toggle="confirm"]', function(e) {
        require('./form_build.js').FormBuild.confirm($(this));
    });
    /*
     * Form submit action
     */
    $('body').on('submit', 'form', function(e) {
        //if form method is get then its not call submit function
        if ($(this).attr('method').toLowerCase() === "get") {

            return;
        }
        e.preventDefault();
        require('./form_build.js').FormBuild.submit($(this));
    });
});
$(window).on('load', function() {
    $("body").fadeIn(2000);
});