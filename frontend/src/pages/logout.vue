<script setup>
import { useRouter } from 'vue-router'

const router = useRouter()
  localStorage.clear()
  router.push('/login')
</script>

<template>
</template>

<style lang="scss">
@use "@core/scss/pages/page-auth.scss";
</style>
