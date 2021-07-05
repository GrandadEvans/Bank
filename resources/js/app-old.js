
// Datatables library as I can't import it with autoload
window.datatables = require('datatables.net');

// Currency library as I can't import this with the autoload feature in webpack.mix.js
window.currency = require('currency.js');

window.Vue = require('vue');
Vue.component('transaction-list', require('./components/Transaction-tableComponent').default);
Vue.component('tag', require('./components/TagComponent').default);
// Vue.component('transaction',      require('./components/TransactionComponent'     ).default);

window.Swal = swal = require('sweetalert2');

require('bootstrap');

// Set the table at a high scope
let table;

$(document).ready(function () {
    let token = document.head.querySelector('meta[name="csrf-token"]');
    if (token) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    } else {
        console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
    }

    let app = new Vue({
        el: '#app',
    });

    var options = {
        chart: {
            height: 350,
            type: 'bar',
        },
        dataLabels: {
            enabled: false
        },
        series: [],
        title: {
            text: 'Ajax Example',
        },
        noData: {
            text: 'Loading...'
        }
    }

    var chart = new ApexCharts(
        document.querySelector("#sidebar_piechart"),
        options
    );

    chart.render();

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

});
