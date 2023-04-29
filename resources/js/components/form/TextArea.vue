<template>
  <div class="flex flex-col w-full">
    <div class="relative">
      <div
        class="w-full flex justify-end mb-4"
        v-if="
          type === 'text' || type === 'codePreview'
            ? false
            : formattedContent.length > 0
        "
      >
        <Button
          type="btn-mainOutline"
          class="font-bold w-full"
          :onClick="reset"
        >
          Delete source code
        </Button>
      </div>
      <textarea
        :placeholder="placeholder"
        :name="name"
        class="text-default resize-none h-96"
        :class="[
          custClass,
          content !== '' ? 'text-opacity-100' : '',
          error.length > 0 ? 'border-red-500' : '',
        ]"
        :disabled="isDisabled"
        v-model="content"
        @input="onChange"
        @search="onChange"
        v-if="type === 'text' ? true : formattedContent.length === 0"
      ></textarea>
      <div
        class="relative overflow-y-auto resize-none rounded-xl outline-none"
        :class="type === 'codePreview' ? '!h-full' : 'h-96'"
        v-if="type === 'text' ? false : formattedContent.length > 0"
      >
        <Button
          type="btn-main"
          class="absolute top-4 right-4 font-bold"
          :onClick="copy"
          v-if="type === 'codePreview'"
        >
          Copy
        </Button>
        <pre
          class="language-javascript !m-0"
          :class="type === 'codePreview' ? '!h-full' : 'h-96'"
        >
          <code  v-html="formattedContent"></code>
        </pre>
      </div>
    </div>

    <div class="text-red-500 text-sm mt-1 pl-1" v-if="error.length > 0">
      {{ error[0] }}
    </div>
  </div>
</template>

<script>
import Prism from 'prismjs';

export default {
  name: 'TextArea',
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
    copy() {
      navigator.clipboard.writeText(this.content);
    },
    reset() {
      this.content = '';
      this.formattedContent = '';
      this.$emit('onChange', '');
    },
    onChange(event) {
      if (event.inputType === 'insertFromPaste' || this.type === 'text') {
        this.formattedContent = Prism.highlight(
          this.content,
          Prism.languages.javascript,
          'html'
        );

        this.$emit('onChange', this.content);
      } else {
        content = '';
        this.formattedContent = '';
      }
    },
  },
  mounted() {
    if (this.value) {
      this.content = this.value;
      this.formattedContent = Prism.highlight(
        this.value,
        Prism.languages.javascript,
        'html'
      );
    }
  },
  watch: {
    value() {
      this.content = this.value;
      this.formattedContent = Prism.highlight(
        this.value,
        Prism.languages.javascript,
        'html'
      );
    },
  },
};
</script>
