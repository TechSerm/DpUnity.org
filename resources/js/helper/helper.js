const Helper = {
    toast: require('./lib/toast.js').Toast,
    url: require('./lib/url.js').Url,
    loader: require('./lib/loader.js').Loader,
    storage: require('./lib/cache_storage.js').CacheStorage,
    config: require('./lib/config.js').Config,
    modalStack: new(require('./lib/stack.js')).Stack(),
    button: function(button) {
        return new(require('./lib/button.js')).Button(button);
    },
    form: function(form, options) {
        return new(require('./lib/form.js')).Form(form, options);
    },
    div: function(div) {
        return new(require('./lib/div.js')).Div(div);
    },
    modal: function(type, title) {
        return new(require('./lib/modal.js')).Modal(type, title);
    },
    uri: function(url) {
        url = !url ? Helper.url.get() : url;
        return require('urijs')(url);
    },
    currentModal: function() {
        return this.modalStack.top();
    },
    formPrevent: function() {
        $('form').on('submit', function(e) {
            e.preventDefault();
        });
    }

}
require('./lib/ajax_load.js');
Helper.formPrevent();
module.exports = {
    Helper,
};