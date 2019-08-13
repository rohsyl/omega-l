import Vue from 'vue'
import App from './components/App'
import i18n from '../../plugins/i18n'

Vue.config.productionTip = false;

new Vue({
    i18n,
    ...App
});