import Bugsnag from '@bugsnag/js';
import BugsnagPluginVue from '@bugsnag/plugin-vue';
require('./broadcasting');
require('./font-awesome');

import Swal from "sweetalert2";
import Vue from "vue";

window._      = require('lodash');
window.axios  = require('axios');
window.moment = require('moment');
window.Swal   = window.swal = Swal;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';


const apiKey = bugSnagKey();
if (typeof apiKey === 'string') {
    Bugsnag.start({
        apiKey: '5654e4b0844b36dc2e56d534571d8230',
        plugins: [new BugsnagPluginVue()]
    });

    // Import Bugsnag
    const bugsnagVue = Bugsnag.getPlugin('vue');
    bugsnagVue.installVueErrorHandler(Vue);
    window.Bugsnag = Bugsnag;
}
