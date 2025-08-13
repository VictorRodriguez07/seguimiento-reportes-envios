
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');
window.VeeValidate = require('vee-validate');
window.VueSwal = require('vue-swal');
window.flatPickr = require('vue-flatpickr-component');
window.vSelect = require('vue-select');
require('flatpickr/dist/flatpickr.css');
require('flatpickr/dist/l10n/es.js');


Vue.use(VeeValidate);
Vue.use(VueSwal);
Vue.use(flatPickr);
Vue.use(vSelect);
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */


Vue.component('libros', require('./components/libros/catalogo.vue').default);
Vue.component('listar', require('./components/libros/listar.vue').default);
Vue.component('listar-prestamos-libros', require('./components/prestamos_libros/listar.vue').default);
Vue.component('v-select', vSelect);


const app = new Vue({
    el: '#app',
    data: {
        usuarios:[],
        libros:[],
        prestamos:[],
    }
});
