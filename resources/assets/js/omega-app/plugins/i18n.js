import Vue from 'vue'
import VueI18n from 'vue-i18n'

import en from '../langs/en.json'
import fr from '../langs/fr.json'

Vue.use(VueI18n);

const i18n = new VueI18n({
  locale: 'en',
  messages: {
    en: en,
    fr: fr
  }
});

export default i18n
