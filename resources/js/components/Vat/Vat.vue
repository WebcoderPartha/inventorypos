<template>
    <div>
        <div class="row">
            <div class="col-6 mx-auto">
                <div class="card mb-4">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Vat</h6>
                    </div>
                    <div class="card-body">
                        <form @submit.prevent="updateVat">
                            <div class="form-group">
                                <div class="form-row">
                                    <div class="col-12">
                                        <label for="vat">Vat (%) </label>
                                        <input type="text" class="form-control" v-model="form.vat" id="vat" placeholder="Enter vat">
                                        <span v-if="errors ? errors.vat : ''" class="text-danger"><b><small>{{ errors.vat[0] }}</small></b></span>
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
    name: "Vat",
    created(){
        if (!User.loggedIn()){
            this.$router.push({ name: 'Login' });
            Notification.Error("<b>Unauthorized! Please Login First!</b>");
        }
        this.getVat();
    },
    data(){
        return {
            form: {
                vat: ''
            },
            errors: {}
        }
    },
    methods:{
        getVat(){
            axios.get('/api/auth/vat')
                .then(response => {
                    this.form = response.data
                }).catch(error => {

            })
        },
        updateVat(){
            axios.post('/api/auth/vat-update', this.form)
                .then(response => {
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
