const Menu = {
    isSidebarLoad: false,
    isSidebarShow: false,
    goNewPage: function(url) {
        window.location.href = url;
    },
    initSidebar: function(isHardShow = false) {
        let isMobileDevice = this.isMobileDevice();

        if (isMobileDevice === true) {
            this.isSidebarShow = false;
        } else {
            if (this.isSidebarLoad === false) {
                this.isSidebarShow = true;
                this.isSidebarLoad = true;
            } else if (isHardShow == true) {
                this.isSidebarShow = true;
            }
        }
        this.viewSidebar();
    },

    sidebarToggle: function() {
        this.isSidebarShow = !this.isSidebarShow;
        this.viewSidebar();
    },

    viewSidebar: function() {

        if (this.isSidebarShow === true) {
            $("#shopSidebar").show();
            $("#loadBody").addClass("storeSidebarActiveContent");
            $("body").addClass("sidebarOpen");
            $("#toggleIcon").html('<i class="fa fa-times"></i>');
        } else {
            $("#shopSidebar").hide();
            $("#loadBody").removeClass("storeSidebarActiveContent");
            $("body").removeClass("sidebarOpen");
            $("#toggleIcon").html('<i class="fa fa-bars"></i>');
        }

    },

    isMobileDevice: function() {
        return window.matchMedia("(max-width: 767px)").matches;
    }



}


module.exports = { Menu };