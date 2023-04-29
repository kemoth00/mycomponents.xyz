<template>
  <div
    class="w-full h-auto bg-gray-700 rounded-lg flex md:flex-row flex-col items-center md:justify-start justify-center px-2 py-2 md:space-x-2"
  >
    <TextField
      name="needle"
      type="text"
      placeholder="Search for Text field, Login, Table ..."
      :error="formErrors?.needle"
      @onChange="$helpers.fieldOnChange($event, 'needle', form, formErrors)"
    />
    <div
      class="flex flex-wrap items-center justify-center gap-2 md:flex-nowrap"
    >
      <DropDown
        name="front_end_type"
        :options="frontends"
        :error="formErrors?.front_end_type"
        @onChange="
          $helpers.fieldOnChange($event, 'front_end_type', form, formErrors)
        "
      />
      <DropDown
        name="style_type"
        :options="styles"
        :error="formErrors?.style_type"
        @onChange="
          $helpers.fieldOnChange($event, 'style_type', form, formErrors)
        "
      />
      <Button icon="IconSearch" :onClick="search"> Search </Button>
    </div>
  </div>
</template>

<script>
export default {
  name: 'SearchBar',
  props: {
    filterType: {
      type: String,
      default: 'popular',
    },
  },
  data() {
    return {
      form: {
        needle: '',
        front_end_type: 'all',
        style_type: 'all',
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
    async search() {
      let formattedForm = JSON.parse(JSON.stringify(this.form));

      if (formattedForm.front_end_type === 'all') {
        formattedForm.front_end_type = null;
      }

      if (formattedForm.style_type === 'all') {
        formattedForm.style_type = null;
      }

      formattedForm.order = this.filterType;

      if (
        formattedForm.style_type === null &&
        formattedForm.front_end_type === null &&
        formattedForm.needle === ''
      ) {
        this.$store.state.components.searchParams = null;

        const components = await this.$api.components.getComponents(
          this.filterType
        );

        this.$store.state.components.nextPage = components.links.next;

        if (this.$store.state.components.nextPage) {
          this.$store.state.components.nextPage = new URL(
            this.$store.state.components.nextPage
          ).searchParams.get('page');
        }

        this.$store.state.components.components = components.data;
      } else {
        const searchData = await this.$api.components.searchComponents(
          formattedForm
        );

        this.$store.state.components.page = 1;

        this.$store.state.components.nextPage = searchData.links.next;

        if (this.$store.state.components.nextPage) {
          this.$store.state.components.nextPage = new URL(
            searchData.links.next
          ).searchParams.get('page');
        }

        this.$store.state.components.components = searchData.data;

        this.$store.state.components.searchParams = formattedForm;
      }
    },
  },
  watch: {
    'form.front_end_type'() {
      this.search();
    },
    'form.style_type'() {
      this.search();
    },
  },
};
</script>
