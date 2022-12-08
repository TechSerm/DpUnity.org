const Store = {
    home: require('./home.js').Home,
    search: require('./search.js').Search,
    order: require('./order.js').Order,
    menu: require('./menu.js').Menu,
}

module.exports = {
    Store,
};