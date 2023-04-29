import { createStore } from 'vuex';
import Popups from './modules/popups';
import Auth from './modules/auth';
import Components from './modules/components';

const store = createStore({
  modules: {
    popups: Popups,
    auth: Auth,
    components: Components,
  },
  state() {
    return {};
  },
  getters: {},
  mutations: {},
});

export default store;
