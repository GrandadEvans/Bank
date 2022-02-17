import Vue from 'vue';
import Vuex from 'vuex';
import {storeConfig} from "./vuex.store";
import VueSweetalert2 from 'vue-sweetalert2';
// import {default as User} from '../includes/user';

Vue.use(Vuex);

export const store = new Vuex.Store(storeConfig);

Vue.use(VueSweetalert2);

window.Vue = Vue;

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
