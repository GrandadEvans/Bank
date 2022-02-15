import Swal from "sweetalert2";

window._ = require('lodash');
window.$ = window.jQuery = require('jquery');
// window.daterangepicker = require('daterangepicker');

/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */
window.axios = require('axios');
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */
require('./font-awesome');
require('./broadcasting');

// window.currency   = require('currency.js');
window.moment = require('moment');

window.Swal = window.swal = Swal;

