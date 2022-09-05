const Button = class {
    constructor(button) {
        this.button = (button instanceof jQuery) ? button : $("#" + button);
        this.iniHtml = this.button.html();
    }
    on() {
            this.button.prop("disabled", false);
            return this;
        }
        //just button off
    off() {
            this.button.prop("disabled", true);
            return this;
        }
        /*  
        - just button loading
        - Button.loading();
        - <button loading-after-text="top" loading-icon='' loading-text="Saving...">Btn</button>
        */
    loading() {
            let txt = this.button.attr('loading-text') != null ? this.button.attr('loading-text') : this.button.html();
            let icon = this.button.attr('loading-icon') != null ? this.button.attr('loading-icon') : "<i class='fas fa-sync-alt fa-spin'></i>";
            this.html(icon + " " + txt);
            return this;
        }
        /*  
        - end loading
        - Button.endLoading();
        - <button loading-after-text="top">Btn</button>
        */
    endLoading() {
            let txt = this.button.attr('loading-after-text') != null ? this.button.attr('loading-after-text') : this.iniHtml;
            this.button.html(txt);
            return this;
        }
        //change button html
    html(txt) {
        this.button.html(txt);
        return this;
    }

}
module.exports = {
    Button
};