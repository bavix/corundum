
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

Vue.component('bucket-menu', require('./components/BucketMenu.vue'));
Vue.component('bucket-form', require('./components/BucketForm.vue'));
Vue.component('view-menu', require('./components/ViewMenu.vue'));
Vue.component('view-form', require('./components/ViewForm.vue'));

const app = new Vue({
    el: '#app',
    data: {
        buckets: [],
        views: [],
    },
});

window.vm = app;
