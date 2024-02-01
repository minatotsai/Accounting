<script setup>
    import axios from 'axios'
    import { onMounted, ref } from "vue"
    import { useRouter } from 'vue-router'

    let form = ref({ id:'' })
    let total = ref(0)

    let year = ref([])
    let month = ref([])
    let day = ref([])
    let getToday = ref([])
    const router = useRouter()

    const props = defineProps({
        id:{
            type:String,
            default:''
        }
    })

    onMounted(async () => {
        getCompanyOrder()
    });

    const getCompanyOrder = async () => {
        let response = await axios.get(`/api/show_companyOrder/${props.id}`);
        console.log('form',response.data.order.contents);
        form.value = response.data.order
        if(response.data.order.contents)
            subTotal(response.data.order.contents)
    }

    const subTotal = (form) => {
        // let sub = 0;
        total.value = form.reduce((accumulater, item) => {
            return accumulater + parseInt(item.amount)
        }, 0);
        // console.log(total);
        return total;
    }

    const print = () => {
        window.print()
    }

    const main = () => {
        router.push('/')
    }

    const search = async() => {
        // console.log(year.value , month.value, day.value)
        year.value = removeNumber(year.value, 4)
        month.value = removeNumber(month.value, 2)
        day.value = removeNumber(day.value, 2)
        // console.log("year",year.value, "month", month.value, "day", day.value)
        if(year.value == undefined || year.value == ''){
            year.value = 0;
        }
        if(month.value == undefined || month.value == ''){
            month.value = 0;
        }
        if(day.value == undefined || day.value == ''){
            day.value = 0;
        }
        let response = await axios.get('/api/show_companyOrder_limit?s='+ props.id + '&y=' + year.value + '&m=' + month.value + '&d=' + day.value)
        // console.log('response', response.data.order.contents)
        form.value = response.data.order
        if(response.data.order.contents)
            subTotal(response.data.order.contents)
    }

    const deleteItem = (id) => {
        axios.get('/api/delete_companyOrder/'+ id)
        getCompanyOrder()
    }

    const removeNumber = ( oldNumber, limit ) => {
        let newNumber = oldNumber.toString().replace(/\D/g,'')
        if(newNumber.length > limit){
            newNumber = newNumber.slice(0 ,limit)
        }
        return newNumber
    }

</script>


<template>
    <div class="container">
        <div class="invoices">

            <!-- <div class="card__header">
                <div>
                    <h2 class="invoice__title">商店名稱: </h2>
                </div>
                <div>

                </div>
            </div> -->
            <div>
                <div class="card__header--title ">
                    <h1 class="mr-2">#{{ form.id }} {{ form.name }}</h1>
                </div>

                <div>
                    <ul class="card__header-list">
                        <li>
                            <!-- Select Btn Option -->
                            <button class="selectBtnFlat" @click="print()">
                                <i class="fas fa-print"></i>
                                Print
                            </button>
                            <!-- End Select Btn Option -->
                        </li>
                        <li>
                            <!-- Select Btn Option -->
                            <button class="selectBtnFlat" @click="main()">
                                <i class=" fas fa-reply"></i>
                                Home
                            </button>
                            <!-- End Select Btn Option -->
                        </li>
                        <!-- <li> -->
                            <!-- Select Btn Option -->
                            <!-- <button class="selectBtnFlat ">
                                <i class=" fas fa-pencil-alt"></i>
                                Delete
                            </button> -->
                            <!-- End Select Btn Option -->
                        <!-- </li> -->

                    </ul>
                </div>
            </div>

            <div class="table invoice">
                <!-- <div class="logo">
                    <img src="assets/img/logo.png" alt="" style="width: 200px;">
                </div> -->
                <div class="invoice__header--title">
                    <p></p>
                    <p class="invoice__header--title-1">訂單</p>
                    <p></p>
                </div>

                <div class="table--search">
                    <div class="table--search--wrapper">
                        <select class="table--search--select" name="" id="">
                            <option value="">Filter</option>
                        </select>
                    </div>
                    <div class="input-text">
                        <i class="table--search--input--icon fas fa-search "></i>
                        <input class="table--search--input" type="number" placeholder="Search year"
                        v-model="year" @keyup="search">
                        <i class="table--search--input--icon fas fa-search "></i>
                        <input class="table--search--input" type="number" placeholder="Search month"
                        v-model="month" @keyup="search">
                        <i class="table--search--input--icon fas fa-search "></i>
                        <input class="table--search--input" type="number" placeholder="Search day"
                        v-model="day" @keyup="search">
                    </div>
                </div>
                <!-- <div class="invoice__header--item">
                    <div>
                        <h2>Invoice To:</h2>
                        <p>Customer 1</p>
                    </div>
                    <div>
                        <div class="invoice__header--item1">
                            <p>Invoice#</p>
                            <span>#1200</span>
                        </div>
                        <div class="invoice__header--item2">
                            <p>Date</p>
                            <span>12/12/2022</span>
                        </div>
                        <div class="invoice__header--item2">
                            <p>Due Date</p>
                            <span>12/12/2022</span>
                        </div>
                        <div class="invoice__header--item2">
                            <p>Reference</p>
                            <span>1045</span>
                        </div>

                    </div>
                </div> -->

                <div class="table py1">

                    <div class="table--heading3">
                        <!-- <p>#</p> -->
                        <p>訂單名稱</p>
                        <p>金額</p>
                        <p>數量</p>
                        <p>總計</p>
                        <p>訂單時間</p>
                        <p>刪除</p>
                    </div>

                    <!-- item 1 -->
                    <div class="table--items3" v-for="(item,i) in form.contents" :key="item.id">
                        <!-- <p>{{ item.id }}</p> -->
                        <p>{{ item.product.p_name }}</p>
                        <p>{{ item.price }}</p>
                        <p>{{ item.quantity }}
                        <span v-if="item.product.p_type">
                            公斤
                        </span>
                        <span v-else>
                            支/隻
                        </span>
                        </p>
                        <p>{{ item.amount }}</p>
                        <p>{{ item.up_at }}</p>
                        <!-- <a href="#" @click="updateItem(item.id)" class="btn btn-info">
                            編輯
                        </a> -->
                        <a href="#" @click="deleteItem(item.id)" class="btn btn-danger">
                            刪除
                        </a>
                    </div>
                    <!-- <div class="table--items3">
                        <p class="table--items--col2">
                            2
                        </p>
                        <p class="table--items--col1 table--items--transactionId3">
                            Lorem Ipsum is simply dummy text
                        </p>
                        <p class="table--items--col2">
                            $ 300
                        </p>
                        <p class="table--items--col3">
                            1
                        </p>
                        <p class="table--items--col5">
                            $ 300
                        </p>
                    </div>
                    <div class="table--items3">
                        <p class="table--items--col2">
                            3
                        </p>
                        <p class="table--items--col1 table--items--transactionId3">
                            Lorem Ipsum is simply dummy text
                        </p>
                        <p class="table--items--col2">
                            $ 300
                        </p>
                        <p class="table--items--col3">
                            1
                        </p>
                        <p class="table--items--col5">
                            $ 300
                        </p>
                    </div>
                    <div class="table--items3">
                        <p class="table--items--col2">
                            4
                        </p>
                        <p class="table--items--col1 table--items--transactionId3">
                            Lorem Ipsum is simply dummy text
                        </p>
                        <p class="table--items--col2">
                            $ 300
                        </p>
                        <p class="table--items--col3">
                            1
                        </p>
                        <p class="table--items--col5">
                            $ 300
                        </p>
                    </div> -->
                </div>

                <!-- <div class="invoice__subtotal">
                    <div>
                        <h2>Thank you for your business</h2>
                    </div>
                    <div>
                        <div class="invoice__subtotal--item1">
                            <p>Sub Total</p>
                            <span> $ 1200</span>
                        </div>
                        <div class="invoice__subtotal--item2">
                            <p>Discount</p>
                            <span>$ 100</span>
                        </div>

                    </div>
                </div> -->

                <hr>

                <div class="invoice__total">
                    <div>
                        <h2>訂單總和</h2>
                        <!-- <p>目前所有商品的加總. </p> -->
                    </div>
                    <div>
                        <div class="grand__total">
                            <div class="grand__total--items">
                                <p>Total</p>
                                <span>$ {{ total }}</span>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</template>