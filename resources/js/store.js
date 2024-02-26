import _ from 'lodash';
window._ = _;



import 'bootstrap';
window.$ = window.jQuery = require('jquery')

// require('jquery-viewer');
// require('viewerjs/dist/viewer.css');
/**
var Turbolinks = require("turbolinks")
//Turbolinks.start()
 */
/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

import axios from 'axios';
window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

window.Helper = require('./helper/helper.js').Helper;
window.Store = require('./store/store.js').Store;