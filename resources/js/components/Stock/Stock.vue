<template>
    <div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Product List</h6>
                        <div class="form-group">
                            <input type="text" class="form-control" placeholder="Search Product">
                        </div>
                        <router-link class="btn btn-info" :to="{ name: 'AddProduct' }">+</router-link>
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
                            <tr v-for="product in products" :key="product.id">
                                <td>{{ product.product_code }}</td>
                                <td>{{ product.product_name }}</td>
                                <td>{{ product.category ? product.category.category_name : 'n/a' }}</td>
                                <td>{{ product.quantity ? product.quantity : 'n/a' }}</td>
                                <td v-if="product.quantity >= 1"><span class="badge badge-success"><strong>Stock Available</strong></span></td>
                                <td v-else><span class="badge badge-danger"><b>Stock Out</b></span></td>
                                <td v-if="product.image"><img :src="imagePath(product.image)" width="80" alt=""></td>
                                <td v-else></td>
                                <td><router-link :to="{ name: 'EditStock', params:{id:product.id} }" class="btn btn-info"><i class="fa fa-edit"></i></router-link></td>
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
    name: "Stock",
    data(){
        return {
            products: {},

        }
    },
    created() {
        if (!User.loggedIn()){
            this.$router.push({ name: 'Login' });
            Notification.Warning('<b>Not allowed! Please login first!</b>');
        }
        this.fetchAllProduct();
    },
    methods: {
        fetchAllProduct(){
            axios.get('/api/auth/product')
                .then(response => {
                    this.products = response.data
                })
        },
        imagePath(value){
            return '/'+value;
        },
        deleteProductById(id){
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    axios.delete('/api/auth/product/'+id).then(response => {
                        this.products = this.products.filter(product => {
                            return product.id != id;
                        })
                        Swal.fire(
                            'Deleted!',
                            '<b>'+response.data+'</b>',
                            'success'
                        )
                    })
                }
            })
        }
    }
}
</script>

<style scoped>

</style>
