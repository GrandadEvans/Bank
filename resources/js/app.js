require('./includes/bootstrap');
require('./vue/vueComponents');
require('./tagsPieChart');
require('./includes/user');
import {store} from './vue/vueComponents';
import {default as User} from './includes/user';

$(function () {
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
        store
    });

    window.app = app;

    window.Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer)
            toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
    })

    let chartArea = document.getElementById('curve_chart');
    if (chartArea) {
        require('./charts/yearsIncomeExpenditureChart');
    }

    let routeBadges = store.routeBadges;
    store.commit('updateRouteBadges', User.badges);
    // console.log(routeBadges);


    console.groupCollapsed('User Details');
    console.info('User', User);
    console.info('User Badges', User.badges);
    console.groupEnd();
});
