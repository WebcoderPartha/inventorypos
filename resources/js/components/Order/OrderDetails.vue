<template>
    <div>
        <div class="row">
            <div class="col-md-12 text-center"><h2>Order Details</h2></div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">Customer Details</div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <ul class="list-group">
                                <li class="list-group-item">Customer Name: <b class="float-right">{{ orders.customer.customer_name }}</b></li>
                                <li class="list-group-item">Customer Email: <b class="float-right">{{ orders.customer.customer_email }}</b></li>
                                <li class="list-group-item">Customer Phone: <b class="float-right">{{ orders.customer.customer_phone }}</b></li>
                                <li class="list-group-item">Customer Address: <b class="float-right">{{ orders.customer.customer_address }}</b></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">Order Details</div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <ul class="list-group">
                                <li class="list-group-item">Paid: <b class="float-right">Tk.{{ orders.advance }}</b></li>
                                <li class="list-group-item">Due: <b class="float-right">Tk.{{ orders.due }}</b></li>
                                <li class="list-group-item">Total Quantity: <b class="float-right">{{ orders.total_qty }}</b></li>
                                <li class="list-group-item">Subtotal: <b class="float-right">Tk.{{ orders.total_subtotal }}</b></li>
                                <li class="list-group-item">Vat: <b class="float-right">{{ orders.vat }}%</b></li>
                                <li class="list-group-item">Total: <b class="float-right">T{{ orders.total }}</b></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-5">
            <div class="col-md-12">
                <div class="card">
                    <div class="table-responsive">
                        <table class="table align-items-center table-flush">
                            <thead class="thead-dark">
                            <tr>
                                <th>Product Name</th>
                                <th>Product Code</th>
                                <th>Qty</th>
                                <th>Price</th>
                                <th>Sub Total</th>
                                <th>Image</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="order_detail in order_details" :key="order_detail.id">
                                <td>{{ order_detail.product.product_name }}</td>
                                <td>{{ order_detail.product.product_code }}</td>
                                <td>{{ order_detail.product_qty }}</td>
                                <td>Tk.{{ order_detail.product_price }}</td>
                                <td>Tk.{{ order_detail.product_subtotal }}</td>
                                <td><img :src="'/'+order_detail.product.image" width="60" alt=""></td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "OrderDetails",
    created(){
        if (!User.loggedIn()){
            this.$router.push({ name: 'Login' });
        }
        this.getOrder();
        this.getOrderDetails();
    },
    data(){
        return {
            orders: {
                customer: {
                    customer_name: ''
                }
            },
            order_details: {}
        }
    },
    methods:{
        getOrder(){
           let id = this.$route.params.id;
            axios.get('/api/auth/singleorder/'+id)
                .then(response => {
                    this.orders = response.data;
            })
        },
        getOrderDetails(){
            let id = this.$route.params.id;
            axios.get('/api/auth/order-details/'+id)
                .then(response => {
                    this.order_details = response.data;
            })
        }
    }
}
</script>

<style scoped>

</style>
