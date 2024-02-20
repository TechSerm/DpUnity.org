const { Helper } = require("../helper/helper");

const Auth = {
    
    login: function(e) {
        let form = Helper.form(e);
        
        form.submit({
            success: {
                resetForm: false,
                callback: function(response) {
                    window.location.href = "/admin";
                }
            }
        })
    },

    logout: function(e) {
        let form = Helper.form(e);
        $("#loadBody").append($("#pageLoader").html());
        form.submit({
            success: {
                resetForm: true,
                callback: function(response) {
                    Helper.url.load("/", function(){}, "loadBody");
                }
            }
        })
    },
    
}


module.exports = { Auth };