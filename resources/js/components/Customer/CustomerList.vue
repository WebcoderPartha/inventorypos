<template>
    <div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Category List</h6>
                        <div class="form-group">
                            <input type="text" class="form-control" placeholder="Search Customer">
                        </div>
                        <router-link class="btn btn-info" :to="{ name: 'AddCustomer' }">+</router-link>
                    </div>
                    <div class="table-responsive">
                        <table class="table align-items-center table-flush">
                            <thead class="thead-light">
                            <tr>
                                <th>SL</th>
                                <th>Customer Name</th>
                                <th>Customer Email</th>
                                <th>Customer Phone</th>
                                <th>Customer Address</th>
                                <th>Customer Photo</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="(customer,index) in customers" :key="index">
                                <td>{{ index + 1 }}</td>
                                <td>{{ customer.customer_name }}</td>
                                <td>{{ customer.customer_email }}</td>
                                <td>{{ customer.customer_phone }}</td>
                                <td>{{ customer.customer_address }}</td>
                                <td v-if="customer.customer_photo">
                                    <img :src="imagePath(customer.customer_photo)" width="80" alt="">
                                </td>
                                <td v-else><img :src="imagePath('backend/customer/customer.png')" width="80" alt=""></td>
                                <td><router-link :to="{name: 'EditCustomer', params:{id:customer.id}}" class="btn btn-info"><i class="fa fa-edit"></i></router-link>
                                    <button class="btn btn-danger"><i class="fa fa-trash-alt"></i></button>
                                    <router-link :to="{name: 'ViewCustomer', params:{id:customer.id}}" class="btn btn-warning"><i class="fa fa-eye"></i></router-link>
                                </td>
                                <!--                                <td><span class="badge badge-success">Delivered</span></td>-->
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
    name: "CustomerList",
    created() {
        if (!User.loggedIn()){
            this.$router.push({ name: 'Login' });
            Notification.Error("<b>Unauthorized! Please Login First!</b>");
        }
        this.getCustomers();
    },
    data(){
        return {
            customers: {}
        }
    },
    methods:{
        getCustomers(){
            axios.get('/api/auth/customer')
                .then(response => {
                    this.customers = response.data;
                })
        },
        imagePath(value){
            return '/'+value;
        }
    }
}
</script>

<style scoped>

</style>
