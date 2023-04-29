export default {
  namespaced: true,
  state() {
    return {
      components: [],
      page: 1,
      nextPage: null,
      searchParams: null,
    };
  },
};
