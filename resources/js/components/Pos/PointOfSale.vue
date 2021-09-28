<template>
    <div>
        <div class="row mb-3">
            <!-- Earnings (Monthly) Card Example -->

            <div class="col-xl-7 col-lg-7">
                <div class="card mb-4">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Expense Insert</h6>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table align-items-center table-flush">
                                <thead class="thead-light">
                                <tr>
                                    <th>Name</th>
                                    <th>Qty</th>
                                    <th>Unit</th>
                                    <th>Total</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="cart in getcarts">
                                    <td>{{ cart.product_name }}</td>
                                    <td style="width: 99px;padding: 4px;text-align: center;">
                                        <button v-if="cart.product_quantity >= 2" @click.prevent="decrementCart(cart.id)" class="btn btn-sm btn-danger">-</button>
                                        <button v-else class="btn btn-sm btn-danger" disabled>-</button>
                                            <input readonly type="text" style="width: 24px" :value="cart.product_quantity">
                                        <button class="btn btn-sm btn-success" @click.prevent="incrementCart(cart.id)">+</button></td>
                                    <td>Tk.{{ cart.product_price }}</td>
                                    <td>Tk.{{ cart.product_subtotal }}</td>
                                    <td><a style="color:white" @click.prevent="removeCart(cart.id)" class="btn btn-sm btn-danger">X</a></td>
                                </tr>
                                </tbody>
                            </table>
                        </div>

                    </div>
                    <div class="card m-4">
                        <div class="card-body">
                            <p>Total Quantity: <span class="float-right"><b>{{ cart_details.total_qty }}</b></span></p>
                            <p>Sub Total: <span class="float-right"><b>Tk.{{ cart_details.total_subtial }}</b></span></p>
                            <p>Vat: <span class="float-right"><b>{{ vat.vat }}%</b></span></p>
                            <p>Total: <span class="float-right"><b>Tk.{{ cart_details.total }}</b></span></p>
                        </div>
                    </div>
                    <div class="card m-4">
                        <div class="card-body">
                            <form @submit.prevent="orderDone">
                                <div class="form-group">
                                    <label for="name">Customer Name</label>
                                    <select class="form-control" id="name" v-model="customer_id">
                                        <option value="">Select Customer</option>
                                        <option v-for="customer in customers" :key="customer.id" :value="customer.id">{{ customer.customer_name }}</option>
                                    </select>
                                    <span class="text-danger" v-if="errors ? errors.customer_id : ''"><small>{{ errors.customer_id[0] }}</small></span>
                                </div>
                                <div class="form-group">
                                    <label for="pay">Advance</label>
                                    <input type="text" v-model="advance" @change="calculataPayment" class="form-control" id="pay">
                                    <span class="text-danger" v-if="errors ? errors.advance : ''"><small>{{ errors.advance[0] }}</small></span>
                                </div>

                                <div class="form-group">
                                    <label for="due">Due</label>
                                    <input type="text" v-model="due" class="form-control" id="due">
                                    <span class="text-danger" v-if="errors ? errors.due : ''"><small>{{ errors.due[0] }}</small></span>
                                </div>
                                <div class="form-group">
                                    <label for="payby">Pay By</label>
                                    <select class="form-control" v-model="pay_by" id="payby">
                                        <option value="">Select</option>
                                        <option value="Cheque">Cheque</option>
                                        <option value="Cash">Cash</option>
                                        <option value="Gift Card">Gift Card</option>
                                    </select>
                                    <span class="text-danger" v-if="errors ? errors.pay_by : ''"><small>{{ errors.pay_by[0] }}</small></span>
                                </div>
                                <button type="submit" class="btn btn-success">Pay Now</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-5 col-lg-5">
                <div class="card mb-4">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Products</h6>

                    </div>
                    <div class="card-body">
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <a class="nav-link active" id="home-tab" data-toggle="tab" href="#allproduct" role="tab" aria-controls="allproduct" aria-selected="true">All Product</a>
                            </li>
                            <li class="nav-item" role="presentation" v-for="category in getCategories" :key="category.id">
                                <a class="nav-link" id="profile-tab" data-toggle="tab" href="#categories" role="tab" aria-controls="categories" aria-selected="false" @click="getProductCategoryById(category.id)">{{ category.category_name }}</a>
                            </li>
                        </ul>

                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="allproduct" role="tabpanel" aria-labelledby="home-tab">
                                <div class="form-group mt-2">
                                    <input type="text" v-model="search" class="form-control" placeholder="Search Here">
                                </div>
                                <div class="row">
                                    <div class="col-sm-4 col-4 mt-3" v-for="product in searchAllProduct" :key="product.id">
                                        <a @click="addToCart(product.id)" class="link">
                                            <div class="card">
                                                <span class="card-body p-1">
                                                    <img :src="imagePath(product.image)" width="100%" alt="">
                                                    <p>{{ product.product_name }}</p>
                                                    <p><b>Tk.{{ product.selling_price }}</b></p>
                                                    <h5 v-if="product.quantity >= 1 " class="text-center"><span  class="badge badge-success ">Available ({{product.quantity}})</span></h5>
                                                     <h5 v-else class="text-center"><span class="badge badge-danger ">Stock Out</span></h5>
                                                </span>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="categories" role="tabpanel" aria-labelledby="profile-tab">
                                <div class="form-group mt-2">
                                    <input type="text" v-model="search" class="form-control" placeholder="Search Here">
                                </div>
                                <div class="row">
                                    <div class="col-sm-4 col-4 mt-3" v-for="product in searchCategoryProduct" :key="product.id">
                                        <a @click="addToCart(product.id)" class="link">
                                            <div class="card">
                                                <span class="card-body p-1">
                                                    <img :src="imagePath(product.image)" width="100%" alt="">
                                                    <p>{{ product.product_name }}</p>
                                                    <p><b>Tk.{{ product.selling_price }}</b></p>
                                                    <h5 v-if="product.quantity >= 1 " class="text-center"><span class="badge badge-success ">Available ({{product.quantity}})</span></h5>
                                                    <h5 v-else class="text-center"><span class="badge badge-danger ">Stock Out</span></h5>
                                                </span>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "PointOfSale",
    created() {
        if (!User.loggedIn()){
            this.$router.push({ name: 'Login' });
            Notification.Error("<b>Unauthorized! Please Login First!</b>");
        }
        this.getAllproduct();
        this.getAllCategories();
        this.getProductCategoryById();
        this.getAllCustomer();
        this.getAddToCart();
        Reload.$on('LoadCartProduct', ()=> {
            this.getAddToCart();
            this.getVat();
            this.getDetails();
        });
        this.getVat();
        this.getDetails();
    },
    data(){
        return {
            customer_id     : '',
            due             : '',
            pay_by          : '',
            advance         : '',
            getProducts     : [],
            getCategories   : {},
            categoryProduct : [],
            customers       : {},
            getcarts        : {},
            vat             : '',
            cart_details    : '',
            errors          : {},
            search          : ''
        }
    },
    methods:{
        getAllproduct(){
            axios.get('/api/auth/posgetproducts')
                .then(response => {
                    this.getProducts = response.data;
                })
        },
        getAllCategories(){
          axios.get('/api/auth/getcateries')
              .then(response => {
                  this.getCategories = response.data
              })
        },
        getProductCategoryById(category_id){
            axios.get('/api/auth/getptctby/'+category_id).then(response => {
                this.categoryProduct = response.data;
            })
        },
        imagePath(value){
            return '/'+value;
        },
        getAllCustomer(){
            axios.get('/api/auth/customer')
                .then(response => {
                    this.customers = response.data
            })
        },
        // AddToCart
        addToCart(productId){
            axios.post('/api/auth/addcart/'+productId)
                .then(response => {
                    Reload.$emit('LoadCartProduct');
                    Notification.Success("<b>"+response.data+"</b>");
                })
        },
        getAddToCart(){
            axios.get('/api/auth/getaddcarts')
                .then(response => {

                    this.getcarts = response.data;
                })
        },
        removeCart(cartId){
            axios.delete('/api/auth/remove-cart/'+cartId)
                .then(response => {
                    Reload.$emit('LoadCartProduct');
                    this.getcarts = this.getcarts.filter(cart => {
                        return cart.id != cartId;
                    });
                    Notification.Success("<b>"+response.data+"</b>");
                })
        },
        incrementCart(cartId){
            axios.get('/api/auth/incrementcart/'+cartId)
                .then(response => {
                    Reload.$emit('LoadCartProduct');
                    Notification.Success("<b>"+response.data+"</b>");
                });
        },
        decrementCart(cartId){
            axios.get('/api/auth/decrementcart/'+cartId)
                .then(response => {
                    Reload.$emit('LoadCartProduct');
                    Notification.Success("<b>"+response.data+"</b>");
                });
        },
        getVat(){
            axios.get('/api/auth/vat')
                .then(response => {
                    this.vat = response.data;
                })
        },
        // Total Qty & Total Sub total
        getDetails(){
            axios.get('/api/auth/cartdetails')
                .then(response => {
                    this.cart_details = response.data;
                })
        },
        orderDone(){
            let data = {
                customer_id     : this.customer_id,
                advance         : this.advance,
                due             : this.due,
                pay_by          : this.pay_by,
                total_qty       : this.cart_details.total_qty,
                total_subtotal  : this.cart_details.total_subtial,
                vat             : this.vat.vat,
                total           : this.cart_details.total
            }

            axios.post('/api/auth/order-success',  data)
                .then(response => {
                    Reload.$emit('LoadCartProduct');
                    this.customer_id = ''
                    this.due         = '';
                    this.pay_by      = '';
                    this.advance     = '';
                    Notification.Success("<b>"+response.data+"</b>");
                }).catch(error => {
                    this.errors = error.response.data.errors;
            })
        },
        calculataPayment(){
            let duepayment = this.cart_details.total - this.advance;
            this.due = duepayment;
        }

    },
    computed:{
        searchAllProduct(){
            return this.getProducts.filter(product => {
                if (product.product_name.match(this.search)){
                    return product.product_name.match(this.search);
                } else if (product.product_code.match(this.search)){
                    return product.product_code.match(this.search);
                }
            })
        },
        searchCategoryProduct(){
            return this.categoryProduct.filter(product => {
                if (product.product_name.match(this.search)){
                    return product.product_name.match(this.search);
                } else if (product.product_code.match(this.search)){
                    return product.product_code.match(this.search);
                }
            })
        }
    },
    watch:{
        // getcarts:function(){
        //     return this.getcarts;
        // }
    }
}
</script>

<style scoped>
.link{
    color:#000;
    cursor: pointer !important;
}
.link:hover{
    text-decoration: none;
}
.card-body.p-1 p{
    margin: 0;
    text-align: center;
}
</style>
