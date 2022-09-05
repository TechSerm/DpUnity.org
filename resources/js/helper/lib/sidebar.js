const Sidebar = {
    setup: function() {
        this.build(Helper.url.get());
    },
    setActive: function(link){
        link.addClass("active");
        link.parent().parent().parent().children().addClass('active');
        link.parent().parent().parent().children().collapse('show');
    },
    build: function(url) {
        url = (url.indexOf("?") > -1) ? url.substr(0, url.indexOf("?")) : url;
        $('#sidebar ul li a.active').each(function() {
            $(this).removeClass('active');
        });
        let curr;
        let _this = this;
        $('#sidebar ul li a').each(function() {
            let segment = $(this).data('segment');
            let segmentName = $(this).data('segment-name');
            let urlSegment = Helper.uri().segment(segment);
            urlSegment = !urlSegment ? '' : urlSegment;
            
            if (urlSegment == segmentName) {
                //active and show this link
                _this.setActive($(this));
                curr = $(this).parent().parent().parent().children();
                return false;
            }
        });
        if (curr != null) {
            $("#sidebar ul li a[data-toggle='collapse']").not(curr).next('ul').removeClass('show');
        }
    }
};
$(document).ready(function() {
    Sidebar.setup(Helper.url.get());
});
module.exports = {
    Sidebar
};