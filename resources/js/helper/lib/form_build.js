const { Helper } = require("../helper");

const FormBuild = {
    submit: function(form) {
        if (form.data('function') != null) {
            eval(form.data('function'));
            return;
        }
        let formSetting = {
            modalClose: form.data('modal-close'),
            resetForm: form.data('reset'),
            pageReload: form.data('page-reload'),
            pageRedirect: form.data('page-redirect'),
            pageDivLoad: form.data('div-load'),
        };
        let defaultFormSetting = {
            modalClose: true,
            resetForm: true,
            pageReload: true,
            pageRedirect: false,
            pageDivLoad: false
        };

        formSetting = $.extend({}, defaultFormSetting, formSetting);
        Helper.form(form).submit({
            success: {
                resetForm: formSetting.resetForm,
                callback: function(response) {
                    if (formSetting.modalClose == true) {
                        let currModal = Helper.currentModal();
                        if (currModal != null) currModal.close();
                    }
                    if (formSetting.pageRedirect == true) Helper.url.load(response.url);
                    else if (formSetting.pageReload == true) Helper.url.reload();
                    else if (formSetting.pageDivLoad == true) Helper.url.load();

                }
            }
        });
    },
    delete: function(btn) {
        Swal.fire({
            title: 'Are you sure?',
            text: "You want be delete this record!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete it!',
            showLoaderOnConfirm: true,
            preConfirm: function() {
                return new Promise(function(resolve) {
                    $.ajax({
                        url: btn.data('url'),
                        data: Helper.config.setToken(),
                        type: 'delete',
                        success: (response) => {
                            Helper.url.load(response.url !== null ? response.url : null);
                            let msg = response.message !== null ? response.message : "Successfully delete this record.";
                            Swal.fire({
                                title: 'Deleted!',
                                text: msg,
                                icon: 'success',
                            });
                            if (btn.data('callback')) eval(btn.data('callback'));
                        }
                    }).fail(function(error) {
                        Swal.fire({
                            title: "Oops!!!",
                            text: error.status + " - " + error.statusText,
                            icon: 'error',
                        });
                    });
                });
            },
            allowOutsideClick: () => !Swal.isLoading()
        });
    },
    confirm: function(btn) {
        let title = btn.data('title') ? btn.data('title') : "Are you sure?";
        let subTitle = btn.data('subtitle') ? btn.data('subtitle') : "You want be confirm this request!";
        let btnText = btn.data('button-text') ? btn.data('button-text') : "Yes, confirm it!";
        let cancelBtnText = btn.data('cancel-button-text') ? btn.data('cancel-button-text') : "Close";

        Swal.fire({
            title: title,
            text: subTitle,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#27ae60',
            cancelButtonColor: '#d33',
            confirmButtonText: btnText,
            cancelButtonText: cancelBtnText,
            showLoaderOnConfirm: true,
            preConfirm: function() {
                return new Promise(function(resolve) {
                    $.ajax({
                        url: btn.data('url'),
                        data: Helper.config.setToken(),
                        type: 'post',
                        success: (response) => {
                            window.location.reload();
                            Swal.fire({
                                title: 'Success!',
                                text: response.message,
                                icon: 'success',
                            });
                        }
                    }).fail(function(error) {
                        let errorMessage = error.responseJSON && error.responseJSON.message ? error.responseJSON.message : error.status + " - " + error.statusText;
                        Swal.fire({
                            title: "Oops!!!",
                            text: errorMessage,
                            icon: 'error',
                        });
                    });
                });
            },
            allowOutsideClick: () => !Swal.isLoading()
        });
    }
};

module.exports = {
    FormBuild
};