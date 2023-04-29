import '@/bootstrap';

import { createApp } from 'vue';
import App from '@/App.vue';
import router from '@/router';
import store from '@/store';

import helpers from '@/helpers';
import API from '@/services/api';

const myHelpers = {
  install(app, options) {
    app.helpers = helpers;
    app.config.globalProperties.$helpers = helpers;
  },
};

const myAPI = {
  install(app, options) {
    app.api = API;
    app.config.globalProperties.$api = API;
  },
};

const app = createApp(App).use(router).use(store).use(myHelpers).use(myAPI);

app.mount('#app');
