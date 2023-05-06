/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue').default;
import Notifications from 'vue-notification'
Vue.use(Notifications)

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))
// import { library } from '@fortawesome/fontawesome-svg-core'
// import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
// Vue.component('font-awesome-icon', FontAwesomeIcon);

Vue.component(
    'example-component', 
    require('./components/ExampleComponent.vue').default
);

import TeacherForm from './components/TeacherForm.vue';
Vue.component('teacher-form', TeacherForm);

import TableFilter from './components/TableFilter.vue';
Vue.component('table-filter', TableFilter);

import StudentForm from './components/StudentForm.vue';
Vue.component('student-form', StudentForm);

import Multiselect from 'vue-multiselect'
Vue.component('multiselect', Multiselect)

import StudentList from './components/StudentList.vue'
Vue.component('student-list', StudentList)

// Vue.component(
//     'student-form', 
//     require('./components/StudentForm.vue')
// );

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
});

import Alpine from 'alpinejs';
window.Alpine = Alpine;
Alpine.start();