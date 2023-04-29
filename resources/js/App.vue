<template>
  <div class="w-full min-h-screen bg-gray-800 text-white">
    <Popups />

    <div
      class="md:container md:mx-auto flex flex-col min-h-screen w-full bg-gray-800 md:px-0 px-4 gap-4"
    >
      <Header />
      <router-view class="grow"></router-view>
      <Footer />
    </div>
  </div>
</template>

<script>
export default {
  name: 'App',
  async created() {
    if (
      localStorage.getItem('token') &&
      (!this.$store.state.auth.token || !this.$store.state.auth.user)
    ) {
      this.$store.state.auth.token = localStorage.getItem('token');

      this.$store.state.auth.user = await this.$api.auth.getUser();
    }
  },
};
</script>
