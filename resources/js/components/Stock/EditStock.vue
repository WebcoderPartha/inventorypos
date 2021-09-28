<template>
    <div>
        <div class="row">
            <div class="col-6 mx-auto">
                <div class="card mb-4">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Update Stock</h6>
                        <router-link class="btn btn-info" :to="{ name: 'Stock' }">Back</router-link>
                    </div>
                    <div class="card-body">
                        <form @submit.prevent="updateStockById()">
                            <div class="form-group">
                                <div class="form-row">
                                    <div class="col-6">
                                        <label for="product_name">Product Name</label>
                                        <input type="text" class="form-control" v-model="form.product_name" id="product_name" disabled>
                                    </div>
                                    <div class="col-6">
                                        <label for="name">Product Stock</label>
                                        <input type="text" class="form-control" v-model="form.quantity" id="name" placeholder="Enter product name">
                                        <span v-if="errors ? errors.quantity : ''" class="text-danger"><b><small>{{ errors.quantity[0] }}</small></b></span>
                                    </div>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary">Update Stock</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "EditProduct",
    data(){
        return {
            form: {
                quantity        : '',
            },
            errors              : {}
        }
    },
    created() {
        if (!User.loggedIn()){
            this.$router.push({ name: 'Login' });
            Notification.Warning('<b>Not allowed! Please login first!</b>');
        }
        this.getProductById();
    },
    methods:{
        // Get Product By ID
        getProductById(){
            let id = this.$route.params.id;
            axios.get('/api/auth/product/'+id)
                .then(response =>{
                    this.form = response.data;
                })
        },

        // Update Product By Id
        updateStockById(){
            let id = this.$route.params.id;
            axios.put('/api/auth/stockupdate/'+id, this.form)
                .then(response => {
                    this.$router.push({ name: 'Stock' });
                    Notification.Success("<b>"+response.data+"</b>");
                }).catch(error => {
                this.errors = error.response.data.errors;
                Notification.Error("<b>Something went wrong!</b>");
            })
        },

    }

}
</script>

<style scoped>

</style>
