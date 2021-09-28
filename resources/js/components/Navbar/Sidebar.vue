<template>
    <span>
        <ul class="navbar-nav sidebar sidebar-light accordion" v-show="$route.path === '/' || $route.path === '/register' || $route.path === '/forget-password' ? false : true" id="accordionSidebar" style="display: none">
        <router-link :to="{ name: 'Dashboard' }" class="sidebar-brand d-flex align-items-center justify-content-center">
            <div class="sidebar-brand-icon">
                <img :src="imagePath('backend/img/logo/logo2.png')">
            </div>
            <div class="sidebar-brand-text mx-3">Admin Panel</div>
        </router-link>

        <hr class="sidebar-divider my-0">
        <li class="nav-item active">
            <router-link class="nav-link" :to="{ name: 'Dashboard' }">
                <i class="fas fa-fw fa-tachometer-alt"></i>
                <span>Dashboards</span></router-link>
        </li>
            <li class="nav-item bg-info">
            <router-link class="nav-link" :to="{ name: 'PointOfSale' }">
                <i class="fas fa-fw fa-tachometer-alt"></i>
                <span class="text-white">POS</span></router-link>
        </li>
<!--        <hr class="sidebar-divider">-->

        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#Employee"
               aria-expanded="true" aria-controls="Employee">
                <i class="far fa-fw fa-window-maximize"></i>
                <span>Employee</span>
            </a>
            <div id="Employee" class="collapse" aria-labelledby="headingBootstrap" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <router-link class="collapse-item" :to="{ name: 'AddEmployee' }">Add Employee</router-link>
                    <router-link class="collapse-item" :to="{ name: 'AllEmployee' }">Employee List</router-link>
                </div>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#Supplier"
               aria-expanded="true" aria-controls="Supplier">
                <i class="far fa-fw fa-window-maximize"></i>
                <span>Supplier</span>
            </a>
            <div id="Supplier" class="collapse" aria-labelledby="headingBootstrap" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <router-link class="collapse-item" :to="{ name: 'AddSupplier' }">Add Supplier</router-link>
                    <router-link class="collapse-item" :to="{ name: 'SupplierList' }">Supplier List</router-link>
                </div>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#category"
               aria-expanded="true" aria-controls="category">
                <i class="far fa-fw fa-window-maximize"></i>
                <span>Category</span>
            </a>
            <div id="category" class="collapse" aria-labelledby="headingBootstrap" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <router-link class="collapse-item" :to="{ name: 'AddCategory' }">Add Category</router-link>
                    <router-link class="collapse-item" :to="{ name: 'CategoryList' }">Category List</router-link>
                </div>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#product"
               aria-expanded="true" aria-controls="product">
                <i class="far fa-fw fa-window-maximize"></i>
                <span>Product</span>
            </a>
            <div id="product" class="collapse" aria-labelledby="headingBootstrap" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <router-link class="collapse-item" :to="{ name: 'AddProduct' }">Add Product</router-link>
                    <router-link class="collapse-item" :to="{ name: 'ProductList' }">Product List</router-link>
                </div>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#expense"
               aria-expanded="true" aria-controls="expense">
                <i class="far fa-fw fa-window-maximize"></i>
                <span>Expense</span>
            </a>
            <div id="expense" class="collapse" aria-labelledby="headingBootstrap" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <router-link class="collapse-item" :to="{ name: 'AddExpense' }">Add Expense</router-link>
                    <router-link class="collapse-item" :to="{ name: 'ExpenseList' }">Expense List</router-link>
                </div>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#Customer"
               aria-expanded="true" aria-controls="Customer">
                <i class="far fa-fw fa-window-maximize"></i>
                <span>Customer</span>
            </a>
            <div id="Customer" class="collapse" aria-labelledby="headingBootstrap" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <router-link class="collapse-item" :to="{ name: 'AddCustomer' }">Add Customer</router-link>
                    <router-link class="collapse-item" :to="{ name: 'CustomerList' }">Customer List</router-link>
                </div>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#salary"
               aria-expanded="true" aria-controls="salary">
                <i class="far fa-fw fa-window-maximize"></i>
                <span>Salary</span>
            </a>
            <div id="salary" class="collapse" aria-labelledby="headingBootstrap" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <router-link class="collapse-item" :to="{ name: 'PayableEmployeeList' }">Payable Salary</router-link>
                    <router-link class="collapse-item" :to="{ name: 'PaidEmployeeList' }">Paid Salary</router-link>
                </div>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#Stock"
               aria-expanded="true" aria-controls="Stock">
                <i class="far fa-fw fa-window-maximize"></i>
                <span>Stock</span>
            </a>
            <div id="Stock" class="collapse" aria-labelledby="headingBootstrap" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <router-link class="collapse-item" :to="{ name: 'Stock' }">Product Stock</router-link>
                </div>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#order"
               aria-expanded="true" aria-controls="order">
                <i class="far fa-fw fa-window-maximize"></i>
                <span>Order</span>
            </a>
            <div id="order" class="collapse" aria-labelledby="headingBootstrap" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <router-link class="collapse-item" :to="{ name: 'Orders' }">Today Order</router-link>
                    <router-link class="collapse-item" :to="{ name: 'AllOrder' }">All Order</router-link>
                    <router-link class="collapse-item" :to="{ name: 'SearchOrder' }">Search Orderr</router-link>
                </div>
            </div>
        </li>
        <li class="nav-item">
            <router-link :to="{name:'Vat'}" class="nav-link collapsed">
                <i class="far fa-fw fa-window-maximize"></i>
                <span>Vat</span>
            </router-link>
        </li>


        <hr class="sidebar-divider">

        <div class="version" id="version-ruangadmin"></div>
    </ul>
    </span>
</template>

<script>
export default {
    name: "Sidebar",
    methods:{
        imagePath(value){
            return '/'+value;
        }
    }
}
</script>

<style scoped>

</style>
