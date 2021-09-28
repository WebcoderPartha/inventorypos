<template>
    <div>
        <div class="row mb-3">
            <!-- Earnings (Monthly) Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-uppercase mb-1">Today Sale</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">Tk: {{ today_sale }}</div>
                                <div class="mt-2 mb-0 text-muted text-xs">
                                    <span class="text-success mr-2"><i class="fa fa-arrow-up"></i> 3.48%</span>
                                    <span>Since last month</span>
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-calendar fa-2x text-primary"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Earnings (Annual) Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-uppercase mb-1">Today Income</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">Tk: {{ today_income }}</div>
                                <div class="mt-2 mb-0 text-muted text-xs">
                                    <span class="text-success mr-2"><i class="fas fa-arrow-up"></i> 12%</span>
                                    <span>Since last years</span>
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-shopping-cart fa-2x text-success"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- New User Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-uppercase mb-1">Tody Due</div>
                                <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">Tk: {{ today_due }}</div>
                                <div class="mt-2 mb-0 text-muted text-xs">
                                    <span class="text-success mr-2"><i class="fas fa-arrow-up"></i> 20.4%</span>
                                    <span>Since last month</span>
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-users fa-2x text-info"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Pending Requests Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-uppercase mb-1">Today Expense</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">Tk: {{ today_expense }}</div>
                                <div class="mt-2 mb-0 text-muted text-xs">
                                    <span class="text-danger mr-2"><i class="fas fa-arrow-down"></i> 1.10%</span>
                                    <span>Since yesterday</span>
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-comments fa-2x text-warning"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Stock Out Product List</h6>
                    </div>
                    <div class="table-responsive">
                        <table class="table align-items-center table-flush">
                            <thead class="thead-light">
                            <tr>
                                <th>Product Code</th>
                                <th>Product Name</th>
                                <th>Category</th>
                                <th>Qty</th>
                                <th>Status</th>
                                <th>Image</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="product in stockout_product" :key="product.id">
                                <td>{{ product.product_code }}</td>
                                <td>{{ product.product_name }}</td>
                                <td>{{ product.category ? product.category.category_name : 'n/a' }}</td>
                                <td>{{ product.quantity ? product.quantity : 'n/a' }}</td>
                                <td v-if="product.quantity >= 1"><span class="badge badge-success"><strong>Stock Available</strong></span></td>
                                <td v-else><span class="badge badge-danger"><b>Stock Out</b></span></td>
                                <td v-if="product.image"><img :src="'/'+product.image" width="80" alt=""></td>
                                <td v-else></td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer">

                    </div>
                </div>
            </div>
        </div>
        <!--Row-->

    </div>
</template>

<script>
export default {
    name: "Dashboard",
    created() {
        if (!User.loggedIn()){
            this.$router.push({ name: 'Login' })
        }
        this.todaySale();
        this.todayIncome();
        this.todayDue();
        this.todayExpense();
        this.getStockOutProduct();
    },
    data(){
        return {
            today_sale          : '',
            today_income        : '',
            today_due           : '',
            today_expense       : '',
            stockout_product    : {}
        }
    },
    methods: {
        todaySale(){
            axios.get('api/auth/todady-sale')
                .then(response => {
                    this.today_sale = response.data
            })
        },
        todayIncome(){
            axios.get('/api/auth/todady-income')
                .then(response => {
                    this.today_income = response.data
            })
        },
        todayDue(){
            axios.get('/api/auth/todady-due')
                .then(response => {
                    this.today_due = response.data
            })
        },
        todayExpense(){
            axios.get('/api/auth/todady-expense')
                .then(response => {
                    this.today_expense = response.data
            })
        },
        getStockOutProduct(){
            axios.get('/api/auth/getstockoutproducts')
                .then(response => {
                    this.stockout_product = response.data;
            })
        }
    }
}
</script>

<style scoped>

</style>
