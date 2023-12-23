const Store = {
    home: require('./home.js').Home,
    auth: require('./auth.js').Auth,
    search: require('./search.js').Search,
    order: require('./order.js').Order,
    menu: require('./menu.js').Menu,
    instanceAlreadyLoad: false,
}

module.exports = {
    Store,
};