var App = {
    'name': $('meta[name="app-name"]').attr('content'),
    'token': $('meta[name="csrf-token"]').attr('content'),
    setToken: function(data) {
        data = !data ? {} : data;
        data['_token'] = this.token;
        return data;
    }
};

module.exports = {
    App
};