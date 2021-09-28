<template>
    <div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header py-3 align-items-center">
                        <h4 class="text-center"><b>Customer Details</b></h4>
                    </div>
                    <div class="table-responsive">
                        <table class="table align-items-center table-flush">
                            <thead class="thead-light">
                            <tr>
                                <th>Customer ID</th>
                                <th>:</th>
                                <th>{{ customer.id }}</th>
                            </tr>
                            <tr>
                                <th>Customer Name</th>
                                <th>:</th>
                                <th>{{ customer.customer_name }}</th>
                            </tr>
                            <tr>
                                <th>Customer Email</th>
                                <th>:</th>
                                <th>{{ customer.customer_email }}</th>
                            </tr>
                            <tr>
                                <th>Customer Phone</th>
                                <th>:</th>
                                <th>{{ customer.customer_phone }}</th>
                            </tr>
                            <tr>
                                <th>Customer Address</th>
                                <th>:</th>
                                <th>{{ customer.customer_address }}</th>
                            </tr>
                            <tr>
                                <th>Customer Photo</th>
                                <th>:</th>
                                <th v-if="customer.customer_photo"><img :src="imagePath(customer.customer_photo)" width="200" alt=""></th>
                                <th v-else><img :src="imagePath('backend/customer/customer.png')" width="200" alt=""></th>
                            </tr>
                            </thead>
                        </table>
                        <div class="text-center p-4">
                            <router-link :to="{name: 'CustomerList' }" class="btn btn-info">Back <i class="fa fa-backward"></i></router-link>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "ViewCustomer",
    mounted() {
        if (!User.loggedIn()){
            this.$router.push({ name: 'Login' });
            Notification.Error("<b>Unauthorized! Please Login First!</b>");
        }
        this.getCustomerById();
    },
    data(){
        return {
            customer: {}
        }
    },
    methods:{
        getCustomerById(){
            let customerId = this.$route.params.id;
            axios.get('/api/auth/customer/'+customerId)
                .then(response => {
                    this.customer = response.data;
                })
        },
        imagePath(value){
            return "/"+value;
        }
    }
}
</script>

<style scoped>

</style>
