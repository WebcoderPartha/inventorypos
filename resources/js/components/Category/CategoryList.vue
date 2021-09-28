<template>
    <div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Category List</h6>
                        <div class="form-group">
                            <input type="text" @keyup="realSearch" class="form-control" v-model="search" placeholder="Search Category">
                        </div>
                        <router-link class="btn btn-info" :to="{ name: 'AddCategory' }">+</router-link>
                    </div>
                    <div class="table-responsive">
                        <table class="table align-items-center table-flush">
                            <thead class="thead-light">
                            <tr>
                                <th>SL</th>
                                <th>Category Name</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="(category,index) in categories.data" :key="index">
                                <td>{{ index + 1 }}</td>
                                <td>{{ category.category_name }}</td>
                                <td><router-link :to="{name: 'EditCategory', params:{id:category.id}}" class="btn btn-info"><i class="fa fa-edit"></i></router-link>
                                    <button @click.prevent="deleteCategoryById(category.id)" class="btn btn-danger"><i class="fa fa-trash-alt"></i></button></td>
                                <!--                                <td><span class="badge badge-success">Delivered</span></td>-->
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer">
                        <pagination align="center" :data="categories" @pagination-change-page="loadCategories"></pagination>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import _ from 'lodash'
import Vue from 'vue';
Vue.component('pagination', require('laravel-vue-pagination'));
export default {

    name: "CategoryList",
    data(){
        return {
            categories  : {},
            search      : ''
        }
    },
    mounted() {
        if (!User.loggedIn()){
            this.$router.push({ name: 'Login' })
        }
        // this.loadCategories();
        this.loadCategories();
    },
    methods:{
        fetchAllCategory(){
            axios.get('/api/auth/category')
                .then(response => {
                    this.categories = response.data;
                }).catch(error => {

            })
        },
        loadCategories(page = 1){
            axios.get('/api/auth/category?page=' + page)
                .then(response => {
                    this.categories = response.data;
                }).catch(error => {

            })
        },
        deleteCategoryById(id){
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
                    axios.delete('/api/auth/category/'+id)
                        .then(response => {
                            Swal.fire(
                                'Deleted!',
                                '<b>'+response.data+'</b>',
                                'success'
                            )
                            this.categories.data = this.categories.data.filter(category => {
                                return category.id != id;
                            });

                        }).catch(() => {

                    })
                }
            })
        },
        realSearch:_.debounce(function (){
            axios.get('/api/auth/ctsearch?q='+this.search)
                .then(response => {
                    this.categories.data = response.data
                })
        })

        // For Watch Search
        // realSearch(searchKey){
        //     axios.get('/api/auth/ctsearch?q='+searchKey)
        //         .then(response => {
        //             this.categories.data = response.data;
        //         })
        // },

    },
    computed:{
        // filterCategory(){
        //     return this.categories.filter(category => {
        //         return category.category_name.match(this.search);
        //     })
        // }
    },
    watch: {
        // watch searching
        // search:function(){
        //     this.realSearch(this.search);
        // }

    }
}
</script>

<style scoped>

</style>
