<template>
    <div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Supplier List</h6>
                        <div class="form-group">
                            <input type="text" v-model="searchTerm" class="form-control" placeholder="Search Supplier">
                        </div>
                        <router-link class="btn btn-info" :to="{ name: 'AddSupplier' }">+</router-link>
                    </div>
                    <div class="table-responsive">
                        <table class="table align-items-center table-flush">
                            <thead class="thead-light">
                            <tr>
                                <th>SL</th>
                                <th>Supplier Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Address</th>
                                <th>Shop Name</th>
                                <th>Photo</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="(supplier,index) in SupplierSeach" :key="suppliers.id">
                                <td>{{ index + 1 }}</td>
                                <td>{{ supplier.name }}</td>
                                <td>{{ supplier.email }}</td>
                                <td>{{ supplier.phone }}</td>
                                <td>{{ supplier.address }}</td>
                                <td>{{ supplier.shopname }}</td>
                                <td v-if="supplier.photo"><img :src="imagePath(supplier.photo)" alt="" width="60px" height="60px"></td>
                                <td v-else></td>
                                <td><router-link :to="{ name: 'EditSupplier', params: {id : supplier.id} }" class="btn btn-info"><i class="fa fa-edit"></i></router-link>
                                    <button @click.prevent="deleteSupplierById(supplier.id)" class="btn btn-danger"><i class="fa fa-trash-alt"></i></button></td>
                                <!--                                <td><span class="badge badge-success">Delivered</span></td>-->
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer"></div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "SupplierList",
    data(){
        return {
            suppliers   : [],
            searchTerm  : ''
        }
    },
    created() {
        if (!User.loggedIn()){
            this.$router.push({ name: 'Login' });
            Notification.Warning('<b>Not allowed! Please login first!</b>');
        }
        this.suppliersShow()
    },
    computed: {
        SupplierSeach(){
            return this.suppliers.filter(supplier => {
                if (supplier.name.match(this.searchTerm)){
                    return supplier.name.match(this.searchTerm);
                }else if(supplier.email.match(this.searchTerm)){
                    return supplier.email.match(this.searchTerm);
                }else if(supplier.phone.match(this.searchTerm)){
                    return supplier.phone.match(this.searchTerm);
                }else if(supplier.address.match(this.searchTerm)){
                    return supplier.address.match(this.searchTerm);
                }else if(supplier.shopname.match(this.searchTerm)){
                    return supplier.shopname.match(this.searchTerm);
                }
            })
        }
    },
    methods: {
        suppliersShow(){
            axios.get('/api/auth/supplier').then(response => {
                this.suppliers = response.data;
            }).catch(error => {

            })
        },
        imagePath(value){
            return '/'+value;
        },
        deleteSupplierById(id){
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
                    axios.delete('/api/auth/supplier/'+id)
                        .then(response => {
                            this.suppliers = this.suppliers.filter(supplier => {
                                    return supplier.id != id;
                            });
                            Swal.fire(
                                'Deleted!',
                                response.data,
                                'success'
                            )
                        }).catch(error => {

                    })
                }
            })
        }
    }
}
</script>

<style scoped>

</style>
