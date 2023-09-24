/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

import store from './store';
import Carousel from 'vue-carousel';


window.Vue = require('vue').default;

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.use(Carousel);


Vue.component('navigation', require('./components/Navigation.vue').default);
Vue.component('book-filter', require('./components/BookFilter.vue').default);
Vue.component('book-list', require('./components/BookList.vue').default);
Vue.component('sign-up', require('./components/SignUp.vue').default);
Vue.component('log-in', require('./components/LogIn.vue').default);
Vue.component('donation', require('./components/DonationForm.vue').default);
Vue.component('books', require('./components/Books.vue').default);
Vue.component('profile', require('./components/Profile.vue').default);
Vue.component('profile-navigation', require('./components/ProfileNavigation.vue').default);
Vue.component('my-profile', require('./components/MyProfile.vue').default);
Vue.component('book-details', require('./components/BookDetails.vue').default);
Vue.component('book-carousel', require('./components/BookCarousel.vue').default);
Vue.component('book-page', require('./components/BookPage.vue').default);
Vue.component('review', require('./components/Review.vue').default);
Vue.component('main-page', require('./components/MainPage.vue').default);
Vue.component('reset-password', require('./components/ResetPassword.vue').default);
Vue.component('my-favorites', require('./components/MyFavorites.vue').default);
Vue.component('contact-form', require('./components/ContactForm.vue').default);
Vue.component('cos', require('./components/Cos.vue').default);
Vue.component('my-orders', require('./components/MyOrders.vue').default);
Vue.component('my-products', require('./components/MyProducts.vue').default);

// Admin components
Vue.component('admin-user-table', require('./components/admin/UserTable.vue').default);
Vue.component('admin-carte-table', require('./components/admin/CarteTable.vue').default);
Vue.component('admin-categorie-table', require('./components/admin/CategorieTable.vue').default);
Vue.component('admin-comanda-table', require('./components/admin/ComandaTable.vue').default);
Vue.component('admin-donatie-table', require('./components/admin/DonatieTable.vue').default);
Vue.component('admin-review-table', require('./components/admin/ReviewTable.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
    store,
});
