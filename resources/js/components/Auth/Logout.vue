<template>
    <div></div>
</template>

<script>
export default {
    name: "Logout",
    created() {
        if (User.loggedIn()){
            localStorage.removeItem('token');
            localStorage.removeItem('user');
            this.$router.push({ name: 'Login' });
            Notification.Success('Logout Successfully')
        }
    }
}
</script>

<style scoped>

</style>
