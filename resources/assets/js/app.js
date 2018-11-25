import OmegaInstance from "./omega/app/omega";

/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */


window._ = require('lodash');
window.Popper = require('popper.js').default;

// Bootstrap and jquery
window.$ = window.jQuery = require('jquery');
require('bootstrap3');


/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

window.axios = require('axios');

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

/**
 * Next we will register the CSRF Token as a common header with Axios so that
 * all outgoing HTTP requests automatically have it attached. This is just
 * a simple convenience so we don't have to attach every token manually.
 */

let token = document.head.querySelector('meta[name="csrf-token"]');

if (token) {
    window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
} else {
    console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
}

// All assets needed by omega
require('toastr');
require('jquery-ui');
require('codemirror');
require('summernote');
require('sortablejs');
require('ace-builds');
require('codemirror');
require('codemirror/mode/htmlembedded/htmlembedded');

import CodeMirror from 'codemirror';
window.CodeMirror = CodeMirror;

// make toastr gobally available
import toastr from 'toastr';
window.toastr = toastr;

// make Sortable gobally available
import Sortable from 'sortablejs';
window.Sortable = Sortable;


require('./assets/metisMenu.min');
require('./assets/sb-admin-2.min');
require('./assets/jquery.nestable');
require('./omega/custom.nestable');
require('../external/bootstrap3-datepicker/js/bootstrap-datepicker.min');
require('../external/bootstrap-iconpicker/js/bootstrap-iconpicker.min');
require('./assets/word_entity_scrubber');
require('./omega/omega.admin');
require('./omega/jquery.rsExplorer');
require('./omega/jquery.rsMediaChooser');
require('./omega/jquery.rsModuleChooser');
window.omega = require('./omega/app/omega');




// No need of vue.js
// But i keep it here if in the futur i want to use it
//window.Vue = require('vue');
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
//Vue.component('example-component', require('./components/ExampleComponent.vue'));
//const app = new Vue({
//    el: '#app'
//});
