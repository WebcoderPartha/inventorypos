<template>
    <div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Payable Employee List</h6>
                        <div class="form-group">
                            <input type="text" class="form-control" v-model="search" placeholder="Search employee">
                        </div>
                        <router-link class="btn btn-info" :to="{ name: 'AddEmployee' }">+</router-link>
                    </div>
                    <div class="table-responsive">
                        <table class="table align-items-center table-flush">
                            <thead class="thead-light">
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Salary</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="(employee, index) in searchFilter" :key="index">
                                <td>{{ employee.name }}</td>
                                <td>{{ employee.email }}</td>
                                <td>{{ employee.phone }}</td>
                                <td>Tk.{{ employee.salary }}/=</td>
                                <td><router-link :to="{ name: 'PaySalary', params:{ id:employee.id }}" class="btn btn-info"><i class="fa fa-dollar-sign"></i> Pay Now</router-link></td>

                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer"></div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "PayableEmployeeList",
    created() {
        if (!User.loggedIn()){
            this.$router.push({ name: 'Login' });
            Notification.Error('<b>Unauthorized! Please Login first!</b>');
        }

        this.loadEmployees();
    },
    data(){
        return {
            employees   : [],
            search      : ''
        }
    },
    computed:{
        searchFilter(){
            return this.employees.filter(employee =>{
                if (employee.name.match(this.search)){
                    return employee.name.match(this.search);
                }else if(employee.email.match(this.search)){
                    return employee.email.match(this.search);
                }else if (employee.phone.match(this.search)){
                    return employee.phone.match(this.search);
                }else if (employee.address.match(this.search)){
                    return employee.address.match(this.search);
                }else if (employee.salary.match(this.search)){
                    return employee.salary.match(this.search);
                }else if (employee.nid.match(this.search)){
                    return employee.nid.match(this.search);
                }

            })
        },

    },

    methods: {
        loadEmployees(){
            axios.get('/api/auth/employee')
                .then(response => {
                    // console.log(response.data)
                    this.employees = response.data;
                }).catch(error => {
                console.log(error.response.data)
            })
        },
        image(value){
            return '/'+value ;
        },
        deleteEmployee(id){
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    axios.delete(`/api/auth/employee/${id}`).then(response => {
                        this.employees = this.employees.filter(employee => {
                            return employee.id != id;
                        })
                        Swal.fire(
                            'Deleted!',
                            response.data,
                            'success'
                        )
                    }).catch(error => {

                    })

                }
            })
        }
    },

}
</script>

<style scoped>

</style>
