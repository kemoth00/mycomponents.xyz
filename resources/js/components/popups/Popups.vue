<template>
  <div id="popupContainer" v-if="isAnyPopupOpen">
    <div
      class="fixed top-0 left-0 right-0 bottom-0 w-full h-full flex items-center justify-center z-50"
    >
      <Transition name="fade" appear>
        <div
          class="relative w-full h-full bg-black bg-opacity-80"
          @click="$store.dispatch('popups/closeAllPopups')"
          v-if="isAnyPopupOpen"
        ></div>
      </Transition>

      <Transition name="fade" appear>
        <Login v-if="$store.state.popups.login" />
      </Transition>

      <Transition name="fade" appear>
        <Register v-if="$store.state.popups.register" />
      </Transition>
    </div>
  </div>
</template>

<script>
export default {
  name: 'Popups',
  computed: {
    isAnyPopupOpen() {
      return this.$store.getters['popups/isAnyPopupOpen'];
    },
  },
  watch: {
    isAnyPopupOpen() {
      if (this.isAnyPopupOpen) {
        document.body.style.overflow = 'hidden';
        document.body.style.paddingRight = '8px';
      } else {
        document.body.style.overflow = 'auto';
        document.body.style.paddingRight = '0';
      }
    },
  },
};
</script>
