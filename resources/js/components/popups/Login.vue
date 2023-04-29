<template>
  <div
    class="z-50 absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 sm:w-[30rem] w-full h-full sm:h-fit bg-gray-800 sm:rounded-lg flex flex-col justify-center items-center p-4 space-y-2"
  >
    <SvgIcon
      class="absolute top-0 right-0 mr-4 mt-4 cursor-pointer"
      name="IconX"
      @click="$store.dispatch('popups/closeAllPopups')"
    />

    <h1 class="text-3xl font-bold pb-4">Login</h1>

    <TextField
      name="email"
      type="email"
      placeholder="E-mail"
      :error="formErrors?.email"
      @onChange="$helpers.fieldOnChange($event, 'email', form, formErrors)"
    />

    <TextField
      name="password"
      type="password"
      placeholder="Password"
      :error="formErrors?.password"
      @onChange="$helpers.fieldOnChange($event, 'password', form, formErrors)"
    />

    <Button class="w-full font-bold" :onClick="login">Login</Button>

    <div class="w-full flex justify-center text-sm pt-4 cursor-pointer">
      <span @click="switchPopup">Don't have an account?</span>
    </div>
  </div>
</template>

<script>
export default {
  name: 'Login',
  data() {
    return {
      form: {
        email: '',
        password: '',
      },

      formErrors: null,
    };
  },
  methods: {
    switchPopup() {
      this.$store.dispatch('popups/closeAllPopups');
      this.$store.state.popups.register = true;
    },
    async login() {
      const login = await this.$api.auth.login(this.form);

      if (login.token && login.user) {
        this.$store.state.auth.token = login.token;

        this.$store.state.auth.user = await this.$api.auth.getUser();

        localStorage.setItem('token', login.token);

        this.formErrors = null;

        this.$store.dispatch('popups/closeAllPopups');
      } else {
        this.$store.state.auth.token = null;
        this.$store.state.auth.user = null;
        localStorage.removeItem('token');

        this.formErrors = login.errors;
      }
    },
  },
};
</script>
