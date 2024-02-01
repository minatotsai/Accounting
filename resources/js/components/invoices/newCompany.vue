<script setup>
import axios from "axios";
import { onMounted, ref } from "vue"
import { useRouter } from 'vue-router'

let company = ref([])

let router = useRouter()

const onSave = () => {
    if(company.value.length >=1){
        // csrf = document.head.querySelector('meta[name="csrf-token"]').getAttribute('content');
        const formData = new FormData()
        // console.log(company.value)
        formData.append('company_name', company.value);
        // console.log(formData.entries());
        axios.post("/api/add_company", formData).then(response => {
            router.push("/")
        }).catch(error => {
            if(error.response){
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
                <span class="item--company--name--span">Set Company Name: </span>
            <p>
                <input type="text" class="input item--company--name--input" v-model="company">
            </p>
            </div>
            <div class="card__footer">
                <div class="item--company--name--submit">
                    <a class="btn btn-secondary" @click="onSave()">
                        submit
                    </a>
                </div>
            </div>
        </div>  
    </div>
</template>