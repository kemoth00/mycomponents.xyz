<template>
  <div class="flex flex-col gap-4">
    <TextField
      name="name"
      type="text"
      placeholder="Title"
      :error="formErrors?.name"
      @onChange="$helpers.fieldOnChange($event, 'name', form, formErrors)"
    />
    <TextArea
      name="description"
      placeholder="Description"
      :custClass="'!h-32'"
      :error="formErrors?.description"
      @onChange="
        $helpers.fieldOnChange($event, 'description', form, formErrors)
      "
    />
    <div class="flex gap-4">
      <DropDown
        name="front_end_type"
        :custClass="'!w-full'"
        :options="frontends"
        :error="formErrors?.front_end_type"
        @onChange="
          $helpers.fieldOnChange($event, 'front_end_type', form, formErrors)
        "
      />
      <DropDown
        name="style_type"
        :custClass="'!w-full'"
        :options="styles"
        :error="formErrors?.style_type"
        @onChange="
          $helpers.fieldOnChange($event, 'style_type', form, formErrors)
        "
      />
    </div>
    <div
      class="w-full h-52 bg-gray-700 flex items-center justify-center rounded-xl cursor-pointer hover:bg-opacity-80 transition duration-3 p-4"
      @click="uploadPicture"
    >
      <span v-if="!imageUploaded"> Upload picture </span>
      <img
        id="previewPicture"
        src=""
        class="w-full h-full object-contain hover:opacity-80 transition duration-3"
        alt="your image"
        v-show="imageUploaded"
      />
    </div>
    <div class="text-red-500 text-sm mt-1 pl-1" v-if="formErrors?.image">
      {{ formErrors.image[0] }}
    </div>

    <TextArea
      name="code"
      type="code"
      placeholder="Source code - Paste from clipboard only!"
      :error="formErrors?.code"
      @onChange="$helpers.fieldOnChange($event, 'code', form, formErrors)"
    />
    <Button class="w-full font-bold" :onClick="create">Create</Button>
  </div>
</template>

<script>
export default {
  name: 'Create',
  data() {
    return {
      imageUploaded: false,

      form: {
        name: '',
        description: '',
        front_end_type: 'all',
        style_type: 'all',
        code: '',
      },

      formErrors: null,

      frontends: [
        { value: 'all', label: 'Front-End' },
        { value: 'angular', label: 'Angular', icon: 'IconAngular' },
        { value: 'html', label: 'HTML', icon: 'IconHTML' },
        { value: 'jquery', label: 'jQuery', icon: 'IconJQuery' },
        { value: 'react', label: 'React', icon: 'IconReact' },
        { value: 'vue2', label: 'Vue 2', icon: 'IconVue' },
        { value: 'vue3', label: 'Vue 3', icon: 'IconVue' },
      ],
      styles: [
        { value: 'all', label: 'Style' },
        { value: 'bootstrap', label: 'Bootstrap', icon: 'IconBootstrap' },
        { value: 'bulma', label: 'Bulma', icon: 'IconBulma' },
        { value: 'css', label: 'CSS', icon: 'IconCSS' },
        { value: 'scss', label: 'SCSS', icon: 'IconSCSS' },
        { value: 'tailwind', label: 'Tailwind', icon: 'IconTailwind' },
      ],
    };
  },
  methods: {
    uploadPicture() {
      let input = document.createElement('input');
      input.type = 'file';
      input.onchange = async (_) => {
        this.form.image = input.files[0];
        this.imageUploaded = true;
        previewPicture.src = URL.createObjectURL(input.files[0]);
      };
      input.click();
    },
    async create() {
      const postCreate = await this.$api.components.create(this.form);

      if (postCreate.errors) {
        this.formErrors = postCreate.errors;
      } else {
        this.$router.push('/component/' + postCreate.uuid);

        this.$store.state.components.components = [
          postCreate,
          ...this.$store.state.components.components,
        ];
      }
    },
  },
};
</script>
