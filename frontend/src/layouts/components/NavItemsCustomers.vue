<script setup>
import VerticalNavSectionTitle from '@/@layouts/components/VerticalNavSectionTitle.vue';
import VerticalNavLink from '@layouts/components/VerticalNavLink.vue';
</script>

<template>
  <!-- 👉 Dashboards -->
  <VerticalNavSectionTitle
  :item="{
    heading: 'Main Menu',
  }"
/>
  <VerticalNavLink
    :item="{
      title: 'Products',
      icon: 'ri-shopping-cart-2-line',
      to : '/products'
    }"
  />
  <VerticalNavLink
  :item="{
    title: 'Transaction',
    icon: 'ri-file-list-line',
    to : '/transaction'
  }"
/>



</template>
