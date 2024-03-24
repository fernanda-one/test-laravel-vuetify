<script setup>
import DefaultCustomerLayoutWithVerticalNav from './components/DefaultCustomerLayoutWithVerticalNav.vue';

</script>

<template>
  <DefaultCustomerLayoutWithVerticalNav>
    <RouterView />
  </DefaultCustomerLayoutWithVerticalNav>
</template>

<style lang="scss">
// As we are using `layouts` plugin we need its styles to be imported
@use "@layouts/styles/default-layout";
</style>
./components/DefaultLayoutCustomerWithVerticalNav.vue
