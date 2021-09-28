<template>
    <div>

    </div>
</template>

<script>
export default {
    name: "NotFound",
    created() {
        if (User.loggedIn()){
            this.$router.push({ name: 'Dashboard' });
            Notification.Error("<b>Page doesn't exist!</b>");
        }else{
            this.$router.push({ name: 'Login' });
            Notification.Error("<b>Unauthorized! Login first!</b>")
        }
    }
}

</script>

<style scoped>

</style>
