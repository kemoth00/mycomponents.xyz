<template>
  <div
    class="h-96 flex w-full"
    :class="
      listingType === 'card'
        ? 'h-96'
        : listingType === 'classic'
        ? 'h-64'
        : 'h-fit'
    "
  >
    <div
      class="w-12 bg-gray-600 flex flex-col justify-center items-center rounded-l-lg"
    >
      <SvgIcon
        class="cursor-pointer hover:opacity-75"
        :class="upvoted ? 'text-green-500' : ''"
        name="IconArrowUp"
        @click="upvote"
      />
      <span class="font-bold text-lg">{{
        $helpers.kFormatter(componentData.upvotes - componentData.downvotes)
      }}</span>
      <SvgIcon
        class="cursor-pointer hover:opacity-75"
        :class="downvoted ? 'text-red-500' : ''"
        name="IconArrowDown"
        @click="downvote"
      />
    </div>
    <div
      class="w-full flex flex-col cursor-pointer hover:opacity-75"
      @click="openComponent"
    >
      <div
        class="bg-gray-600 w-full h-12 flex items-center p-2 gap-2 rounded-tr-lg"
      >
        <span>{{ componentData.name }}</span>
      </div>
      <div
        class="w-full h-[calc(100%-8rem)] md:h-[calc(100%-6rem)] bg-gray-700 flex justify-center items-center p-4"
        v-if="listingType !== 'compact'"
      >
        <img
          class="h-full w-full object-contain"
          :src="$helpers.getAppUrl() + componentData.image"
          alt=""
        />
      </div>
      <div
        class="bg-gray-600 w-full md:h-12 h-20 flex items-center p-2 gap-2 rounded-br-lg"
      >
        <div class="flex md:flex-row flex-col items-center w-full gap-2">
          <div class="flex w-full gap-2 md:ml-0 ml-1">
            <span>{{ componentData.user.username }}</span>
            <span class="hidden sm:flex">-</span>
            <span class="hidden sm:flex">{{
              $helpers.dateTimeFormatter(componentData.created_at)
            }}</span>
          </div>

          <div class="flex gap-2 md:justify-end w-full">
            <span class="bg-gray-700 py-1 px-2 rounded-lg">{{
              componentData.front_end_type === 'all'
                ? 'Not categorized'
                : componentData.front_end_type
            }}</span>
            <span class="bg-gray-700 py-1 px-2 rounded-lg">{{
              componentData.style_type === 'all'
                ? 'Not categorized'
                : componentData.style_type
            }}</span>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'ComponentRow',
  props: {
    component: {
      type: Object,
      required: true,
    },
    listingType: {
      type: String,
      default: 'card',
    },
  },
  computed: {
    upvoted() {
      return (
        this.$store.state.auth.user &&
        this.$store.state.auth.user.interactions.find(
          (i) => i.component_id === this.component.id && i.type === 'upvote'
        )
      );
    },
    downvoted() {
      return (
        this.$store.state.auth.user &&
        this.$store.state.auth.user.interactions.find(
          (i) => i.component_id === this.component.id && i.type === 'downvote'
        )
      );
    },
  },
  data() {
    return {
      componentData: null,
    };
  },
  created() {
    this.componentData = this.component;
  },
  methods: {
    openComponent() {
      this.$router.push({
        name: 'Component',
        params: { uuid: this.component.uuid },
      });
    },
    async upvote() {
      const componentUpdated = await this.$api.components.upvoteComponent(
        this.component.uuid
      );
      if (!componentUpdated?.message) {
        const index = this.$store.state.components.components.findIndex(
          (c) => c.uuid === componentUpdated.uuid
        );
        if (index !== -1) {
          this.$store.state.components.components[index] = componentUpdated;

          this.$store.state.auth.user = await this.$api.auth.getUser();
        }

        this.componentData = componentUpdated;
      }
    },
    async downvote() {
      const componentUpdated = await this.$api.components.downvoteComponent(
        this.component.uuid
      );

      if (!componentUpdated?.message) {
        const index = this.$store.state.components.components.findIndex(
          (c) => c.uuid === componentUpdated.uuid
        );
        if (index !== -1) {
          this.$store.state.components.components[index] = componentUpdated;

          this.$store.state.auth.user = await this.$api.auth.getUser();
        }

        this.componentData = componentUpdated;
      }
    },
  },
};
</script>
