<template>
    <div>
        <div class="row">
            <div class="col-10 mx-auto">
                <div class="card mb-4">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Add Expense</h6>
                        <router-link class="btn btn-info" :to="{ name: 'ExpenseList' }">Expense List</router-link>
                    </div>
                    <div class="card-body">
                        <form @submit.prevent="updateExpenseById">
                            <div class="form-group">
                                <div class="form-row">
                                    <div class="col-12">
                                        <label for="expense_details">Expense Details</label>
                                        <textarea type="text" class="form-control" v-model="form.expense_details" id="expense_details" placeholder="Enter expense details"></textarea>
                                        <span v-if="errors ? errors.expense_details : ''" class="text-danger"><b><small>{{ errors.expense_details[0] }}</small></b></span>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="form-row">
                                    <div class="col-6">
                                        <label for="expense_amount">Expense Amount</label>
                                        <input type="text" class="form-control" v-model="form.expense_amount" id="expense_amount" placeholder="Enter expense amount">
                                        <span v-if="errors ? errors.expense_amount : ''" class="text-danger"><b><small>{{ errors.expense_amount[0] }}</small></b></span>
                                    </div>
                                    <div class="col-6">
                                        <label for="expense_date">Expense Date</label>
                                        <input type="date" class="form-control" v-model="form.expense_date" id="expense_date" placeholder="Enter buying price">
                                        <span class="text-danger" v-if="errors ? errors.expense_date : ''"><b><small>{{ errors.expense_date[0] }}</small></b></span>
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
    name: "EditExpense",
    data(){
        return {
            form: {
                expense_details : '',
                expense_amount  : '',
                expense_date    : ''
            },
            errors              : {}
        }
    },
    mounted() {
        if (!User.loggedIn()){
            this.$router.push({ name: 'Login' });
            Notification.Warning('<b>Not allowed! Please login first!</b>');
        }

        let id = this.$route.params.id
        axios.get('/api/auth/expense/'+id)
            .then(response => {
                this.form = response.data;
            })
    },
    methods: {
        updateExpenseById(){
            let id = this.$route.params.id
            axios.put('/api/auth/expense/'+id, this.form)
                .then(response => {
                    this.$router.push({ name: 'ExpenseList' });
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
