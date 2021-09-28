<template>
    <div>
        <div class="row mb-5">
            <div class="col-md-6 m-auto">
                <div class="card">
                    <div class="card-header">
                        <h4 class="text-center" style="font-weight: bold">Order Date</h4>
                    </div>
                    <div class="card-body">
                        <form @submit.prevent="searchOrder">
                            <div class="form-group">
                                <label for="date">Order Date</label>
                                <input type="date" class="form-control" v-model="date">
                                <span v-if="errors ? errors.date : ''" class="text-danger"><small>{{ errors.date[0] }}</small></span>
                            </div>
                            <input class="btn btn-success" type="submit" value="Search">
                        </form>
                    </div>
                </div>
            </div>
        </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                            <h6 class="m-0 font-weight-bold text-primary">Search Order List</h6>
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
name: "SearchOrder",
    created() {
        if (!User.loggedIn()){
            this.$router.push({ name: 'Login' });
        }
    },
    data() {
        return {
            date: '',
            orders:{},
            errors: {}
        }
    },
    methods:{
        searchOrder(){
            let data = {
                date: this.date
            }
            axios.post('/api/auth/search-order', data)
                .then(response => {
                    this.orders = response.data;
                    this.errors = '';
                }).catch(error => {
                    this.errors = error.response.data.errors;
                    Notification.Error("<b>Something Went Wrong!</b>");
            })
        }
    }
}
</script>

<style scoped>

</style>
