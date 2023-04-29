<template>
  <component :is="dynamicComponent" />
</template>

<script>
import { defineAsyncComponent } from 'vue';
export default {
  props: {
    name: {
      type: String,
      required: true,
    },
  },
  computed: {
    dynamicComponent() {
      const name = this.name;
      return defineAsyncComponent(() =>
        import(`../../assets/icons/${name}.vue`)
      );
    },
  },
};
</script>
