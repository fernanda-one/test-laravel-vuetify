<script setup>
    import api from '@/plugins/axios';
    import SimpleTableBasics from '@/views/pages/tables/SimpleTableBasics.vue';
    import { onMounted, ref } from 'vue';
import { VCol, VRow } from 'vuetify/lib/components/index.mjs';
    const datasource = ref([])
    const isCreate = ref(false)
    const isDelete = ref(false)
    const isEdit = ref(false)
    const selectedId = ref('')
    const search = ref('')
    const formCreate = ref({
        name:'',
        email:'',
        password:'',
        role_id:2
    })
    const formEdit= ref({
        name:'',
        email:'',
        password:'',
        role_id:2
    })
    function getData(){
        api.get('/users').then((res) => {
        const respData = res?.data?.data?.data
        datasource.value = respData
        return {datasource}
        }).catch((err) => {
            console.log(err?.response?.data?.message?.[0]);
        })
    }
    function showModalEdit (data) {
        selectedId.value = data.id
        formEdit.value.email = data.email
        formEdit.value.name = data.name
        formEdit.value.password = ''
        isEdit.value = true
    }
    function handleCreate(){
        api.post('/users', formCreate.value).then((res) => {
        isCreate.value = false;
        getData()
        return;
        }).catch((err) => {
            console.log(err?.response?.data?.message?.[0]);
            return err;
        })
    }
    function handleEdit(){
        api.post('/users/' +selectedId.value, formEdit.value).then((res) => {
        isEdit.value = false;
        getData()
        return;
        }).catch((err) => {
            console.log(err?.response?.data?.message?.[0]);
            return err;
        })
    }
    function handleDelete(){
        api.delete(`/users/${selectedId.value}`).then((res) => {
        isDelete.value = false;
        getData()
        return;
        }).catch((err) => {
            console.log(err?.response?.data?.message?.[0]);
            return err;
        })
    }

    
    function showModalDelete(id){
        selectedId.value = id
        isDelete.value = true;

    }

    const headers = [
        {key:"no",title:"no"},
        {key:"name",title:"name"},
        {key:"email",title:"email"},
        {key:"role_id",title:"role"},
        {key:"action",title:"action"},
    ]
    onMounted(()=>{
        getData();
    })

</script>
<template>
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
                <VBtn text="Delete" @click="handleDelete()" color="error"</VBtn>
            </VCol>
        </VRow>
    </VCardText>
    </VCard>
    </v-dialog>
    <VDialog :model-value="isEdit" width="auto">
        <VCard title="Edit Customer" class="text-center" max-width="500">  
            <VCardText>
                <VForm @submit.prevent="handleEdit()">
                    <VRow>
                        <VCol cols="12">
                        <VTextField
                            v-model="formEdit.name"
                            label="Name"
                            type="text"
                            placeholder="John"
                        />
                        </VCol>
                
                        <VCol cols="12">
                        <VTextField
                            v-model="formEdit.email"
                            label="Email"
                            type="text"
                            placeholder="john@gmail.com"
                        />
                        </VCol>
                
                        <VCol cols="12">
                        <VTextField
                            v-model="formEdit.password"
                            label="password"
                            autocomplete="on"
                            type="password"
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
    </VDialog>
    <VDialog :model-value="isCreate" width="auto">
        <VCard title="Create New Customers" class="text-center" max-width="500">  
            <VCardText>
                <VForm @submit.prevent="handleCreate()">
                    <VRow>
                        <VCol cols="12">
                        <VTextField
                            v-model="formCreate.name"
                            label="Name"
                            type="text"
                            placeholder="John"
                        />
                        </VCol>
                
                        <VCol cols="12">
                        <VTextField
                            v-model="formCreate.email"
                            label="Email"
                            type="text"
                            placeholder="john@gmail.com"
                        />
                        </VCol>
                
                        <VCol cols="12">
                        <VTextField
                            v-model="formCreate.password"
                            label="password"
                            autocomplete="on"
                            type="password"
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
                            @click="()=> isCreate = false"
                        >
                            Batal
                        </VBtn>
                        </VCol>
                    </VRow>
                </VForm>
            </VCardText>      
        </VCard>
    </VDialog>
    <VRow>
        <VCol cols="12">
            <VBtn text="Create User" @click="()=> isCreate=true"></VBtn>
        </VCol>
    </VRow>
    <VRow>
        <VCol cols="12">
            <VCard  title="List Users">
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
                    <template #item.role_id="{item ,index}">
                        {{ item.role_id == 2? 'customer':'admin' }}
                    </template>
                    <template #item.action="{item ,index}">
                        <VBtn text="Delete" @click="showModalDelete(item.id)" color="error" class="mr-4"</VBtn>
                        <VBtn text="Edit" @click="showModalEdit(item)"></VBtn>
                    </template>
                </VDataTable>
            </VCard>
        </VCol>
    </VRow>
</template>

<style lang="scss" scoped>

</style>
