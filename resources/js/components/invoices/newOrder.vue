<script setup>
    import axios from 'axios';
    import { isReadonly, onMounted, ref } from 'vue';
    import { useRouter } from "vue-router"

    const router = useRouter()

    let form = ref([]);
    let companies = ref([]);
    //let allCompany = ref = ([])
    let company_id = ref([]);
    let allProducts = ref([]);
    let listCart = ref([]);
    let day = ref([])

    const showModal = ref(false);
    const hideModal = ref(true);

    onMounted(async () => {
        getAllCompanies();
        getAllProducts();
    })

    const getAllCompanies = async() => {
        let response = await axios('/api/get_all_companies')
        //console.log('compaines', response.data)
        companies.value = response.data.companies;
        day.value = response.data.today;
    }

    const getAllProducts = async() => {
        let response = await axios.get('/api/get_all_products')
        //console.log('products', response.data)
        allProducts.value = response.data.products;
    }

    const addCart = (product) => {
        const productCart = {
            id : product.id,
            p_name : product.p_name,
            p_price : product.p_price,
            p_type : product.p_type,
            quantity : product.quantity
        }
        listCart.value.push(productCart);
        closeModal();
    }

    const removeProduct = (i) => {
        listCart.value.splice(i,1);
    }

    const openModel = () => {
        showModal.value = !showModal.value;
    }

    const closeModal = () => {
        showModal.value = !hideModal.value;
    }

    const subTotal = () => {
        let total = 0
        listCart.value.map((data)=>{
          total = total + (data.quantity*data.p_price);
        })
        return total;
    }
   
    const onSave = () => {
        if(listCart.value.length >=1){
            const formData = new FormData()
            formData.append('items', JSON.stringify(listCart.value));
            formData.append('company_id', company_id.value);
            formData.append('date', day.value);
            formData.append('terms_and_conditions', form.value.terms_and_conditions);
            //console.log(formData.entries());
            // console.log("data", day.value);
            axios.post("/api/add_content", formData)
            .then((response) => {
                if(response.status === 200){
                    listCart.value = []
                    alert('insert success')
                    router.push("/")
                }

            }).catch(function (error){
                if(error.response){
                    // console.log("error response",error.response)
                    console.log("error message:",error.response.data.message)
                    console.log("error status",error.response.status)
                }
            });
            // for (var pair of formData.entries())
            //     {
            //     console.log(pair[0]+ ', '+ pair[1]); 
            // }
        }
    }
    
    

</script>
<template>
    <div class="container">
        <div class="invoices">

            <div class="card__header">
                <div>
                    <h2 class="invoice__title">New Company</h2>
                </div>
                <div>

                </div>
            </div>

            <div class="card__content">
                <div class="card__content--header">
                    <div>
                        
                        <p class="my-1">Company Name</p>
                        <!-- <input type="text" class="input" v-if="companies.length > 0"> -->
                        <div v-if="companies.length > 0">
                            <select name="" id="" class="input" v-model="company_id">
                            <option disabled>選擇店家</option>
                            <option :value="company.id" v-for="company in companies">
                                {{ company.name }}
                            </option>
                        </select>
                        </div>
                        <div v-else>
                            <h2>目前尚無任何店家,請先新增店家</h2>
                        </div>
                        
                    </div>
                    <div>
                        <p class="my-1">設定日期</p>
                        <input id="date" placeholder="dd-mm-yyyy" type="date" class="input" v-model="day">
                    </div>
                    <!-- <div>
                        <p class="my-1">Numero</p>
                        <input type="text" class="input">
                        <p class="my-1">Reference(Optional)</p>
                        <input type="text" class="input">
                    </div> -->
                </div>
                <br><br>
                <div class="table">

                    <div class="table--heading2">
                        <p>物品名稱</p>
                        <p>金額</p>
                        <p>數量</p>
                        <p>單位</p>
                        <p>總金額</p>
                        <p></p>
                    </div>

                    <!-- item 1 -->
                    <div class="table--items2" v-for="(productcart, i) in listCart" :key="productcart.id">
                        <p> {{ productcart.p_name }} </p>
                        <p>
                            <input type="text" class="input" v-model="productcart.p_price" v-bind:readonly="isReadonly">
                        </p>
                        <p>
                            <input type="number" class="input" v-model="productcart.quantity">
                        </p>
                        <p v-if="productcart.p_type">
                            公斤
                        </p>
                        <p v-else>
                            支/隻
                        </p>
                        <p v-if="productcart.quantity">
                            $ {{ (productcart.p_price)  *  (productcart.quantity) }}
                        </p>
                        <p v-else>
                            $ 0
                        </p>
                        <p style="color: red; font-size: 24px;cursor: pointer;" @click="removeProduct(i)">
                            &times;
                        </p>
                    </div>
                    <div style="padding: 10px 30px !important;">
                        <button class="btn btn-sm btn__open--modal" @click="openModel()">新增品項</button>
                    </div>
                </div>

                <div class="table__footer">
                    <div class="document-footer">
                        <p>Terms and Conditions</p>
                        <textarea cols="50" rows="7" class="textarea" v-model="form.terms_and_conditions"></textarea>
                    </div>
                    <div>
                        <div class="table__footer--subtotal">
                            <p>Total</p>
                            <span>$ {{ subTotal() }}</span>
                        </div>
                        <!-- <div class="table__footer--total">
                            <p>Grand Total</p>
                            <span>$ {{ total() }}</span>
                        </div> -->
                    </div>
                </div>


            </div>
            <div class="card__header" style="margin-top: 40px;">
                <div>

                </div>
                <div>
                    <a class="btn btn-secondary" @click="onSave()">
                        送出
                    </a>
                </div>
            </div>

        </div>
        <!--==================== add modal items ====================-->
        <div class="modal main__modal " :class="{ show:showModal }">
            <div class="modal__content">
                <span class="modal__close btn__close--modal" @click="closeModal()">×</span>
                <h3 class="modal__title">Add Item</h3>
                <hr><br>
                <div class="modal__items" v-if="allProducts.length > 0">
                    <ul style="list-style: none;">
                        <li v-for="(product, i) in allProducts" :key="product.id" style="display: grid;grid-template-columns: 30px 250px 15px;align-items: center;padding-bottom: 5;">
                            <p>{{ i+1 }}</p>
                            <a href="#">{{ product.p_name }}</a>
                            <button @click="addCart(product)" style="border: 1px solid #e0e0e0;width:35px;height: 35px;cursor: pointer;">
                            +
                            </button>
                        </li>
                    </ul>
                    
                </div>
                <div class="modal__items" v-else>
                    <h1>尚無任何品項可新增,請先新增品項</h1>
                </div>
                <br>
                <hr>
                <div class="model__footer">
                    <button class="btn btn-light mr-2 btn__close--modal" @click="closeModal()">
                        取消
                    </button>
                    <button class="btn btn-light btn__close--modal">確定</button>
                </div>
            </div>
        </div>
    </div>
</template>