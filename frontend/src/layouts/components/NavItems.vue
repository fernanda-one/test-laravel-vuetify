<script setup>
import VerticalNavSectionTitle from '@/@layouts/components/VerticalNavSectionTitle.vue';
import VerticalNavLink from '@layouts/components/VerticalNavLink.vue';
</script>

<template>
  <!-- 👉 Dashboards -->
  <VerticalNavSectionTitle
  :item="{
    heading: 'User Interface',
  }"
/>
  <VerticalNavLink
    :item="{
      title: 'Customers',
      icon: 'ri-user-3-line',
      to : '/admin/customers'
    }"
  />
  <VerticalNavLink
    :item="{
      title: 'Products',
      icon: 'ri-shopping-cart-2-line',
      to : '/admin/products'
    }"
  />


  <!-- 👉 User Interface -->
  <VerticalNavSectionTitle
    :item="{
      heading: 'Main Menu',
    }"
  />
  <VerticalNavLink
    :item="{
      title: 'Typography',
      icon: 'ri-text',
      to: '/admin/typography',
    }"
  />
  <VerticalNavLink
    :item="{
      title: 'Icons',
      icon: 'ri-remixicon-line',
      to: '/admin/icons',
    }"
  />
  <VerticalNavLink
    :item="{
      title: 'Cards',
      icon: 'ri-bar-chart-box-line',
      to: '/admin/cards',
    }"
  />


</template>
