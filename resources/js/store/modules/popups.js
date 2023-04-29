export default {
  namespaced: true,
  state() {
    return {
      login: false,
      register: false,
      forgotPassword: false,
      resetPassword: false,
    };
  },

  getters: {
    isAnyPopupOpen(state) {
      return !Object.values(state).every((value) => value === false);
    },
  },

  mutations: {
    closeAllPopups(state) {
      state.login = false;
      state.register = false;
      state.forgotPassword = false;
      state.resetPassword = false;
    },
  },

  actions: {
    closeAllPopups({ commit }) {
      commit('closeAllPopups');
    },
  },
};
