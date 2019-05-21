<template>
    <div class="container-fluid h-100">
        <navbar :users="users" :userDateRange="dateRange" v-bind:value="refreshKey" v-on:updateRefreshKey="refreshKey += 1"></navbar>
        <router-view :users="users" :key="refreshKey"></router-view>
    </div>
</template>

<script>
    import * as moment from 'moment';

    export default {
        name: "AppContainer",

        data() {
            return {
                users: {},
                dateRange: {},
                refreshKey: 0,
            }
        },

        mounted() {
            this.getAllUsers();
            this.getStartDatesAndInitialUserData(this.$auth.user().id);
        },

        methods: {
            getAllUsers(){
                let app = this;
                // If logged in user is admin then gets all the information on users, regular users get less information
                if (this.$auth.user().role == 2) {
                    Vue.axios.get('/auth/users/')
                        .then(function(response) {
                            response.data.users.map(function(value) {
                                value.showCoordinates = false;
                                value.coordinates = [];
                                Vue.set(app.users, value.id, value);
                            })
                        })
                        .catch(function(error) {
                            //
                        });
                } else {
                    Vue.axios.get('/usersForMap').then(response => response.data.map(function(value) {
                        value.showCoordinates = false;
                        value.coordinates = [];
                        Vue.set(app.users, value.id, value);
                    }));
                }
            },

            getStartDatesAndInitialUserData(id) {
                let app = this;
                let startDate;
                let endDate;
                Vue.axios.get(`/userStartDates/${id}`).then(function(response) {
                    startDate = moment(response.data.created_at).subtract(1, 'days');
                    endDate = moment(response.data.created_at);
                    Vue.set(app.dateRange, 'startDate', startDate);
                    Vue.set(app.dateRange, 'endDate', endDate);

                    Vue.axios.get(`/userCoordinates/${id}`, {
                        params: {
                            startDate: startDate,
                            endDate: endDate,
                        }
                    }).then(function(response) {
                        Vue.set(app.users[id], 'coordinates', response.data);
                        Vue.set(app.users[id], 'showCoordinates', true);
                        Vue.set(app.users[id], 'email', app.$auth.user().email);
                    });

                }).catch(function(error) {
                    startDate = moment().subtract(1, 'days');
                    endDate = moment();
                    Vue.set(app.startDate = startDate);
                    Vue.set(app.endDate = endDate);

                    Vue.axios.get(`/userCoordinates/${id}`, {
                        params: {
                            startDate: startDate,
                            endDate: endDate,
                        }
                    }).then(function(response) {
                        Vue.set(app.users[id], 'coordinates', response.data);
                        Vue.set(app.users[id], 'showCoordinates', true);
                        Vue.set(app.users[id], 'email', app.$auth.user().email);
                    });
                });
            },

        }
    }
</script>

<style scoped>

</style>