
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');


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

Vue.component(
    'tracking-day', require('./components/TrackingDay.vue')
);

Vue.component(
    'tracking-days', require('./components/TrackingDays.vue')
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

// import progressColorRYG

import { progressRYG } from './modules/progressColor.js';

window.progressRYG = progressRYG;

Vue.component('vuejs-datepicker', Datepicker);

window.Form = Form;

window.EventBus = new Vue();

const app = new Vue({
    el: '#app'
});





