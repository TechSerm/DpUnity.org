/**
 * Bootstrap modal (Support multiple)
 * Helper.modal("lg","Header").open();
 * open()   -> open modal
 * load()   -> load modal with url
 * html()   -> set html in modal body
 * close()  -> close modal
 */
const Modal = class {

    constructor(type, title) {
        if ($.isPlainObject(type)) {
            this.type = type.type;
            this.title = type.title;
        } else {
            this.type = type;
            this.title = title;
        }
        this.width = this.getSize();
        this.created = false;
    }

    getSize() {
        let modalSize = {};
        modalSize['sm'] = 350;
        modalSize['md'] = 600;
        modalSize['lg'] = 950;
        modalSize['xl'] = 1140;
        if (parseInt(modalSize[this.type])) return modalSize[this.type];
        return parseInt(this.type);
    }

    /*
    - create dynamic modal from structure
    */
    createModal() {
        let rnd = $.now();
        let id = `modal-${rnd}`;
        let body = `modal-body-${rnd}`;
        let headerTitle = `modal-header-title-${rnd}`;
        let header = `modal-header-${rnd}`;
        let bodyCloseBtn = `modal-body-btn-close-${rnd}`
        let modalStructure = $("#modal-structure").html().replace('##modal_id##', id).replace('##modal_header_title_id##', headerTitle).replace('##modal_header_id##', header).replace('##modal_body_btn_close_id##', bodyCloseBtn).replace('##modal_body_id##', body);
        $('#modal-area').append(modalStructure);
        $(`#${id} .modal-dialog`).css('max-width', this.width);
        /*
            set jquery instance
        */
        this.modal = $("#" + id);
        this.body = $("#" + body);
        this.headerTitle = $("#" + headerTitle);
        this.header = $("#" + header);
        this.bodyCloseBtn = $("#" + bodyCloseBtn);
        this.created = true;
        if (!this.title || this.title == "") {
            this.header.css('display', 'none');
            this.bodyCloseBtn.css('display', 'block');
        }

        this.headerTitle.html(this.title);
        Helper.modalStack.push(this);
    }
    open() {
        this.createModal();
        this.modal.modal("show");
    }
    load(url, callback) {
        if (!this.created) this.open();
        Helper.div(this.body).load({
            url: url,
            data: {}
        }, function(response) {
            if ($.isFunction(callback)) callback(response);
            Helper.formPrevent();
        });
    }

    loadOptions(options, callback) {
        if (!this.created) this.open();
        Helper.div(this.body).load(options, function(response) {
            if ($.isFunction(callback)) callback(response);
            Helper.formPrevent();
        });
    }

    html = (html) => this.body.html(html)

    close() {
        this.modal.modal("hide");
    }
}

const ModalBuild = {
    setUp: (btn) => {
        let modalUrl = btn.data('url');
        let modalHtml = btn.data('modal-html');
        let modal = Helper.modal(btn.data('modal-size'), btn.data('modal-title'));
        let options = {
            url: modalUrl,
        };
        let scrapeArea = btn.data('scrape-area');
        if (scrapeArea != null) options.scrapeArea = scrapeArea;
        if (modalUrl !== "") modal.loadOptions(options);
        else modal.open();
    },
    setUpLink: (link) => {
        let modalUrl = link.attr('href');
        let modal = Helper.modal(link.data('modal-size'), link.data('modal-header'));
        let options = {
            url: link.attr('href'),
        };

        let scrapeArea = link.data('scrape-area');
        if (scrapeArea != null) options.scrapeArea = scrapeArea;

        if (modalUrl !== "") modal.loadOptions(options);
        else modal.open();
    }
};


$(document).on('hide.bs.modal', '.modal', function(response) {
    setTimeout(function() {
        $('#modal-area').children().last().remove();
        Helper.modalStack.pop();
        if ($('.modal:visible').length) {
            setTimeout(function() {
                $('body').addClass('modal-open');
            }, 100);
        }
    }, 300);
});
$(document).on('show.bs.modal', '.modal', function(event) {
    var zIndex = 1040 + (10 * $('.modal:visible').length);
    $(this).css('z-index', zIndex);
    setTimeout(function() {
        $('.modal-backdrop').not('.modal-stack').css('z-index', zIndex - 1).addClass('modal-stack');
    }, 0);
});
module.exports = {
    Modal,
    ModalBuild
};