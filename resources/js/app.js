/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

import Vue from 'vue';
import { router } from './components/router';
import App from './components/App';

// Vue.component('auth-component', require('./components/pages/components/AuthComponent.vue').default)


const app = new Vue({
    el: '#app',
    router: router,
    components: {
        App
    },
});
