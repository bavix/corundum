
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

Vue.component('bucket-menu', require('./components/BucketMenuComponent.vue'));
Vue.component('view-menu', require('./components/ViewMenuComponent.vue'));
Vue.component('view-form', require('./components/ViewFormComponent.vue'));

const app = new Vue({
    el: '#app',
    data: {
        buckets: [
            {id: 1, name: 'wheels'},
            {id: 2, name: 'brands'},
            {id: 3, name: 'users'},
        ]
    },
});

window.vm = app;
