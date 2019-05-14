<template>
    <div class="container-fluid h-100">
        <navbar :users="users" :userStartDate="startDate" :userEndDate="endDate"></navbar>
        <router-view :users="users"></router-view>
    </div>
</template>

<script>
    import * as moment from 'moment';

    export default {
        name: "AppContainer",

        data() {
            return {
                users: {},
                startDate: '',
                endDate: '',
                test: {},
            }
        },

        mounted() {
            this.getAllUsers();
            this.getStartDates(this.$auth.user().id);
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
            },

            getStartDates(id) {
                let app = this;
                Vue.axios.get(`/userStartDates/${id}`).then(function(response) {
                    Vue.set(app.startDate = moment(response.data.created_at).subtract(1, 'days'));
                    Vue.set(app.endDate = moment(response.data.created_at));
                });
            }
        }
    }
</script>

<style scoped>

</style>