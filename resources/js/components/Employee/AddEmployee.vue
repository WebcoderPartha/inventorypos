<template>
    <div>
        <div class="row">
            <div class="col-10 mx-auto">
                <div class="card mb-4">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Add Employee</h6>
                        <router-link class="btn btn-info" :to="{ name: 'AllEmployee' }">Employee List</router-link>
                    </div>
                    <div class="card-body">
                        <form enctype="multipart/form-data" @submit.prevent="storeEmployee">
                            <div class="form-group">
                                <div class="form-row">
                                    <div class="col-6">
                                        <label for="name">Employee Name</label>
                                        <input type="text" class="form-control" v-model="form.name" id="name" placeholder="Enter employee name">
                                        <small v-if="errors.name" class="form-text text-danger">{{ errors.name[0] }}</small>
                                    </div>
                                    <div class="col-6">
                                        <label for="email">Email address</label>
                                        <input type="email" class="form-control" v-model="form.email" id="email" placeholder="Enter email">
                                        <small v-if="errors.email" class="form-text text-danger">{{ errors.email[0] }}</small>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="form-row">
                                    <div class="col-6">
                                        <label for="phone">Phone Number</label>
                                        <input type="text" class="form-control" v-model="form.phone" id="phone" placeholder="Enter phone number">
                                        <small v-if="errors.phone" class="form-text text-danger">{{ errors.phone[0] }}</small>
                                    </div>
                                    <div class="col-6">
                                        <label for="address">Employee Address</label>
                                        <input type="text" class="form-control" id="address" v-model="form.address" placeholder="Enter address">
                                        <small v-if="errors.address" class="form-text text-danger">{{ errors.address[0] }}</small>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="form-row">
                                    <div class="col-6">
                                        <label for="salary">Salary</label>
                                        <input type="text" class="form-control" v-model="form.salary" id="salary" placeholder="Enter salary">
                                        <small v-if="errors.salary" class="form-text text-danger">{{ errors.salary[0] }}</small>
                                    </div>
                                    <div class="col-6">
                                        <label for="nid">NID (National Identity Number)</label>
                                        <input type="text" class="form-control" v-model="form.nid" id="nid" placeholder="Enter NID number">
                                        <small v-if="errors.nid" class="form-text text-danger">{{ errors.nid[0] }}</small>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="form-row">
                                    <div class="col-6">
                                        <label for="joindate">Joining Date</label>
                                        <input type="date" class="form-control" v-model="form.joindate" id="joindate" placeholder="Joining Date">
                                        <small v-if="errors.joindate" class="form-text text-danger">{{ errors.joindate[0] }}</small>
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
                                        <img :src="form.photo" alt="" style="width: 60px; height: 100%">
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
    name: "AddEmployee",
    created(){
      if (!User.loggedIn()){
          this.$router.push({ name: 'Login' });
          Notification.Warning('<b>Not allowed! Please login first!</b>');
      }
    },
    data(){
        return {
            form:{
                name    : null,
                email   : null,
                phone   : null,
                address : null,
                salary  : null,
                nid     : null,
                photo   : null,
                joindate: null
            },
            errors      : {}
        }
    },
    methods:{
        storeEmployee(){
            axios.post('/api/auth/employee', this.form)
                .then(response => {
                    this.$router.push({ name: 'AllEmployee' });
                    Notification.Success(response.data)
                    // console.log(response.data);
                }).catch(error => {
                this.errors = error.response.data.errors;
                Notification.Error("<b>Field Must not be empty!</b>")
            })
        },
        SelectImage(event){
            let file = event.target.files[0];
            // console.log(file);
            if (file.size > 1048576 ){
                Notification.Warning('<b>Upload Image less than 1MB</b>');
            }else {
                let reader = new FileReader();
                reader.onload = event => {
                    this.form.photo = event.target.result;
                    console.log(event.target.result);
                }
                reader.readAsDataURL(file);
            }
        }
    },
}
</script>

<style scoped>

</style>
