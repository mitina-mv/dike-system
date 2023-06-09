/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue').default;

import Notifications from 'vue-notification'
Vue.use(Notifications)

import VueTabulator from 'vue-tabulator';
Vue.use(VueTabulator);

import VueFormulate from '@braid/vue-formulate'
Vue.use(VueFormulate)

import vmodal from 'vue-js-modal'
Vue.use(vmodal)

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

import QuestionList from './components/questions/QuestionList.vue'
Vue.component('question-list', QuestionList)

import QuestionForm from './components/questions/QuestionForm.vue'
Vue.component('question-form', QuestionForm)

import TableFilterDiscipline from './components/TableFilterDisciplines.vue'
Vue.component('table-filter-discipline', TableFilterDiscipline)

import TestForm from './components/tests/TestForm.vue'
Vue.component('test-form', TestForm)

import AssignmentTable from './components/assignment/Table.vue'
Vue.component('assignment-table', AssignmentTable)

import AssignmentForm from './components/assignment/Form.vue'
Vue.component('assignment-form', AssignmentForm)

import Testing from './components/Testing.vue'
Vue.component('testing', Testing)

import StudgroupForm from './components/studgroup/Form.vue'
Vue.component('studgroup-form', StudgroupForm)


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