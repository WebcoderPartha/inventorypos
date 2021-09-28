<template>
    <div>
        <div class="row">
            <div class="col-8 mx-auto">
                <div class="card mb-4">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Add Customer</h6>
                        <router-link class="btn btn-info" :to="{ name: 'CustomerList' }">Customer List</router-link>
                    </div>
                    <div class="card-body">
                        <form @submit.prevent="storeCustomer" enctype="multipart/form-data">
                            <div class="form-group">
                                <div class="form-row">
                                    <div class="col-6">
                                        <label for="customer_name">Customer Name</label>
                                        <input type="text" class="form-control" v-model="form.customer_name" id="customer_name" placeholder="Enter customer name">
                                        <span v-if="errors ? errors.customer_name : ''" class="text-danger"><b><small>{{ errors.customer_name[0] }}</small></b></span>
                                    </div>
                                    <div class="col-6">
                                        <label for="customer_email">Customer Email</label>
                                        <input type="email" class="form-control" v-model="form.customer_email" id="customer_email" placeholder="Enter customer email">
                                        <span v-if="errors ? errors.customer_email : ''" class="text-danger"><b><small>{{ errors.customer_email[0] }}</small></b></span>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="form-row">
                                    <div class="col-6">
                                        <label for="customer_phone">Customer Phone</label>
                                        <input type="text" class="form-control" v-model="form.customer_phone" id="customer_phone" placeholder="Enter customer phone number">
                                        <span v-if="errors ? errors.customer_phone : ''" class="text-danger"><b><small>{{ errors.customer_phone[0] }}</small></b></span>
                                    </div>
                                    <div class="col-6">
                                        <label for="customer_address">Customer Address</label>
                                        <input type="text" class="form-control" v-model="form.customer_address" id="customer_address" placeholder="Enter customer address">
                                        <span v-if="errors ? errors.customer_address : ''" class="text-danger"><b><small>{{ errors.customer_address[0] }}</small></b></span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="form-row">
                                    <div class="col-6">
                                        <label for="customFile">Customer Photo</label>
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" @change="selectImage" id="customFile">
                                            <label class="custom-file-label" for="customFile">Choose file</label>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <img src="" width="120" id="upload" alt="">
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
    name: "AddCustomer",
    created() {
        if (!User.loggedIn()){
            this.$router.push({ name: 'Login' });
            Notification.Error("<b>Unauthorized! Please Login First!</b>");
        }
    },
    data(){
        return {
            form    : {
                customer_name   : '',
                customer_email  : '',
                customer_phone  : '',
                customer_address: '',
                customer_photo  : ''
            },
            errors  : {}
        }
    },
    methods: {
        selectImage(event){
            let file = event.target.files[0];
            if (file.size > 1048576){
                Notification.Error("<b>Upload image must be less than 1MB</b>")
            }else {
                let loader = new FileReader();
                loader.onload = event => {
                    this.form.customer_photo = event.target.result;
                    document.getElementById('upload').src = event.target.result;
                }
                loader.readAsDataURL(file);
            }
        },
        storeCustomer(){
            axios.post('/api/auth/customer', this.form)
                .then(response => {
                    this.$router.push({ name: 'CustomerList' });
                    Notification.Success("<b>"+response.data+"</b>");
                }).catch(error => {
                    this.errors = error.response.data.errors;
                    Notification.Error("<b>Something Went Wrong!</b>");
            });
        }
    }
}
</script>

<style scoped>
form label {
    font-weight:bolder;
}
</style>
