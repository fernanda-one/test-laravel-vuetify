<script setup>
    import { convertDate } from '@/@layouts/utils';
    import api from '@/plugins/axios';
    import { onMounted, ref } from 'vue';
    const datasource = ref([])
    const search = ref('')
    const customer = JSON.parse(localStorage.getItem('user'))
    const customerId = customer.id
    function getData(){
        api.get('/transaction?customer_id=' +customerId).then((res) => {
        const respData = res?.data?.data?.data
        datasource.value = respData
        return {datasource}
        }).catch((err) => {
            console.log(err?.response?.data?.message?.[0]);
        })
    }

    const headers = [
        {key:"no",title:"no"},
        {key:"reference_number",title:"reference number"},
        {key:"no_invoice",title:"no invoice"},
        {key:"product.name",title:"product"},
        {key:"quantity",title:"quantity"},
        {key:"total_amount",title:"total amount"},
        {key:"created_at",title:"created at"},
    ]
    onMounted(()=>{
        getData();
    })

</script>
<template>
    <VRow>
        <VCol cols="12">
            <VCard  title="List Transaction">
                <VCardText>
                    <VRow>
                        <VCol
                        cols="12"
                        offset-md="8"
                        md="4"
                        >
                        <VTextField
                            v-model="search"
                            label="Search"
                            placeholder="Search ..."
                            append-inner-icon="ri-search-line"
                            single-line
                            hide-details
                            dense
                            outlined
                        />
                        </VCol>
                    </VRow>
                </VCardText>
                <VDataTable :headers="headers" :search="search":items="datasource">
                    <template #item.no="{index}">
                        {{ index + 1 }}
                    </template>
                    <template #item.created_at="{item ,index}">
                        {{ convertDate(item.created_at) }}
                    </template>
                </VDataTable>
            </VCard>
        </VCol>
    </VRow>
</template>

<style lang="scss" scoped>

</style>
