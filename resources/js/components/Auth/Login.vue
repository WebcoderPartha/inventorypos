<template>
<div>
    <!-- Login Content -->
    <div class="container-login">
        <div class="row justify-content-center">
            <div class="col-xl-10 col-lg-12 col-md-9">
                <div class="card shadow-sm my-5">
                    <div class="card-body p-0">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="login-form">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">Login</h1>
                                    </div>
                                    <form class="user" @submit.prevent="Login">
                                        <div class="form-group">
                                            <input type="email" class="form-control" v-model="form.email" placeholder="Enter Email Address">
                                            <span v-if="this.errors ? this.errors.email : ''"><small class="text-danger">{{ this.errors.email[0] }}</small></span>
                                        </div>
                                        <div class="form-group">
                                            <input type="password" class="form-control" v-model="form.password" placeholder="Password">
                                            <span v-if="this.errors ? this.errors.password : ''"><small class="text-danger">{{ this.errors.password[0] }}</small></span>
                                        </div>
                                        <div class="form-group">
                                            <div class="custom-control custom-checkbox small" style="line-height: 1.5rem;">
                                                <input type="checkbox" class="custom-control-input" id="customCheck">
                                                <label class="custom-control-label" for="customCheck">Remember
                                                    Me</label>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-primary btn-block">Login</button>
                                        </div>
                                    </form>
                                    <hr>
                                    <div class="text-center">
                                        <router-link :to="{ name: 'Register' }" class="font-weight-bold small">Create an Account!</router-link>
                                        <br>
                                        <router-link :to="{ name: 'ForgetPassword' }" class="font-weight-bold small">Forget password</router-link>
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
    <!-- Login Content -->
</div>
</template>

<script>
export default {
    name: "Login",
    created() {
        if (User.loggedIn()){
            this.$router.push({ name: 'Dashboard' })
        }
    },
    data(){
        return {
            form : {
                email : null,
                password: null
            },
            errors: {}
        }
    },
    methods:{
        Login(){
            axios.post('/api/auth/login', this.form)
                .then(response => {

                    User.responseAfterLogin(response);
                    this.$router.push({ name: 'Dashboard' });
                    Notification.Success('<b>Logged In Successfully</b>')

                }).catch(error => {
                    this.errors = error.response.data.errors;
                    Notification.Error("<b>Email or Password Invalid!</b>")
                });
        }
    }
}
</script>

<style scoped>

</style>
