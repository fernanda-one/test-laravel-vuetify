<script setup>
    const props = defineProps(['datasource','headers','page', 'limit'])
</script>

<template>
    <VDataTable :headers="props.headers" :items-per-page="10" :items="props.datasource" item-value="no">
    </VDataTable>
</template>

<style lang="scss" scoped>

</style>
