<template>
    <div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">{{ this.$route.params.month }} month Paid List</h6>
                        <div class="form-group">
                            <input type="text" class="form-control" placeholder="Search">
                        </div>
                        <router-link class="btn btn-info" :to="{ name: 'PaidEmployeeList' }">Back</router-link>
                    </div>
                    <div class="table-responsive">
                        <table class="table align-items-center table-flush">
                            <thead class="thead-light">
                            <tr>
                                <th>SL</th>
                                <th>Name</th>
                                <th>Phone</th>
                                <th>Month</th>
                                <th>Paid Amount</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="(salary,index) in salaries" :key="index">
                                <td>{{ index + 1 }}</td>
                                <td>{{ salary.employee.name }}</td>
                                <td>{{ salary.employee.phone }}</td>
                                <td>{{ salary.salary_month }}</td>
                                <td>Tk.{{ salary.salary_amount }}/=</td>
                                <td><span class="badge badge-success">Paid</span></td>
                                <td><router-link :to="{name: 'EditSalary', params:{id:salary.id}}" class="btn btn-info"><i class="fa fa-edit"></i></router-link></td>
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
    name: "ViewPaidSalaryMonth",
    data() {
        return {
            salaries : {}
        }
    },
    created() {
        if (!User.loggedIn()){
            this.$router.push({ name: 'Login' });
            Notification.Error('Unauthorized');
        }
        let month = this.$route.params.month
        axios.get('/api/auth/paid-month/'+month)
            .then(response => {
            this.salaries = response.data;
        })
    }
}
</script>

<style scoped>

</style>
