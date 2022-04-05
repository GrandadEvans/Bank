require('./includes/bootstrap');
require('./vue/vueComponents');
import {store} from './vue/vueComponents';
import User from './includes/User';
let token = document.head.querySelector('meta[name="csrf-token"]');
window.token = token;

window.onload = function () {
    let userdata = new User();
    store.commit('updateUser', userdata);
    store.commit('updateCsrfToken', token);
    let app = new Vue({
        el: '#app',
        store,
        data: {}
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
}
