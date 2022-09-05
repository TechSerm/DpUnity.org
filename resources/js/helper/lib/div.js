function Div(div) {
    this.div = (div instanceof jQuery) ? div : $("#" + div);
    /*
     * Get html inside id
     */
    this.getScrapeArea = (html, id) => {
        var doc = new DOMParser().parseFromString(html, "text/html").getElementById(id);
        var html = doc != null ? doc.innerHTML : "";
        return html;
    }
    /*
     * load div with url
     */
    this.load = (data, callback) => {
        this.setUpData(data);
        let _this = this;
        $.get(this.url, this.data, function(response) {
            _this.successLoad(response, callback);
        }).fail(function(error) {
            _this.errorLoad(error);
        });
    }
    /*
     * Set up data
     * paramter => 
     * url, loader, changeUrl (true, false), data(object), scrapeArea
     */
    this.setUpData = (data) => {
        if ($.isPlainObject(data)) {
            this.url = data.url;
            this.loader = data.loader;
            this.changeUrl = data.changeUrl;
            this.data = data.data;
            this.scrapeArea = data.scrapeArea;
        }
        this.url = !this.url ? "" : this.url;
        this.loader = !this.loader ? "div" : this.loader;
        this.changeUrl = !this.changeUrl ? false : this.changeUrl;
        this.data = $.isPlainObject(this.data) ? this.data : {};
        /*
         * set loader
         */
        if (this.loader == "div") Helper.loader.div(this.div);
        else Helper.loader.top.start();
        /*
         * change url with pass scrape area
         */
        if (this.changeUrl) Helper.url.change("", "", this.url);
    }
    this.successLoad = (response, callback) => {
        if (this.changeUrl) document.title = $(response).filter('title').text();
        /*
         * Get html from response
         */
        let html = this.scrapeArea != null ? this.getScrapeArea(response, this.scrapeArea) : response;
        this.div.html(html);
        /*
         * Callback function call
         */
        if ($.isFunction(callback)) callback(response);
        Helper.loader.top.stop()
    }
    this.errorLoad = (error) => {
        if (error.status == 500) {
            let ok = confirm("Error Found!!!\nAre you want go to error page?");
            if (!ok) return;
            location.href = this.url;
        } else {
            /*
            - set default html page if not scrap area then set default html page
            */
            let defaultHtml = `<div class="page-error"><h1>${error.status}</h1><h2>${error.statusText}</h2></div>`;
            let html = this.scrapeArea != null ? this.getScrapeArea(error.responseText, this.scrapeArea) : defaultHtml;
            /*
            - if script area is given but html is not found in this area then set default html
            */
            ;
            html = html == "" ? defaultHtml : html;
            this.div.html(html);
            if (this.changeUrl) document.title = $(error.responseText).filter('title').text();
            Helper.toast.error(error.status + " " + error.statusText);
        }
        Helper.loader.top.stop()
    }
}
module.exports = {
    Div
};