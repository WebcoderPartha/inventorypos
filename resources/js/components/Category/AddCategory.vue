<template>
    <div>
        <div class="row">
            <div class="col-6 mx-auto">
                <div class="card mb-4">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Add Category</h6>
                        <router-link class="btn btn-info" :to="{ name: 'CategoryList' }">Category List</router-link>
                    </div>
                    <div class="card-body">
                        <form @submit.prevent="storeCategory">
                            <div class="form-group">
                                <div class="form-row">
                                    <div class="col-12">
                                        <label for="category_name">Category Name</label>
                                        <input type="text" class="form-control" v-model="form.category_name" id="category_name" placeholder="Enter category name">
                                        <span v-if="errors ? errors.category_name : ''" class="text-danger"><b><small>{{ errors.category_name[0] }}</small></b></span>
                                    </div>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "AddCategory",
    data(){
        return {
            form    : {
                category_name: ''
            },
            errors  : {}
        }
    },
    created() {
        if (!User.loggedIn()){
            this.$router.push({ name: 'Dashboard' })
        }
    },
    methods: {
        storeCategory(){
            axios.post('/api/auth/category', this.form)
                .then(response => {
                    this.$router.push({ name: 'CategoryList' });
                    Notification.Success('<b>'+response.data+'<b>');
                }).catch(error => {
                    this.errors = error.response.data.errors;
                    Notification.Error('<b>Field must not be empty!</b>')
            })
        }
    }
}
</script>

<style scoped>

</style>
