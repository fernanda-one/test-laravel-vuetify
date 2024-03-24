<script setup>
import api from '@/plugins/axios';
import { onMounted, ref } from 'vue';
const datasource = ref([])
const page = ref(1)
const isBuy = ref(false);
const search = ref('');
const quantity = ref(1);
const selectedId = ref('');
const customer = JSON.parse(localStorage.getItem('user'))
const customerId = customer.id

function getAllProduct() {
    api.get(`/product?page=${page.value}&limit=100`).then((res) => {
        const respData = res?.data?.data
        datasource.value = respData
        return {datasource}
    }).catch((err) => {
        console.log(err?.response?.data?.message?.[0]);
    })
}

const headers = [
    {key:"no",title:"no"},
    {key:"name",title:"name"},
    {key:"description",title:"description"},
    {key:"price",title:"price"},
    {key:"stock",title:"stock"},
    {key:"action",title:"action", value:"action"},
]

function handleBuy () {
    const body = {
        customer_id :customerId,
        product_id :selectedId.value,
        quantity: quantity.value
    }
    api.post('/transaction', body).then((res) => {
        isBuy.value = false;
        getAllProduct();
        selectedId.value =''
        quantity.value =1
    }).catch((err) => {
        console.log(err, 'error');
        return err;
    })
}
function showModalBuy (id) {
    selectedId.value = id
    isBuy.value = true
}
onMounted(() => {
    getAllProduct();
})

</script>
<template>
    <VRow>
        <!-- Modal Buy -->
        <v-dialog
            v-model="isBuy"
            width="auto"
            >
            <VCard
                class="text-center"
                max-width="500"
                prepend-icon="mdi-update"
                title="Buy Product"
            >
            <VCardText>
                <VForm @submit.prevent="handleBuy()">
                    <VRow>
                        <VCol cols="12">
                        <VTextField
                            v-model="quantity"
                            label="Quantity"
                            autocomplete="on"
                            type="number"
                        />
                        </VCol>
                        <VCol
                        cols="12"
                        class="d-flex gap-4"
                        >
                        <VBtn type="submit">
                            Buy
                        </VBtn>
                
                        <VBtn
                            type="button"
                            color="secondary"
                            variant="outlined"
                            @click="()=> isAdd = false"
                        >
                            Batal
                        </VBtn>
                        </VCol>
                    </VRow>
                </VForm>
            </VCardText>
            </VCard>
        </v-dialog>
        <!-- End Modal -->
        <VCol cols="12">
            <VCard  title="List Product">
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
            <VDataTable :headers="headers" :search="search" :items-per-page="10" :items="datasource" item-value="id">
                <template #item.no="{ item ,index }">
                    {{ index + 1}} 
                </template>
                <template #item.action="{ item }">
                    <VBtn @click="showModalBuy(item.id)" color="primary">Buy</VBtn>
                </template>
            </VDataTable>
        </VCard>    
        </VCol>
    </VRow>
</template>

<style lang="scss" scoped>

</style>
