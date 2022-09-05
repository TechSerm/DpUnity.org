const { Helper } = require("../helper");

let CacheStorage = {
    saveLocalStorage: true,
    storage: "",

    init: function(keys) {
        this.storage = this.saveLocalStorage ? localStorage : FilterArrayStorage;
        this.reload(keys);
    },

    setItem: function(key, value) {
        key = this.getHashKey(key);
        this.storage.setItem(key, value);
    },

    setItems: function(datas) {
        $.each(datas, function(key, value) {
            Helper.storage.setItem(key, value);
        });
    },

    getItem: function(key) {
        key = this.getHashKey(key);
        return this.storage.getItem(key);
    },

    removeItem: function(key) {
        console.log("call " + key)
        key = this.getHashKey(key);
        this.storage.removeItem(key);
    },

    removeItems: function(keys) {
        that = this;
        $.each(keys, function(index, keyName) {
            console.log(keyName);
            that.removeItem(keyName);
        });
    },

    /*
    - key base64 endcoded
    */
    getHashKey: function(key) {
        console.log(key);
        hashKey = window.location.href + "_hsh_" + key;
        return btoa(hashKey);
    },

    clear: function() {
        this.storage.clear();
    },

    /*
    - load storage key when load page
    */
    reload: function(keys) {
        console.log("ok");
        //when page is reload from another page then storage key not clear otherwise clear
        if (performance.navigation.type !== performance.navigation.TYPE_RELOAD) {
            this.removeItems(keys);
        }
    }
};

let FilterArrayStorage = {
    data: {},
    setItem: function(key, value) {
        this.data[key] = value;
    },
    getItem: function(key) {
        return this.data[key];
    },
    removeItem: function(key) {
        delete this.data[key];
    },
    clear: function(key) {
        this.data = {};
    }
}

module.exports = {
    CacheStorage
};