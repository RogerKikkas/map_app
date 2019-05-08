<template>
    <l-map :zoom="zoom" :center="center" id="map">
        <l-tile-layer :url="url" :attribution="attribution"></l-tile-layer>
        <user-map v-for="user in users" :key="user.id" :userdata="user"></user-map>
    </l-map>
</template>

<script>
    export default {
        name: "Map",

        data() {
            return {
                zoom: 13,
                center: L.latLng(58.378025, 26.728493),
                url:'https://{s}.tile.osm.org/{z}/{x}/{y}.png',
                attribution:'&copy; <a href="http://osm.org/copyright">OpenStreetMap</a> contributors',
                users: {},
            }
        },

        mounted() {
            this.getUserData(this.$auth.user().id);
        },

        methods: {
            getUserData($id) {
                Vue.axios.get(`/userCoordinates/${$id}`).then(response => Vue.set(this.users, $id, response.data[0]));
            }
        }
    }
</script>

<style scoped>

</style>