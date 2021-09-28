<template>
    <div>
        <!-- Register Content -->
        <div class="container-login">
            <div class="row justify-content-center">
                <div class="col-xl-10 col-lg-12 col-md-9">
                    <div class="card shadow-sm my-5">
                        <div class="card-body p-0">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="login-form">
                                        <div class="text-center">
                                            <h1 class="h4 text-gray-900 mb-4">Register</h1>
                                        </div>
                                        <form @submit.prevent="Register">
                                            <div class="form-group">
                                                <label for="name">Name</label>
                                                <input type="text" class="form-control" v-model="form.name" placeholder="Enter First Name">
                                                <span v-if="errors ? errors.name : null"><small class="text-danger">{{ errors.name[0] }}</small></span>
                                            </div>
                                            <div class="form-group">
                                                <label for="email">Email</label>
                                                <input type="email" class="form-control" v-model="form.email" placeholder="Enter Email Address">
                                                <span v-if="errors ? errors.email : null"><small class="text-danger">{{ errors.email[0] }}</small></span>
                                            </div>
                                            <div class="form-group">
                                                <label for="password">Password</label>
                                                <input type="password" class="form-control" v-model="form.password" placeholder="Password">
                                                <span v-if="errors ? errors.password : null"><small class="text-danger">{{ errors.password[0] }}</small></span>
                                            </div>
                                            <div class="form-group">
                                                <label>Repeat Password</label>
                                                <input type="password" class="form-control" v-model="form.password_confirmation"
                                                       placeholder="Repeat Password">
                                                <span v-if="errors ? errors.password_confirmation : null"><small class="text-danger">{{ errors.password_confirmation[0] }}</small></span>
                                            </div>
                                            <div class="form-group">
                                                <button type="submit" class="btn btn-primary btn-block">Register</button>
                                            </div>
                                        </form>
                                        <hr>
                                        <div class="text-center">
                                            <router-link :to="{ name: 'Login' }" class="font-weight-bold small">Already have an account?</router-link>
                                        </div>
                                        <div class="text-center">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Register Content -->
    </div>
</template>

<script>
export default {
    name: "Register",
    created(){
        if (User.loggedIn()){
            this.$router.push({ name: 'Dashboard' });
        }
    },
    data(){
        return {
            form: {
                name                    : null,
                email                   : null,
                password                : null,
                password_confirmation   : null
            },
            errors: {}
        }
    },
    methods:{
        Register(){
            axios.post('/api/auth/register', this.form).
                then(response => {
                    this.$router.push({ name: 'Login' });
                    Toast.fire({
                    icon: 'success',
                    title: response.data.success
                    })
            }).catch(error => {
                // console.log(error.response.data.errors)
                this.errors = error.response.data.errors;
                Toast.fire({
                    icon: 'warning',
                    title: 'Field must not be empty!'
                })
            })
        }
    }
}
</script>

<style scoped>

</style>
