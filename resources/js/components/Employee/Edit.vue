<template>
    <div>
        <div class="row">
            <div class="col-10 mx-auto">
                <div class="card mb-4">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Edit Employee</h6>
                        <router-link class="btn btn-info" :to="{ name: 'AllEmployee' }">Employee List</router-link>
                    </div>
                    <div class="card-body">
                        <form enctype="multipart/form-data" @submit.prevent="updateEmployee">
                            <div class="form-group">
                                <div class="form-row">
                                    <div class="col-6">
                                        <label for="name">Employee Name</label>
                                        <input type="text" class="form-control" v-model="form.name" id="name" placeholder="Enter employee name">
                                        <small v-if="errors ? errors.name : ''" class="form-text text-danger">{{ errors.name[0] }}</small>
                                    </div>
                                    <div class="col-6">
                                        <label for="email">Email address</label>
                                        <input type="email" class="form-control" v-model="form.email" id="email" placeholder="Enter email">
                                        <small v-if="errors ? errors.email : ''" class="form-text text-danger">{{ errors.email[0] }}</small>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="form-row">
                                    <div class="col-6">
                                        <label for="phone">Phone Number</label>
                                        <input type="text" class="form-control" v-model="form.phone" id="phone" placeholder="Enter phone number">
                                        <small v-if="errors ? errors.phone : ''" class="form-text text-danger">{{ errors.phone[0] }}</small>
                                    </div>
                                    <div class="col-6">
                                        <label for="address">Employee Address</label>
                                        <input type="text" class="form-control" id="address" v-model="form.address" placeholder="Enter address">
                                        <small v-if="errors ? errors.address : ''" class="form-text text-danger">{{ errors.address[0] }}</small>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="form-row">
                                    <div class="col-6">
                                        <label for="salary">Salary</label>
                                        <input type="text" class="form-control" v-model="form.salary" id="salary" placeholder="Enter salary">
                                        <small v-if="errors ? errors.salary : ''" class="form-text text-danger">{{ errors.salary[0] }}</small>
                                    </div>
                                    <div class="col-6">
                                        <label for="nid">NID (National Identity Number)</label>
                                        <input type="text" class="form-control" v-model="form.nid" id="nid" placeholder="Enter NID number">
                                        <small v-if="errors ? errors.nid : ''" class="form-text text-danger">{{ errors.nid[0] }}</small>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="form-row">
                                    <div class="col-6">
                                        <label for="joindate">Joining Date</label>
                                        <input type="date" class="form-control" v-model="form.joindate" id="joindate" placeholder="Joining Date">
                                        <small v-if="errors ? errors.joindate : ''" class="form-text text-danger">{{ errors.joindate[0] }}</small>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="form-row">
                                    <div class="col-6">
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" id="customFile" @change="SelectImage">
                                            <label class="custom-file-label" for="customFile">Choose file</label>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <img id="upload" :src="imagePath(form.photo)" alt="" style="width: 60px; height: 100%">
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
name: "Edit",
    data(){
        return {
            form:{
                name    : '',
                email   : '',
                phone   : '',
                address : '',
                salary  : '',
                nid     : '',
                photo   : '',
                joindate: '',
                newphoto: '',
            },
            errors: {}
        }
    },
    created() {
        if (!User.loggedIn()){
            this.$router.push({ name: 'Login' });
        }
        this.showEmployee()
    },
    methods:{
        showEmployee(){
            axios.get(`/api/auth/employee/${this.$route.params.id}`)
                .then(response => {
                    // console.log(response.data)
                    return this.form = response.data;
                }).catch(error => {
                console.log(error.response.data.error)
            });
        },
        SelectImage(event){
            let file = event.target.files[0];
            // console.log(file);
            if (file.size > 1048576 ){
                Notification.Warning('<b>Upload Image less than 1MB</b>');
            }else {
                let reader = new FileReader();
                reader.onload = event => {
                    this.form.newphoto = event.target.result;
                    document.getElementById('upload').src = event.target.result;
                    // console.log(event.target.result);
                }
                reader.readAsDataURL(file);
            }
        },
        updateEmployee(){
            axios.put(`/api/auth/employee/${this.$route.params.id}`, this.form).then(response => {
                this.$router.push({ name: 'AllEmployee' });
                Notification.Success(response.data)
            }).catch(error => {
                this.errors = error.response.data.errors;
                Notification.Error("<b>Field Must not be empty!</b>")
                console.log(error.response.data);
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
