<template>
  <div
    tabindex="0"
    class="relative bg-gray-600 rounded-lg py-2 w-44 px-4 flex items-center justify-center space-x-2 cursor-pointer"
    :class="custClass"
    @click="isOpened = !isOpened"
    @focusout="this.isOpened = false"
  >
    <SvgIcon :name="placeholder.icon" v-if="placeholder.icon" />
    <span>{{ placeholder.label }}</span>
    <SvgIcon name="IconArrowDown" />
    <div
      class="absolute z-10 top-0 bg-gray-600 rounded-lg p-2 w-44 flex flex-col !ml-0 whitespace-nowrap shadow-lg"
      :class="custClass"
      v-show="isOpened"
    >
      <div
        v-for="option in options"
        class="cursor-pointer hover:bg-indigo-600 px-2 mb-1 rounded-lg flex items-center space-x-2"
        :key="option.value"
        @click="optionClicked(option)"
      >
        <SvgIcon :name="option.icon" v-if="option.icon" />
        <span>{{ option.value === 'all' ? 'All' : option.label }}</span>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'DropDown',
  props: {
    name: {
      type: String,
      default: '',
      required: true,
    },
    options: {
      type: Array,
      default: () => [],
    },
    styleType: {
      type: String,
      default: 'dropdown-default',
    },
    custClass: {
      type: String,
      default: '',
    },
  },
  computed: {
    placeholder() {
      return this.options.find((x) => x.value === this.data.value);
    },
  },
  data() {
    return {
      data: {
        name: '',
        value: this.options[0].value,
      },
      isOpened: false,
    };
  },
  methods: {
    optionClicked(option) {
      this.data.value = option.value;
      this.$emit('onChange', this.data.value);
    },
  },
  created() {
    this.data.name = this.name;
  },
};
</script>
