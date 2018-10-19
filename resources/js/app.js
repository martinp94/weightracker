
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

import VueRouter from 'vue-router';

Vue.use(VueRouter);

// Define some routes
// Each route should map to a component. The "component" can
// either be an actual component constructor created via
// `Vue.extend()`, or just a component options object.
// We'll talk about nested routes later.

const routes = [
    { path: 'new-tracking-period', component: require('./components/NewTrackingPeriod.vue') }
]

// Create the router instance and pass the `routes` option
// You can pass in additional options here, but let's
// keep it simple for now.
const router = new VueRouter({
    routes // short for `routes: routes`
})
  

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component(
    'new-tracking-period', require('./components/NewTrackingPeriod.vue')
);

Vue.component(
    'tracking-stats', require('./components/Stats.vue')
);

// Import vform

import { Form, HasError, AlertError } from 'vform';

Vue.component(HasError.name, HasError);
Vue.component(AlertError.name, AlertError);

// Import vuejs-datepicker

import Datepicker from 'vuejs-datepicker';

// Import sweetalert2

import swal from 'sweetalert2';

window.sweetalert = swal;

Vue.component('vuejs-datepicker', Datepicker);

window.Form = Form;

window.EventBus = new Vue();

const app = new Vue({
    el: '#app',
    router
});





