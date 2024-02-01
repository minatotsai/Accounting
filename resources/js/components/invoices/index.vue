<script setup>
import axios from "axios";
import { onMounted, ref } from "vue";
import { useRouter } from "vue-router";

const router = useRouter()

    let companies = ref([])
    let searchCompanies = ref([])

    onMounted(async () => {
        getCompanies();
    })

    const getCompanies = async() => {
        let response = await axios.get("/api/get_all_companies_index")
        //console.log('response', response)
        companies.value = response.data.companies
    }

    const search = async () => {
        let response = await axios.get('/api/search_companies?s=' + searchCompanies.value)
        //console.log('response', response.data.companies)
        companies.value = response.data.companies
    }

    const newCompany = async () => {
        //let companies = await axios.get("/api/get_all_companies")
        //console.log('companies', companies.data)
        router.push('/company/newCompany')
    }

    const newOrder = async () => {
        //let companies = await axios.get("/api/get_all_companies")
        //console.log('companies', companies.data)
        router.push('/company/newOrder')
    }

    const onShow = (id) => {
        router.push('/companyOrders/show/' + id)
    }

    const onUpdate = (id) => {
        router.push('/company/update/' + id)
    }

</script>

<template>
    <div class="container">
        <div class="invoices">
        
            <div class="card__header">
                <div>
                    <h2 class="invoice__title">Companies</h2>
                </div>
                <div>
                    <a class="btn btn-secondary" @click="newCompany">
                        New Company
                    </a>
                    <a class="btn btn-secondary" @click="newOrder">
                        New Order
                    </a>
                </div>
            </div>

            <div class="table card__content">
                <div class="table--filter">
                    <span class="table--filter--collapseBtn ">
                        <i class="fas fa-ellipsis-h"></i>
                    </span>
                    <div class="table--filter--listWrapper">
                        <ul class="table--filter--list">
                            <li>
                                <p class="table--filter--link table--filter--link--active">
                                    All
                                </p>
                            </li>
                            <li>
                                <p class="table--filter--link ">
                                    Paid
                                </p>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="table--search">
                    <div class="table--search--wrapper">
                        <select class="table--search--select" name="" id="">
                            <option value="">Filter</option>
                        </select>
                    </div>
                    <div class="relative">
                        <i class="table--search--input--icon fas fa-search "></i>
                        <input class="table--search--input" type="text" placeholder="Search company"
                        v-model="searchCompanies" @keyup="search()">
                    </div>
                </div>

                <div class="table--heading">
                    <p>ID</p>
                    <p>Name</p>
                    <p>Status</p>
                    <p>Update</p>
                </div>

                <!-- item 1 -->
                <div class="table--items" v-for="item in companies" :key="item.id" v-if="companies.length > 0">
                    <a href="#" @click="onShow(item.id)">
                        #{{item.id}}
                    </a>
                    <p>{{item.name}}</p>
                    <p v-if="item.status === 1">開啟</p>
                    <p v-else="item.status=== 0" class="status--close">關閉</p>
                    <a href="#" class="btn btn-warning" @click="onUpdate(item.id)">
                        編輯
                    </a>
                </div>
                <div class="table--items" v-else>
                    <p>Companies not found</p>

                </div>
            </div>
        
        </div>
    </div>
</template>