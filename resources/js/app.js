/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

// Add vue router
import VueRouter from 'vue-router';
window.Vue.use(VueRouter);

/**
 * Define component
 */
import EmailIndex from './components/email/Index.vue';
import EmailCreate from './components/email/Create.vue';

/**
 * Define routes
 */
const routes = [
    {
        path: '/',
        components: {
            EmailIndex: EmailIndex
        }
    },

    {
        path: '/create',
        component: EmailCreate,
        name: 'EmailCreate'
    },
]

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i);
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default));

Vue.component('email-index', require('./components/email/Index.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const router = new VueRouter({ routes })

const app = new Vue({
    el: '#app',
    router
});
