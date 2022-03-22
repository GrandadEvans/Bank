require('./broadcasting');
require('./font-awesome');

import Swal from "sweetalert2";

window._      = require('lodash');
window.axios  = require('axios');
window.moment = require('moment');
window.Swal   = window.swal = Swal;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
