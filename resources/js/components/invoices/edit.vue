<script setup>
import axios from "axios";
import { onMounted, ref } from "vue"
import { useRouter } from 'vue-router'

    let id = ref({ id: '' })
    let company = ref([])
    let router = useRouter()

    const props = defineProps({
        id: {
            type: String,
            default: ''
        }
    })

    onMounted(async () => {
        getEditCompany();
    })

    const getEditCompany = async () => {
        let response = await axios.get(`/api/show_companyForEdit/${props.id}`);
        console.log('form', response.data.company);
        company.value = response.data.company
    }
    const onSave = () => {
        if (company.value != '') {
            // csrf = document.head.querySelector('meta[name="csrf-token"]').getAttribute('content');
            const formData = new FormData()
            // console.log(company.value)
            // formData.append('id', company.value.id);
            formData.append('company_name', company.value.name);
            formData.append('company_status', company.value.status)
            
            axios.post(`/api/edit_company/${company.value.id}`, formData).then(response => {
                router.push('/')
            }).catch(error => {
                if (error.response) {
                    console.error("data: ", error.response.data)
                    console.error("errorCode: ", error.response.status)
                }
            })

        }
    }

</script>
<template>
    <div class="container">
        <div class="invoices">
            <div class="item--company--name">
                <span class="item--company--name--span">Update Company Name: </span>
                <p>
                    <input type="text" class="input item--company--name--input" v-model="company.name">
                </p>
                <div>
                    <select name="" id="" class="input edit--select" v-model="company.status">
                        <!-- <option disabled>選擇店家</option> -->
                        <option value="1">開啟</option>
                        <option value="0">關閉</option>
                    </select>
                </div>
            </div>
            <div class="card__footer">
                <div class="item--company--name--submit">
                    <a class="btn btn-secondary" @click="onSave()">
                        save
                    </a>
                </div>
            </div>
        </div>
    </div>
</template>