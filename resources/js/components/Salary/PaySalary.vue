<template>
    <div>
        <div class="row">
            <div class="col-10 mx-auto">
                <div class="card mb-4">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Pay Salary</h6>
                        <router-link class="btn btn-info" :to="{ name: 'PayableEmployeeList' }">Payable Employee List</router-link>
                    </div>
                    <div class="card-body">
                        <form enctype="multipart/form-data" @submit.prevent="storePaySalary()">
                            <div class="form-group">
                                <div class="form-row">
                                    <div class="col-6">
                                        <label for="name">Employee Name</label>
                                        <input type="text" class="form-control" disabled v-model="form.name" id="name" placeholder="Enter employee name">
                                        <small v-if="errors ? errors.name : ''" class="form-text text-danger">{{ errors.name[0] }}</small>
                                    </div>
                                    <div class="col-6">
                                        <label for="email">Email address</label>
                                        <input type="email" class="form-control" disabled v-model="form.email" id="email" placeholder="Enter email">
                                        <small v-if="errors ? errors.email : ''" class="form-text text-danger">{{ errors.email[0] }}</small>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="form-row">
                                    <div class="col-4">
                                        <label for="phone">Phone Number</label>
                                        <input type="text" class="form-control" disabled v-model="form.phone" id="phone" disabled>
                                        <small v-if="errors ? errors.phone : ''" class="form-text text-danger">{{ errors.phone[0] }}</small>
                                    </div>
                                    <div class="col-4">
                                        <label for="salary">Salary</label>
                                        <input type="text" class="form-control" v-model="form.salary" id="salary" placeholder="Enter salary">
                                        <small v-if="errors ? errors.salary : ''" class="form-text text-danger">{{ errors.salary[0] }}</small>
                                    </div>
                                    <div class="col-4">
                                        <label for="salary_month">Salary Month</label>
                                        <select class="form-control" id="salary_month" v-model="form.salary_month">
                                            <option value="" disabled>Select Salary Month</option>
                                            <option value="January">January</option>
                                            <option value="February">February</option>
                                            <option value="March">March</option>
                                            <option value="April">April</option>
                                            <option value="May">May</option>
                                            <option value="June">June</option>
                                            <option value="July">July</option>
                                            <option value="August">August</option>
                                            <option value="September">September</option>
                                            <option value="October">October</option>
                                            <option value="November">November</option>
                                            <option value="December">December</option>
                                        </select>
                                        <small v-if="errors ? errors.salary_month : ''" class="form-text text-danger">{{ errors.salary_month[0] }}</small>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary">Pay Now</button>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "PaySalary",
    data(){
        return {
            form:{
                name        : '',
                email       : '',
                phone       : '',
                salary      : '',
                employee_id : '',
                salary_month: ''
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
        storePaySalary(){
            axios.post('/api/auth/salary/pay/'+this.form.id, this.form)
                .then(response => {
                    this.$router.push({ name: 'PayableEmployeeList' });
                    Notification.Success("<b>"+response.data+"</b>");
                }).catch(error => {
                    this.errors = error.response.data.errors
                    Notification.Error("<b>Something Went Wrong!</b>");
            })
        }
    }
}
</script>

<style scoped>

</style>
