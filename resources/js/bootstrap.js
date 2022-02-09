window._ = require('lodash');
window.$ = window.jQuery = require('jquery');
window.daterangepicker = require('daterangepicker');

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
import Echo from 'laravel-echo';
import Swal from "sweetalert2";

window.Pusher = require('pusher-js');
require('./vueComponents');
require('bootstrap');
window.Echo = new Echo({
    broadcaster: 'pusher',
    key: process.env.MIX_PUSHER_APP_KEY,
    cluster: process.env.MIX_PUSHER_APP_CLUSTER,
    forceTLS: true // @todo: Switch this to true when switching SSL
});
// window.currency   = require('currency.js');
window.moment = require('moment');

window.Swal = window.swal = Swal;
/**
 * Set the currency field format
 *
 * @param value
 * @returns {currency | never}
 * @constructor
 */
window.GBP = value => {
    return currency(value, {
        precision: 2,
        symbol: '£',
        formatWithSymbol: true,
        separator: ',',
        decimal: '.',
        pattern: `!   #`,
        negativePattern: `! - #`
    }).format();
}

// Echo.private(`users.${userId}`)
window.Echo.private(`users.1`)
    .listen('ScanForRegulars', (e) => {
        alert('here')
        // console.dir(e);
    });
// Echo.private(`users.${userId}`)
window.Echo.channel(`users.1`)
    .listen('ScanForRegulars', (e) => {
        alert('here')
        // console.dir(e);
    });


