import Vue from 'vue';
import Vuex from 'vuex';
import {storeConfig} from "./vuex.store";
import VueSweetalert2 from 'vue-sweetalert2';
// import {default as User} from '../includes/user';
import Bugsnag from '@bugsnag/js';
import BugsnagPluginVue from '@bugsnag/plugin-vue';

Bugsnag.start({
    apiKey: '5654e4b0844b36dc2e56d534571d8230',
    plugins: [new BugsnagPluginVue()]
});

// Import Bugsnag
const bugsnagVue = Bugsnag.getPlugin('vue');
bugsnagVue.installVueErrorHandler(Vue);
Vue.use(Vuex);

export const store = new Vuex.Store(storeConfig);

Vue.use(VueSweetalert2);

window.Vue = Vue;
window.Bugsnag = Bugsnag;

// https://webpack.js.org/guides/dependency-management/#require-context
const requireComponent = require.context('./components/', true, /* include subdirectories*/ /\.vue$/);
requireComponent.keys().forEach(fileName => {
    // Get the component config
    const componentConfig = requireComponent(fileName);
    const componentName =
        fileName
            .replace(/^.*[\\/]/, '')  // Remove path
            .replace(/\.\w+$/, '');    // Remove extension

    // Globally register the component
    Vue.component(componentName, componentConfig.default || componentConfig);
});
// import BankTheNavbar from './components/bank-the-navbar';

// Vue.component('bank-the-navbar', BankTheNavbar);
