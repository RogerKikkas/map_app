
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

import Vue from 'vue';
import { LMap, LTileLayer, LMarker, LPolyline, LPopup, LCircleMarker, LTooltip } from 'vue2-leaflet';
import { Icon } from 'leaflet'
import 'leaflet/dist/leaflet.css'

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
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

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

delete Icon.Default.prototype._getIconUrl;

Icon.Default.mergeOptions({
    iconRetinaUrl: 'images/vendor/leaflet/dist/marker-icon-2x.png',
    iconUrl: 'images/vendor/leaflet/dist/marker-icon.png',
    shadowUrl: 'images/vendor/leaflet/dist/marker-shadow.png'
});

const app = new Vue({
    el: '#app'
});
