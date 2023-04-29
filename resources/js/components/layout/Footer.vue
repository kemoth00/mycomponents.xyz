<template>
  <div class="w-full h-fit flex flex-col justify-center space-y-4 mb-4">
    <div
      class="flex w-full items-center space-x-4 border-b border-gray-700 pb-4"
    >
      <router-link to="/" class="font-bold md:text-xl text-base grow">
        mycomponents
      </router-link>
    </div>
    <div
      class="flex w-full items-center justify-center space-x-4 text-center md:text-base text-sm"
    >
      <span>
        © 2022 - 2023
        <router-link to="/">mycomponents.xyz</router-link>
        - All Rights Reserved.
      </span>
    </div>
  </div>
</template>

<script>
export default {
  name: 'Footer',
};
</script>
