import Vue from 'vue';

import Vuex from 'vuex';
Vue.use(Vuex);

import {storeConfig} from "./vuex.store";
export const store = new Vuex.Store(storeConfig);

import VueSweetalert2 from 'vue-sweetalert2';
Vue.use(VueSweetalert2);

window.Vue = Vue;
Vue.component('transaction-table', require('./components/Transaction-tableComponent').default);
Vue.component('transaction-table-header', require('./components/Transaction-table-headerComponent').default);
Vue.component('transaction-table-body', require('./components/Transaction-table-bodyComponent').default);
Vue.component('transaction-table-footer', require('./components/Transaction-table-footerComponent').default);
Vue.component('transaction-table-row', require('./components/Transaction-table-rowComponent').default);
Vue.component('tags-list', require('./components/TaglistComponent').default);
Vue.component('tag', require('./components/TagComponent').default);
Vue.component('td-amount', require('./components/Td-amountComponent').default);
Vue.component('td-date', require('./components/Td-dateComponent').default);
Vue.component('td-provider', require('./components/Td-providerComponent').default);
Vue.component('provider-select', require('./components/provider-selectComponent').default);
Vue.component('td-payment-method', require('./components/Td-payment-methodComponent').default);
Vue.component('pagination-links', require('./components/Pagination-linksComponent').default);
Vue.component('search', require('./components/SearchComponent').default);
Vue.component('add-tag-modal', require('./components/ModalComponents/Add-tag-modalComponent').default);
Vue.component('add-provider-modal', require('./components/ModalComponents/Add-provider-modalComponent').default);
Vue.component('add-similar-transactions-modal', require('./components/ModalComponents/Add-similar-transactions-modalComponent').default);
Vue.component('add-remarks-modal', require('./components/ModalComponents/Add-remarks-modalComponent').default);
Vue.component('modal', require('./components/ModalComponents/ModalComponent').default);

