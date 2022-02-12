import Echo from "laravel-echo";

window.Pusher = require('pusher-js');

window.Echo = new Echo({
    broadcaster: 'pusher',
    namespace: "Bank.Events",
    key: process.env.MIX_PUSHER_APP_KEY,
    cluster: process.env.MIX_PUSHER_APP_CLUSTER,
    forceTLS: true
});

let user = JSON.parse(document.querySelector("meta[name='user']").getAttribute('content'));
let channel = `user.${user.id}`;
window.Echo.private(channel)
    .listen('PossibleRegularScanFinished', (e) => {
        window.app.$children[0].increaseCount();
    })
    .listen('ScanForRegulars', (e) => {
        console.info('scan begun');
    });
