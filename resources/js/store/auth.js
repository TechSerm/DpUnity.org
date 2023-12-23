const { Helper } = require("../helper/helper");

const Auth = {
    
    login: function(e) {
        let form = Helper.form(e);

        form.submit({
            success: {
                resetForm: true,
                callback: function(response) {
                    $("#loadBody").append($("#pageLoader").html());
                    Helper.url.load("/profile", function(){}, "loadBody");
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