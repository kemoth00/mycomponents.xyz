<template>
  <div
    class="w-full h-auto py-2 bg-gray-700 rounded-lg flex sm:flex-row flex-col items-center px-2 sm:space-y-0 space-y-2"
  >
    <div class="flex">
      <Button
        :class="[filterType === 'popular' ? 'bg-indigo-600' : 'bg-gray-700']"
        :onClick="filterChanged"
        value="popular"
      >
        Popular
      </Button>
      <Button
        :class="[filterType === 'newest' ? 'bg-indigo-600' : 'bg-gray-700']"
        :onClick="filterChanged"
        value="newest"
      >
        Newest
      </Button>
    </div>

    <div class="flex grow items-center justify-end">
      <DropDown
        name="listingType"
        :options="listingTypes"
        :error="formErrors?.listingType"
        @onChange="
          $helpers.fieldOnChange($event, 'listingType', form, formErrors)
        "
      />
    </div>
  </div>
</template>

<script>
export default {
  name: 'FilterBar',
  props: {
    filterType: {
      type: String,
      default: 'popular',
    },
  },
  data() {
    return {
      form: {
        listingType: 'card',
      },

      formErrors: null,

      listingTypes: [
        { value: 'card', label: 'Card', icon: 'IconBars2' },
        { value: 'classic', label: 'Classic', icon: 'IconBars3' },
        { value: 'compact', label: 'Compact', icon: 'IconBars4' },
      ],
    };
  },
  methods: {
    filterChanged(type) {
      this.$emit('filterChanged', type);
    },
  },
  watch: {
    'form.listingType'(newValue, oldValue) {
      this.$emit('listingTypeChanged', newValue);
    },
  },
};
</script>
