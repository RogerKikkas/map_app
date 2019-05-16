/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

import 'es6-promise/auto';
import axios from 'axios';
import auth from './auth';
import router from './router';
import Vue from 'vue';
import VueAuth from '@websanova/vue-auth';
import VueAxios from 'vue-axios';
import VueRouter from 'vue-router';
import VueClipboard from 'vue-clipboard2';
import { Chrome } from 'vue-color'
import { LMap, LTileLayer, LMarker, LPolyline, LPopup, LCircleMarker, LTooltip } from 'vue2-leaflet';
import { Icon } from 'leaflet';
import 'leaflet/dist/leaflet.css';

// This shows up on API token modal to show the user the API endpoint
export const websiteURL = 'https://loc.kvlt.ee';

// Set Vue
window.Vue = Vue;

// Vue Router
Vue.router = router;
Vue.use(VueRouter);

// Axios & Authentication
Vue.use(VueAxios, axios);
// If api url is different from app url
Vue.axios.defaults.baseURL = '/api';
Vue.use(VueAuth, auth);

Vue.use(VueClipboard);
/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 */

// const files = require.context('./', true, /\.vue$/i);
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default));

Vue.component('l-map', LMap);
Vue.component('l-tile-layer', LTileLayer);
Vue.component('l-circle-marker', LCircleMarker);
Vue.component('l-marker', LMarker);
Vue.component('l-polyline', LPolyline);
Vue.component('l-popup', LPopup);
Vue.component('l-tooltip', LTooltip);
Vue.component('leaf-map', require('./components/Map.vue').default);
Vue.component('user-map', require('./components/UserMap.vue').default);
Vue.component('app', require('./components/App.vue').default);
Vue.component('navbar', require('./components/Navbar.vue').default);
Vue.component('user-profile', require('./components/UserProfile.vue').default);
Vue.component('admin', require('./components/Admin.vue').default);
Vue.component('chrome-picker', Chrome);
Vue.component('api-modal', require('./components/APIModal.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

// Leaflet marker default icons
delete Icon.Default.prototype._getIconUrl;

Icon.Default.mergeOptions({
    iconRetinaUrl: 'images/vendor/leaflet/dist/marker-icon-2x.png',
    iconUrl: 'images/vendor/leaflet/dist/marker-icon.png',
    shadowUrl: 'images/vendor/leaflet/dist/marker-shadow.png'
});

const app = new Vue({
    el: '#app',
    router
});
