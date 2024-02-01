import { createRouter, createWebHistory } from "vue-router";

import invoiceIndex from '../components/invoices/index.vue';
import companyNewCompany from '../components/invoices/newCompany.vue';
import companyNewOrder from '../components/invoices/newOrder.vue';
import orderShow from '../components/invoices/show.vue';
import companyEdit from '../components/invoices/edit.vue';


import notFound from '../components/NotFound.vue';

const routes = [
    {
        path:'/',
        component: invoiceIndex
    },
    {
        path:'/company/newcompany',
        component: companyNewCompany
    },
    {
        path:'/company/newOrder',
        component: companyNewOrder
    },
    {
        path:'/companyOrders/show/:id',
        component: orderShow,
        props:true
    },
    {
        path: '/company/update/:id',
        component: companyEdit,
        props: true
    },
    {
        path: '/:pathMatch(.*)*',
        component: notFound
    }
]

const router = createRouter({
    history: createWebHistory(),
    routes
})

export default router;