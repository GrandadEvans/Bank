import Vue from 'vue';

import Vuex from 'vuex';
import {storeConfig} from "./vuex.store";
import VueSweetalert2 from 'vue-sweetalert2';

Vue.use(Vuex);

export const store = new Vuex.Store(storeConfig);

Vue.use(VueSweetalert2);

window.Vue = Vue;
// https://webpack.js.org/guides/dependency-management/#require-context
const requireComponent = require.context(
    './components/', // Look for files in the current directory
    true, // include subdirectories
    // Only include "_base-" prefixed .vue files
    //   /_base-[\w-]+\.vue$/
    //   /[\w-]+\.vue$/
    /\.vue$/
);

// For each matching file name...
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
