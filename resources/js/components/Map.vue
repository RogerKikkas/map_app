<template>
    <l-map :zoom="zoom" :center="center" id="map">
        <l-tile-layer :url="url" :attribution="attribution"></l-tile-layer>
        <user-map v-for="user in users" v-if="user.coordinates.length" :key="user.id" :userdata="user"></user-map>
    </l-map>
</template>

<script>
    export default {
        name: "Map",
        props: {
            users: {
                type: Object/Array,
                required: true
            }
        },

        data() {
            return {
                zoom: 13,
                center: L.latLng(58.378025, 26.728493),
                url:'https://{s}.tile.osm.org/{z}/{x}/{y}.png',
                attribution:'&copy; <a href="http://osm.org/copyright">OpenStreetMap</a> contributors',
            }
        },

    }
</script>

<style scoped>

</style>