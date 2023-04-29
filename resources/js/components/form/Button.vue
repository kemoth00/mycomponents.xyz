<template>
  <button
    class="flex items-center justify-center"
    :class="[type]"
    @click="onClick(value)"
  >
    <SvgIcon :name="icon" v-if="icon" />
    <span v-if="!onlyIcon">
      <slot></slot>
    </span>
  </button>
</template>

<script>
export default {
  name: 'Button',
  props: {
    type: {
      type: String,
      default: 'btn-main',
    },
    icon: {
      type: String,
      default: '',
    },
    onlyIcon: {
      type: Boolean,
      default: false,
    },
    value: {
      type: [String, Number],
      default: '',
    },
    onClick: {
      type: Function,
      default: () => {},
      required: true,
    },
  },
  data() {
    return {};
  },
  methods: {},
};
</script>
