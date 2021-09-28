<template>
    <div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Expense List</h6>
                        <div class="form-group">
                            <input type="text" class="form-control" placeholder="Search Product">
                        </div>
                        <router-link class="btn btn-info" :to="{ name: 'AddExpense' }">+</router-link>
                    </div>
                    <div class="table-responsive">
                        <table class="table align-items-center table-flush">
                            <thead class="thead-light">
                            <tr>
                                <th>Expense Details</th>
                                <th>Expense Amount</th>
                                <th>Expense Date</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="expense in expenses" :key="expense.id">
                                <td>{{ expense.expense_details }}</td>
                                <td>Tk:{{ expense.expense_amount }}/=</td>
                                <td>{{ expense.expense_date ? expense.expense_date : '' }}</td>
                                <td><router-link :to="{ name: 'EditExpense', params:{id:expense.id} }" class="btn btn-info"><i class="fa fa-edit"></i></router-link>
                                    <button @click.prevent="deleteExpenseById(expense.id)" class="btn btn-danger"><i class="fa fa-trash-alt"></i></button></td>
                                <!--                                <td><span class="badge badge-success">Delivered</span></td>-->
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
    name: "ExpenseList",
    data() {
        return {
            expenses : {}
        }
    },
    mounted() {
        if (!User.loggedIn()){
            this.$router.push({ name: 'Login' });
            Notification.Warning('<b>Not allowed! Please login first!</b>');
        }
        axios.get('/api/auth/expense')
            .then(response => {
                this.expenses = response.data;
            })
    },
    methods: {
        deleteExpenseById(expense_id){
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
                    axios.delete('/api/auth/expense/'+expense_id)
                        .then(response => {
                            this.expenses = this.expenses.filter(expense => {
                                return expense.id != expense_id;
                            })
                            Swal.fire(
                                'Deleted!',
                                '<b>'+response.data+'</b>',
                                'success'
                            )
                        })
                }
            })
        }
    }
}
</script>

<style scoped>

</style>
