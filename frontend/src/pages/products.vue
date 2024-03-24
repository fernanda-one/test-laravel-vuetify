<script setup>
import api from '@/plugins/axios';
import { onMounted, ref } from 'vue';
const datasource = ref([])
const page = ref(1)
const isEdit = ref(false);
const isAdd = ref(false);
const isDelete = ref(false);
const isSelectedId = ref(null);
const isSuccess = ref(false);
const search = ref('');
const formCreate = ref({
    name:"",
    description:'',
    price:0,
    stock:0
});
const formEdit = ref({
    name:"",
    description:'',
    price:0,
    stock:0
})

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

function showModalDelete (id) {
    isSelectedId.value = id
    isDelete.value = true
}

function showModalEdit (data) {
    isSelectedId.value = data.id
    formEdit.value.description = data.description
    formEdit.value.name = data.name
    formEdit.value.price = data.price
    formEdit.value.stock = data.stock
    isEdit.value = true

}

function handleDelete () {
    api.delete('/product/' + isSelectedId.value).then((res) => {
        isDelete.value = false;
        getAllProduct();
    }).catch((err) => {
        console.log(err, 'error');
        return err;
    })
}
function handleCreate () {
    api.post('/product', formCreate.value).then((res) => {
        isAdd.value = false;
        getAllProduct();
    }).catch((err) => {
        console.log(err, 'error');
        return err;
    })
}
function handleEdit () {
    api.delete('/product/' + isSelectedId.value).then((res) => {
        isDelete.value = false;
        getAllProduct();
    }).catch((err) => {
        console.log(err, 'error');
        return err;
    })
}

onMounted(() => {
    getAllProduct();
})

</script>
<template>
    <VRow>
        <!-- Modal Delete-->
        <v-dialog
            v-model="isDelete"
            width="auto"
            >
            <VCard
                max-width="400"
                prepend-icon="mdi-update"
                title="Hapus"
            >
            <VCardText >
                <VRow class="mb-5">
                    <VCol cols="12">
                        <div class="">Apakah anda yakin?</div>
                    </VCol>
                    <VCol cols="12" class="justify-between">
                        <VBtn text="Batal" class="mr-6" @click="()=> isDelete =false"></VBtn>
                        <VBtn text="Delete" @click="handleDelete()" color="danger"</VBtn>
                    </VCol>
                </VRow>
            </VCardText>
            </VCard>
        </v-dialog>
        <!-- Modal Edit -->
        <v-dialog
            v-model="isEdit"
            width="auto"
            >
            <VCard
                class="text-center"
                max-width="500"
                prepend-icon="mdi-update"
                title="Update Product"
            >
            <VCardText>
                <VForm @submit.prevent="() => {}">
                    <VRow>
                        <VCol cols="12">
                        <VTextField
                            v-model="formEdit.name"
                            label="Name"
                            placeholder="New Product"
                        />
                        </VCol>
                
                        <VCol cols="12">
                        <VTextField
                            v-model="formEdit.description"
                            label="Description"
                            type="text"
                            placeholder="Product Description .."
                        />
                        </VCol>
                
                        <VCol cols="12">
                        <VTextField
                            v-model="formEdit.price"
                            label="Price"
                            autocomplete="on"
                            type="number"
                        />
                        </VCol>
                        <VCol cols="12">
                        <VTextField
                            v-model="formEdit.stock"
                            label="Stock"
                            autocomplete="on"
                            type="number"
                        />
                        </VCol>
                        <VCol
                        cols="12"
                        class="d-flex gap-4"
                        >
                        <VBtn type="submit">
                            Submit
                        </VBtn>
                
                        <VBtn
                            type="button"
                            color="secondary"
                            variant="outlined"
                            @click="()=> isEdit = false"
                        >
                            Batal
                        </VBtn>
                        </VCol>
                    </VRow>
                    </VForm>
            </VCardText>
            </VCard>
        </v-dialog>
        <!-- Modal Create -->
        <v-dialog
            v-model="isAdd"
            width="auto"
            >
            <VCard
                class="text-center"
                max-width="500"
                prepend-icon="mdi-update"
                title="Create Product"
            >
            <VCardText>
                <VForm @submit.prevent="handleCreate()">
                    <VRow>
                        <VCol cols="12">
                        <VTextField
                            v-model="formCreate.name"
                            label="Name"
                            placeholder="New Product"
                        />
                        </VCol>
                
                        <VCol cols="12">
                        <VTextField
                            v-model="formCreate.description"
                            label="Description"
                            type="text"
                            placeholder="Product Description .."
                        />
                        </VCol>
                
                        <VCol cols="12">
                        <VTextField
                            v-model="formCreate.price"
                            label="Price"
                            autocomplete="on"
                            type="number"
                        />
                        </VCol>
                        <VCol cols="12">
                        <VTextField
                            v-model="formCreate.stock"
                            label="Stock"
                            autocomplete="on"
                            type="number"
                        />
                        </VCol>
                        <VCol
                        cols="12"
                        class="d-flex gap-4"
                        >
                        <VBtn type="submit">
                            Submit
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

        <VCol cols="12" >
            <VBtn text="Add Product" @click="()=> isAdd = true"></VBtn>
        </VCol>
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
                    <VBtn @click="showModalDelete(item.id)" color="error" class="mr-4">Delete</VBtn>
                    <VBtn @click="showModalEdit(item)" color="primary">Edit</VBtn>
                </template>
            </VDataTable>
        </VCard>    
        </VCol>
    </VRow>
</template>

<style lang="scss" scoped>

</style>
