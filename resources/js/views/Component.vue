<template>
  <div class="flex flex-col gap-4 bg-gray-700 p-4 rounded-lg" v-if="component">
    <img
      class="h-96 object-contain rounded-lg"
      :src="$helpers.getAppUrl() + component.image"
      alt=""
    />

    <div class="flex sm:flex-row flex-col w-full justify-between gap-4">
      <div class="flex flex-col">
        <h1 class="font-bold text-2xl">{{ component.name }}</h1>
        <span class="text-sm text-gray-400">{{
          $helpers.dateTimeFormatter(component.created_at)
        }}</span>
        <p class="text-sm text-gray-400">{{ component.description }}</p>
      </div>
      <div class="flex gap-2 items-center justify-center">
        <Button
          class="w-fit h-12 font-bold"
          :class="upvoted ? 'bg-green-500' : ''"
          :onClick="upvote"
          >Upvote - {{ component.upvotes }}</Button
        >
        <Button
          class="w-fit h-12 font-bold"
          :class="downvoted ? 'bg-red-500' : ''"
          :onClick="downvote"
          >Downvote - {{ component.downvotes }}</Button
        >
      </div>
    </div>

    <TextArea
      name="code"
      type="codePreview"
      placeholder="Source code - Paste from clipboard only!"
      :error="formErrors?.code"
      :value="component.code"
      @onChange="$helpers.fieldOnChange($event, 'code', form, formErrors)"
    />
  </div>
</template>

<script>
export default {
  name: 'Component',
  data() {
    return {
      component: null,

      formErrors: null,
    };
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
  methods: {
    async upvote() {
      const componentData = await this.$api.components.upvoteComponent(
        this.component.uuid
      );

      if (!componentData?.message) {
        this.component = componentData;
        const index = this.$store.state.components.components.findIndex(
          (c) => c.uuid === this.component.uuid
        );
        if (index !== -1) {
          this.$store.state.components.components[index] = this.component;

          this.$store.state.auth.user = await this.$api.auth.getUser();
        }
      }
    },
    async downvote() {
      const componentData = await this.$api.components.downvoteComponent(
        this.component.uuid
      );
      if (!componentData?.message) {
        this.component = componentData;
        const index = this.$store.state.components.components.findIndex(
          (c) => c.uuid === this.component.uuid
        );
        if (index !== -1) {
          this.$store.state.components.components[index] = this.component;

          this.$store.state.auth.user = await this.$api.auth.getUser();
        }
      }
    },
  },
  async created() {
    this.component = await this.$api.components.getComponent(
      this.$route.params.uuid
    );
  },
};
</script>
