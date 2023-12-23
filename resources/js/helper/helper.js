const Helper = {
    toast: require('./lib/toast.js').Toast,
    url: require('./lib/url.js').Url,
    loader: require('./lib/loader.js').Loader,
    storage: require('./lib/cache_storage.js').CacheStorage,
    config: require('./lib/config.js').Config,
    modalStack: new (require('./lib/stack.js')).Stack(),
    button: function (button) {
        return new (require('./lib/button.js')).Button(button);
    },
    form: function (form, options) {
        return new (require('./lib/form.js')).Form(form, options);
    },
    div: function (div) {
        return new (require('./lib/div.js')).Div(div);
    },
    modal: function (type, title) {
        return new (require('./lib/modal.js')).Modal(type, title);
    },
    uri: function (url) {
        url = !url ? Helper.url.get() : url;
        return require('urijs')(url);
    },
    currentModal: function () {
        return this.modalStack.top();
    },
    formPrevent: function () {
        $('form').on('submit', function (e) {
            e.preventDefault();
        });
    },
    initBodyAction: function () {
        $('body').on('click', 'button[data-toggle="modal"]', function (e) {
            require('./lib/modal.js').ModalBuild.setUp($(this));
        });
        /*
         * Modal link action
         */
        $('body').on('click', 'a[data-toggle="modal"]', function (e) {
            require('./lib/modal.js').ModalBuild.setUpLink($(this));
        });
        /*
         * Delete button action
         */
        $('body').on('click', 'button[data-toggle="delete"]', function (e) {
            require('./lib/form_build.js').FormBuild.delete($(this));
        });
        /*
         * Confirm button action
         */
        $('body').on('click', 'button[data-toggle="confirm"]', function (e) {
            require('./lib/form_build.js').FormBuild.confirm($(this));
        });
        /*
         * Form submit action
         */
        $('body').on('submit', 'form', function (e) {
            //if form method is get then its not call submit function
            if ($(this).attr('method').toLowerCase() === "get") {

                return;
            }
            e.preventDefault();
            require('./lib/form_build.js').FormBuild.submit($(this));
        });
    }

}

require('./lib/ajax_load.js');
Helper.formPrevent();
Helper.initBodyAction();
module.exports = {
    Helper,
};