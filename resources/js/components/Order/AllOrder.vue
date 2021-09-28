<template>
    <div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">All Order List</h6>
                        <div class="form-group">
                            <input type="text" class="form-control" placeholder="Search">
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table align-items-center table-flush">
                            <thead class="thead-light">
                            <tr>
                                <th>Date</th>
                                <th>Customer Name</th>
                                <th>Paid</th>
                                <th>Due</th>
                                <th>Pay By</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="(order,index) in orders" :key="index">
                                <td>{{ order.order_date }}</td>
                                <td>{{ order.customer.customer_name }}</td>
                                <td>Tk.{{ order.advance }}</td>
                                <td>Tk.{{ order.due }}</td>
                                <td>{{ order.pay_by }}</td>
                                <td><router-link :to="{name: 'OrderDetails', params:{id:order.id}}" class="btn btn-info"><i class="fa fa-eye"></i></router-link></td>
                                <!--                                    <button class="btn btn-danger"><i class="fa fa-trash-alt"></i></button></td>-->
                                <!--                                                                <td><span class="badge badge-success">Delivered</span></td>-->
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
name: "AllOrder",
    created() {
        if (!User.loggedIn()){
            this.$router.push({ name: 'Login' });
        }
        this.getAllOrder();
    },
    data() {
        return {
            orders: {},
        }
    },
    methods:{
        getAllOrder(){
            axios.get('/api/auth/getallorder')
                .then(response => {
                    this.orders = response.data
            })
        }
    }
}
</script>

<style scoped>

</style>
