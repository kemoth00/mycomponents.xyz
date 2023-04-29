<template>
  <div class="flex flex-col w-full">
    <div class="relative">
      <input
        :type="type"
        :placeholder="placeholder"
        :name="name"
        :class="[
          custClass,
          type === 'search' ? 'text-search' : 'text-default',

          formattedContent !== '' ? 'text-opacity-100' : '',
          error.length > 0 ? 'border-red-500' : '',
        ]"
        :disabled="isDisabled"
        v-model="formattedContent"
        @keyup="onChange"
        @search="onChange"
      />
    </div>

    <div class="text-red-500 text-sm mt-1 pl-1" v-if="error">
      {{ error[0] }}
    </div>
  </div>
</template>

<script>
export default {
  name: 'TextField',
  props: {
    type: {
      type: String,
      default: 'text',
    },
    placeholder: {
      type: String,
      default: '',
    },
    name: {
      type: String,
      default: '',
    },
    value: {
      type: [String, Number],
      default: '',
    },
    custClass: {
      type: String,
      default: '',
    },

    isDisabled: {
      type: Boolean,
      default: false,
    },

    error: {
      type: Array,
      default: [],
    },
  },
  data() {
    return {
      formattedContent: '',
      content: '',
    };
  },
  methods: {
    onChange() {
      this.content = this.formattedContent;

      this.$emit('onChange', this.content);
    },
  },
  mounted() {
    if (this.value) {
      this.formattedContent = this.value;
      this.content = this.value;
    }
  },
  watch: {
    value() {
      this.formattedContent = this.value;
      this.content = this.value;
    },
  },
};
</script>

<style>
input[type='search']::-webkit-search-cancel-button {
  -webkit-appearance: none;
  height: 1em;
  width: 1em;
  border-radius: 50em;
  background: url(https://pro.fontawesome.com/releases/v5.10.0/svgs/solid/times-circle.svg)
    no-repeat 50% 50%;
  background-size: contain;
  opacity: 0;
  pointer-events: none;
  filter: invert(1);
  cursor: pointer;
}

input[type='search']:focus::-webkit-search-cancel-button {
  opacity: 0.3;
  pointer-events: all;
}

input::-webkit-outer-spin-button,
input::-webkit-inner-spin-button {
  -webkit-appearance: none;
  margin: 0;
}
</style>
