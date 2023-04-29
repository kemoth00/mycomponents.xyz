<template>
  <div class="w-full flex flex-col space-y-2 gap-2">
    <SearchBar :filterType="filterType" />
    <FilterBar
      :filterType="filterType"
      @filterChanged="filterChanged"
      @listingTypeChanged="listingTypeChanged"
    />

    <div class="flex flex-col space-y-2 gap-2 pt-2">
      <ComponentRow
        v-for="component in $store.state.components.components"
        :key="component.uuid"
        :component="component"
        :listingType="listingType"
        ref="componentRows"
      />

      <Button
        class="w-full h-12 font-bold !my-4"
        :onClick="loadNextPage"
        v-if="$store.state.components.nextPage"
      >
        Load more...
      </Button>

      <span
        class="w-full text-center text-gray-400 mt-4"
        v-if="!isLoading && $store.state.components.components.length === 0"
      >
        No components uploaded yet!
      </span>
    </div>
  </div>
</template>

<script>
import { nextTick } from 'vue';
export default {
  name: 'Home',
  data() {
    return {
      filterType: 'popular',
      listingType: 'card',
      isLoading: false,
    };
  },
  methods: {
    filterChanged(type) {
      this.filterType = type;
    },
    listingTypeChanged(type) {
      this.listingType = type;
    },
    async loadNextPage() {
      this.$store.state.components.page = this.$store.state.components.nextPage;

      let components = null;

      if (this.$store.state.components.searchParams) {
        components = await this.$api.components.searchComponents(
          this.$store.state.components.searchParams,
          this.$store.state.components.page
        );
      } else {
        components = await this.$api.components.getComponents(
          this.filterType,
          this.$store.state.components.page
        );
      }

      this.$store.state.components.nextPage = components.links.next;

      if (this.$store.state.components.nextPage) {
        this.$store.state.components.nextPage = new URL(
          this.$store.state.components.nextPage
        ).searchParams.get('page');
      } else {
        this.$store.state.components.nextPage = null;
      }

      this.$store.state.components.components.push(...components.data);
    },
  },
  async mounted() {
    if (this.$store.state.components.components.length > 0) return;

    this.isLoading = true;

    this.$store.state.components.page = 1;

    const components = await this.$api.components.getComponents(
      this.filterType
    );

    this.$store.state.components.nextPage = components.links.next;

    if (this.$store.state.components.nextPage) {
      this.$store.state.components.nextPage = new URL(
        this.$store.state.components.nextPage
      ).searchParams.get('page');
    }

    this.isLoading = false;

    this.$store.state.components.components = components.data;

    nextTick(() => {
      const options = {
        root: null,
        rootMargin: '0px',
        threshold: 1.0,
      };

      const observer = new IntersectionObserver((entries) => {
        if (
          entries[0].isIntersecting &&
          this.$store.state.components.nextPage
        ) {
          this.loadNextPage();
        }
      }, options);

      const target =
        this.$refs.componentRows[this.$refs.componentRows.length - 1];

      observer.observe(target.$el);
    });
  },
  watch: {
    filterType: async function (newVal, oldVal) {
      this.$store.state.components.page = 1;

      const components = await this.$api.components.getComponents(newVal);

      this.$store.state.components.nextPage = components.links.next;

      if (this.$store.state.components.nextPage) {
        this.$store.state.components.nextPage = new URL(
          this.$store.state.components.nextPage
        ).searchParams.get('page');
      }

      this.$store.state.components.components = components.data;
    },
  },
};
</script>
