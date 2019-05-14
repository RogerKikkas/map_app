<template>
    <div class="container-fluid h-100">
        <navbar :users="users"></navbar>
        <router-view :users="users"></router-view>
    </div>
</template>

<script>
    export default {
        name: "AppContainer",

        data() {
            return {
                users: {},
            }
        },

        mounted() {
            this.getAllUsers();
            this.getUserData(this.$auth.user().id);
        },

        methods: {
            getAllUsers(){
                let app = this;
                Vue.axios.get('/usersForMap').then(response => response.data.map(function(value) {
                    value.showCoordinates = false;
                    value.coordinates = [];
                    Vue.set(app.users, value.id, value);
                }));
            },

            getUserData(id) {
                let app = this;
                Vue.axios.get(`/userCoordinates/${id}`).then(function(response) {
                    response.data[0].showCoordinates = true;
                    Vue.set(app.users, id, response.data[0]);
                });
            }
        }
    }
</script>

<style scoped>

</style>