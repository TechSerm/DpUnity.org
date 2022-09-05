var Url = {
    get: function() {
        return this.build(window.location.href);
    },
    build: function(url) {
        return (url.substr(url.length - 1) == "/") ? url.slice(0, -1) : url;
    },
    getWithoutParameter: function() {
        var newUrl = location.host + location.pathname;
        return (newUrl.substr(newUrl.length - 1) == "/") ? newUrl.slice(0, -1) : newUrl;
    },
    change: function(state, title, url) {
        if(!url) return;
        if (this.get() != url) history.pushState(state, title, url);
    },
    reload: () => {
        location.reload();
    },
    load: function(url, callback) {
        Helper.div("app-body").load({
            url: url,
            loader: "top",
            changeUrl: true,
            scrapeArea: 'app-body'
        }, function(response) {
            document.title = $(response).filter('title').text();
            if ($.isFunction(callback)) callback(response);
        });
    },
    checkValidUrl: function(url) {
        var pattern = new RegExp('^(https?:\\/\\/)?' + // protocol
            '((([a-z\\d]([a-z\\d-]*[a-z\\d])*)\\.)+[a-z]{2,}|' + // domain name
            '((\\d{1,3}\\.){3}\\d{1,3}))' + // OR ip (v4) address
            '(\\:\\d+)?(\\/[-a-z\\d%_.~+]*)*' + // port and path
            '(\\?[;&a-z\\d%_.~+=-]*)?' + // query string
            '(\\#[-a-z\\d_]*)?$', 'i'); // fragment locator
        return !!pattern.test(url);
    }
};


module.exports = { Url };
