/**
 * new Form("#test").submit({success:}) 
 */
const Form = class {

    constructor(form, options) {
        this.form = (form instanceof jQuery) ? form : $("#" + form);
        this.options = options == null ? {} : options;
        this.btn = this.getSubmitBtn();
        this.formData = new FormData(form[0]);
    }

    getSubmitBtn() {
        let btn = this.form.find("button[type=submit]");
        if (!btn.length) btn = this.form.find("input[type=submit]");
        return Helper.button(btn);
    }
    append(key, value) {
        this.formData.append(key, value);
    }
    submit(options) {
        options = options == null ? {} : options;
        this.btn.off().loading();
        let _this = this;
        $.ajax({
            url: this.form.attr('action'),
            data: this.formData,
            processData: false,
            contentType: false,
            type: this.form.attr('method') == null ? "POST" : this.form.attr('method'),
            success: function(response) {
                _this.resetErrors();
                if (response.message != null) {
                    _this.successAlert(response.message);
                    Helper.toast.success(response.message);
                }
                options.success = options.success == null ? {} : options.success;

                if ($.isFunction(options.success.callback)) {
                    options.success.callback(response);
                }

                //clear form
                if (options.success.resetForm == true) _this.form.trigger("reset");
                //call callback function
                if ($.isFunction(options.success.callback)) options.success.callback(response);
                _this.btn.on().endLoading();
            }
        }).fail(function(Error) {
            _this.resetErrors();
            let error = JSON.parse(Error.responseText);
            _this.errorAlert(error['message']);
            Helper.toast.error(error['message']);
            errorMsg = "";
            resp = error['errors'];
            $.each(resp, function(fieldName, error) {
                let msg = `
                <span class="invalid-feedback" for="${fieldName}">
                    <strong>${error}</strong>
                </span>
                `;
                fieldName = _this.dotArrayToJs(fieldName)
                console.log(fieldName, error);
                let inputPos = _this.form.find('input[name="' + fieldName + '"], select[name="' + fieldName + '"], textarea[name="' + fieldName + '"]');
                inputPos.parent().append(msg);
                inputPos.addClass('is-invalid');
                inputPos.parent().parent().addClass('has-error');

                /*
                * for multi checkbox or input field
                * <div>
                    <input name="t[]">val2
                    <input name="t[]">val1
                  <div>
                */
                let inputMulPos = _this.form.find('input[name="' + fieldName + '[]"]');
                inputMulPos.parent().parent().append(msg);
            });
            _this.btn.on().endLoading();
        });
    }
    dotArrayToJs = (str) => {
        var splittedStr = str.split('.');

        return splittedStr.length == 1 ? str : (splittedStr[0] + '[' + splittedStr.splice(1).join('][') + ']');
    }
    resetErrors = () => {
        this.form.find('input, select, textarea').removeClass('is-invalid');
        this.form.find('span.invalid-feedback').remove();
        this.form.find('div.alert-danger').addClass('d-none');
        this.form.find('div.alert-success').addClass('d-none');
    }
    successAlert(msg) {
        if (!this.form.find('div.alert-success').length) this.form.prepend('<div class="alert alert-success d-none"></div>');
        let area = this.form.find('div.alert-success');
        area.removeClass('d-none');
        area.html('<i class="fas fa-check"></i> ' + msg);
    }
    errorAlert(msg) {
        if (!this.form.find('div.alert-danger').length) this.form.prepend('<div class="alert alert-danger d-none"></div>');
        let area = this.form.find('div.alert-danger');
        area.removeClass('d-none');
        area.html('<i class="fa fa-exclamation-triangle"></i> ' + msg)
    }
}

module.exports = {
    Form
};