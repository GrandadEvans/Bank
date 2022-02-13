import Echo from "laravel-echo";
import {default as User} from "./user";

window.Pusher = require('pusher-js');

window.Echo = new Echo({
    broadcaster: 'pusher',
    namespace: "Bank.Events",
    key: process.env.MIX_PUSHER_APP_KEY,
    cluster: process.env.MIX_PUSHER_APP_CLUSTER,
    forceTLS: true
});

let channel = `user.${User.id}`;

window.Echo.private(channel)
    .listen('PossibleRegularScanFinished', (e) => {

        window.app.$children[0].increaseCount();
    })
    .listen('ScanForRegulars', (e) => {
        console.info('scan begun');
    });
