<template>
  <div
    class="w-full h-20 flex flex-col md:flex-row md:space-y-0 space-y-2 items-center md:space-x-4 mb-4 md:mb-0"
  >
    <router-link to="/" class="font-bold text-3xl md:grow md:mt-0 mt-4">
      mycomponents
    </router-link>

    <div class="flex space-x-4" v-if="!$store.state.auth.token">
      <Button
        type="btn-text"
        :onClick="
          () => {
            $store.state.popups.register = true;
          }
        "
      >
        Register
      </Button>
      <Button
        :onClick="
          () => {
            $store.state.popups.login = true;
          }
        "
      >
        Login
      </Button>
    </div>
    <div class="flex space-x-4" v-if="$store.state.auth.token">
      <Button
        type="btn-text"
        :onClick="
          () => {
            $router.push('/create');
          }
        "
      >
        Post a component
      </Button>
      <Button :onClick="logout"> Logout </Button>
    </div>
  </div>
</template>

<script>
export default {
  name: 'Header',
  methods: {
    async logout() {
      const logout = await this.$api.auth.logout();

      this.$store.state.auth.token = null;
      this.$store.state.auth.user = null;
      localStorage.removeItem('token');

      this.$router.push({ name: 'Home' });
    },
  },
};
</script>
