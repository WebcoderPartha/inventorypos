<template>
    <div>
        <div class="row">
            <div class="col-10 mx-auto">
                <div class="card mb-4">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Edit Salary</h6>
                        <router-link class="btn btn-info" :to="{ name: 'PaidEmployeeList' }">Back</router-link>
                    </div>
                    <div class="card-body">
                        <form @submit.prevent="updatePaidSalry">
                            <div class="form-group">
                                <div class="form-row">
                                    <div class="col-6">
                                        <label for="name">Employee Name</label>
                                        <input type="text" class="form-control" disabled v-model="form.employee.name" id="name" placeholder="Enter employee name">
                                    </div>
                                    <div class="col-6">
                                        <label for="email">Email address</label>
                                        <input type="email" class="form-control" disabled v-model="form.employee.email" id="email" placeholder="Enter email">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="form-row">
                                    <div class="col-4">
                                        <label for="phone">Phone Number</label>
                                        <input type="text" class="form-control" v-model="form.employee.phone" id="phone" disabled>
                                    </div>
                                    <div class="col-4">
                                        <label for="salary">Salary</label>
                                        <input type="text" class="form-control" v-model="form.salary_amount" id="salary" placeholder="Enter salary">
                                        <small v-if="errors ? errors.salary_amount : ''" class="form-text text-danger">{{ errors.salary_amount[0] }}</small>
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
                            <button type="submit" class="btn btn-primary">Update</button>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "EditSalary",
    data(){
        return {
            form:{
                employee: {
                    name: ''
                },
                salary_amount   :'',
                employee_id     : '',
                salary_month    : ''
            },
            errors: {}
        }
    },
    created() {
        if (!User.loggedIn()){
            this.$router.push({ name: 'Login' });
        }
        let id = this.$route.params.id;
        axios.get('/api/auth/salary/show/'+id)
            .then(response => {
                this.form = response.data
            })
    },
    methods: {
        updatePaidSalry(){
            let id = this.$route.params.id;
            axios.put('/api/auth/paid-salary/'+id, this.form)
                .then(response => {
                    this.$router.push({name: 'PaidEmployeeList'});
                    Notification.Success("<b>"+response.data+"</b>");
                }).catch(error => {
                    this.errors = error.response.data.errors;
                    Notification.Error("<b>Something Went Wrong!</b>");
            })
        }
    }
}
</script>

<style scoped>

</style>
