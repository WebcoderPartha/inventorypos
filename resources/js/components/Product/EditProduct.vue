<template>
    <div>
        <div class="row">
            <div class="col-10 mx-auto">
                <div class="card mb-4">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Edit Product</h6>
                        <router-link class="btn btn-info" :to="{ name: 'ProductList' }">Product List</router-link>
                    </div>
                    <div class="card-body">
                        <form enctype="multipart/form-data" @submit.prevent="updateProductById()">
                            <div class="form-group">
                                <div class="form-row">
                                    <div class="col-6">
                                        <label for="name">Product Name</label>
                                        <input type="text" class="form-control" v-model="form.product_name" id="name" placeholder="Enter product name">
                                        <span v-if="errors ? errors.product_name : ''" class="text-danger"><b><small>{{ errors.product_name[0] }}</small></b></span>
                                    </div>
                                    <div class="col-6">
                                        <label for="category_id">Category</label>
                                        <select class="form-control" name="category_id" id="category_id" v-model="form.category_id">
                                            <option value="" disabled>Select Category</option>
                                            <option v-for="category in categories" :value="category.id">{{ category.category_name }}</option>
                                        </select>
                                        <span class="text-danger" v-if="errors ? errors.category_id : ''"><b><small>{{ errors.category_id[0] }}</small></b></span>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="form-row">
                                    <div class="col-4">
                                        <label for="root">Root</label>
                                        <input type="text" class="form-control" v-model="form.root" id="root" placeholder="Enter root">
                                        <span v-if="errors ? errors.root : ''" class="text-danger"><b><small>{{ errors.root[0] }}</small></b></span>
                                    </div>
                                    <div class="col-4">
                                        <label for="buying_price">Buying Price</label>
                                        <input type="text" class="form-control" v-model="form.buying_price" id="buying_price" placeholder="Enter buying price">
                                        <span class="text-danger" v-if="errors ? errors.buying_price : ''"><b><small>{{ errors.buying_price[0] }}</small></b></span>
                                    </div>
                                    <div class="col-4">
                                        <label for="selling_price">Selling Price</label>
                                        <input type="text" class="form-control" v-model="form.selling_price" id="selling_price" placeholder="Enter selling price">
                                        <span v-if="errors ? errors.selling_price : ''" class="text-danger"><b><small>{{ errors.selling_price[0] }}</small></b></span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="form-row">
                                    <div class="col-6">
                                        <label for="product_code">Product Code</label>
                                        <input type="text" class="form-control" v-model="form.product_code" id="product_code" placeholder="Enter Product Code">
                                        <span v-if="errors ? errors.product_code : ''" class="text-danger"><b><small>{{ errors.product_code[0] }}</small></b></span>
                                    </div>
                                    <div class="col-6">
                                        <label for="supplier_id">Supplier</label>
                                        <select class="form-control" v-model="form.supplier_id" id="supplier_id">
                                            <option value="" disabled>Select Supplier</option>
                                            <option v-for="supplier in suppliers" :value="supplier.id">{{ supplier.name }}</option>
                                        </select>
                                        <span class="text-danger" v-if="errors ? errors.supplier_id : ''"><b><small>{{ errors.supplier_id[0] }}</small></b></span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="form-row">
                                    <div class="col-6">
                                        <label for="buying_date">Buying Date</label>
                                        <input type="date" class="form-control" v-model="form.buying_date" id="buying_date">
                                        <span v-if="errors ? errors.buying_date : ''" class="text-danger"><b><small>{{ errors.buying_date[0] }}</small></b></span>
                                    </div>
                                    <div class="col-6">
                                        <label for="quantity">Quantity</label>
                                        <input type="text" class="form-control" v-model="form.quantity" id="quantity" placeholder="Enter product quantity">
                                        <span class="text-danger" v-if="errors ? errors.quantity : ''"><b><small>{{ errors.quantity[0] }}</small></b></span>
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
                                        <img id="upload" alt="" :src="imagePath(form.image)" width="80">
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
    name: "EditProduct",
    data(){
        return {
            form: {
                category_id     : '',
                product_name    :'',
                product_code    :'',
                root            : '',
                buying_price    : '',
                selling_price   : '',
                supplier_id     : '',
                buying_date     : '',
                quantity        : '',
                image           : '',
                newimage        : ''
            },
            errors              : {},
            categories          : {},
            suppliers           : {}
        }
    },
    created() {
        if (!User.loggedIn()){
            this.$router.push({ name: 'Login' });
            Notification.Warning('<b>Not allowed! Please login first!</b>');
        }
        this.getCategory();
        this.getSupplier();
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
        //Get Category
        getCategory(){
            axios.get('/api/auth/getcategory')
                .then(response => {
                    this.categories = response.data;
                })
        },
        // Get Supplier
        getSupplier(){
            axios.get('/api/auth/getsupplier')
                .then(response => {
                    this.suppliers = response.data;
                })
        },
        // Select Image Event
        selectImage(event){
            let file = event.target.files[0];
            if (file.size > 2097152){
                Notification.Error("<b>Upload file must be less then 2 MB</b>");
            }else{
                let reader = new FileReader();
                reader.onload = event => {
                    this.form.newimage = event.target.result;
                    document.getElementById('upload').src = event.target.result;
                }
                reader.readAsDataURL(file);
            }
        },
        // Image Path
        imagePath(value){
            return '/'+value;
        },
        // Update Product By Id
        updateProductById(){
            let id = this.$route.params.id;
            axios.put('/api/auth/product/'+id, this.form)
                .then(response => {
                    this.$router.push({ name: 'ProductList' });
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
