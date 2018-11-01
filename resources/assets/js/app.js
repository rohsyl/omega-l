import OmegaInstance from "./omega/app/omega";

/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */
// Bootstrap and jquery
require('./bootstrap');

// All assets needed by omega
require('toastr');
require('jquery-ui');
require('codemirror');
require('summernote');
require('sortablejs');
require('ace-builds');

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
