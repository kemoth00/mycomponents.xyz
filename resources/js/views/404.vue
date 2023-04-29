<template>
  <div class="w-full h-full flex flex-col items-center justify-center">
    <span class="text-8xl">OOPS!</span>
    <span class="text-xl text-center">
      We can't seem to find the page you're looking for.
    </span>
    <router-link
      to="/"
      class="bg-indigo-600 px-6 py-1.5 rounded-lg flex items-center mt-4"
    >
      Are you lost?
    </router-link>
  </div>
</template>

<script>
export default {
  name: '404',
};
</script>
