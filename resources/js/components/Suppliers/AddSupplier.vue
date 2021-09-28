<template>
    <div>
        <div class="row">
            <div class="col-10 mx-auto">
                <div class="card mb-4">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Add Supplier</h6>
                        <router-link class="btn btn-info" :to="{ name: 'SupplierList' }">Supplier List</router-link>
                    </div>
                    <div class="card-body">
                        <form enctype="multipart/form-data" @submit.prevent="storeSupplier">
                            <div class="form-group">
                                <div class="form-row">
                                    <div class="col-6">
                                        <label for="name">Name</label>
                                        <input type="text" class="form-control" v-model="form.name" id="name" placeholder="Enter supplier name">
                                        <span v-if="errors ? errors.name : ''" class="text-danger"><b><small>{{ errors.name[0] }}</small></b></span>
                                    </div>
                                    <div class="col-6">
                                        <label for="email">Email address</label>
                                        <input type="email" class="form-control" v-model="form.email" id="email" placeholder="Enter email">
                                        <span class="text-danger" v-if="errors ? errors.email : ''"><b><small>{{ errors.email[0] }}</small></b></span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="form-row">
                                    <div class="col-6">
                                        <label for="phone">Phone Number</label>
                                        <input type="text" class="form-control" v-model="form.phone" id="phone" placeholder="Enter phone number">
                                        <span class="text-danger" v-if="errors ? errors.phone : ''"><b><small>{{ errors.phone[0] }}</small></b></span>
                                    </div>
                                    <div class="col-6">
                                        <label for="address">Address</label>
                                        <input type="text" class="form-control" v-model="form.address" id="address" placeholder="Enter address">
                                        <span class="text-danger" v-if="errors ? errors.address : ''"><b><small>{{ errors.address[0] }}</small></b></span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="form-row">
                                    <div class="col-6">
                                        <label for="shopname">Shop Name</label>
                                        <input type="text" class="form-control" v-model="form.shopname" id="shopname" placeholder="Enter shop name">
                                        <span class="text-danger" v-if="errors ? errors.shopname : ''"><b><small>{{ errors.shopname[0] }}</small></b></span>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="form-row">
                                    <div class="col-6">
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" @change="selectImage" id="customFile">
                                            <label class="custom-file-label" for="customFile">Choose file</label>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <img id="showPhoto" alt="" style="width: 60px; height: 100%">
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
    name: "AddSupplier",
    created() {
        if (!User.loggedIn()){
            this.$router.push({ name: 'Login' });
            Notification.Warning('<b>Not allowed! Please login first!</b>');
        }
    },
    data(){
        return {
            form: {
                name    : '',
                email   : '',
                phone   : '',
                address : '',
                shopname: '',
                photo   : '',
            },
            errors : {}
        }
    },
    methods: {
        storeSupplier(){
            axios.post('/api/auth/supplier', this.form).then(response => {
                this.$router.push({ name: 'SupplierList' });
                Notification.Success(response.data)
            }).catch(error => {
                // console.log(error.response.data.errors);
                this.errors = error.response.data.errors;

                Notification.Error('<b>Field Must not be empty!</b>');


            })
        },
        selectImage(event){
            let file = event.target.files[0];
            if (file.size > 1048576){
                Notification.Error('<b>Upload image must be less than 1MB</b>')
            }else{
                let reader = new FileReader();
                reader.onload = event => {
                    this.form.photo = event.target.result;
                    document.getElementById('showPhoto').src = event.target.result;
                }
                reader.readAsDataURL(file);
            }
        }
    }
}
</script>

<style scoped>

</style>
