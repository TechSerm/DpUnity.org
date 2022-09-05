// start toast script
var Toast = {
    // toast: new(require('./toasty.js')).Toasty(this.options),
    success: function(msg) {
        this.createToast("success", msg)
    },
    error: function(msg) {
        this.createToast("error", msg)
    },
    info: function(msg) {
        this.createToast("info", msg)
    },
    warning: function(msg) {
        this.createToast("warning", msg)
    },
    sweetalert2: function() {
        let config = {
            toast: true,
            position: 'top-right',
            iconColor: 'white',
            customClass: {
                popup: 'colored-toast'
            },
            showConfirmButton: false,
            timer: 2000,
            timerProgressBar: true
        };
        return Swal.mixin(config);
    },
    createToast: function(toastType, toastMsg) {
        let toast = this.sweetalert2();
        toast.fire({
            icon: toastType,
            title: toastMsg
        });
    }
};
module.exports = {
    Toast
}