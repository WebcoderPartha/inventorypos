<template>
    <div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Category List</h6>
                        <div class="form-group">
                            <input type="text" class="form-control" placeholder="Search Category">
                        </div>
                        <router-link class="btn btn-info" :to="{ name: 'PayableEmployeeList' }">Pay Salary</router-link>
                    </div>
                    <div class="table-responsive">
                        <table class="table align-items-center table-flush">
                            <thead class="thead-light">
                            <tr>
                                <th>Month</th>
                                <th>Details</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="salary in salaries" :key="salary.id">
                                <td>{{ salary.salary_month }}</td>
                                <td><router-link :to="{ name: 'ViewPaidSalaryMonth', params:{month: salary.salary_month} }" class="btn btn-info">View <i class="fa fa-posts"></i></router-link></td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer">

                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
name: "PaidEmployeeList",
    data(){
        return {
            salaries : {}
        }
    },
    created() {
        if (!User.loggedIn()){
            this.$router.push({ name: 'Login' });
            Notification.Error('Unauthorized');
        }
        axios.get('/api/auth/getsalaries')
            .then(response => {
                this.salaries = response.data;
            })
    }
}
</script>

<style scoped>

</style>
