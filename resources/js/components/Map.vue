<template>
    <l-map :zoom="zoom" :center="center" id="map" @update:zoom="updateZoom">
        <l-tile-layer :url="url" :attribution="attribution"></l-tile-layer>
        <user-map v-for="user in users" v-if="user.coordinates.length" :key="parseInt(refreshKey.toString() + user.id)" :userdata="user"></user-map>
    </l-map>
</template>

<script>
    export default {
        name: "Map",
        props: {
            users: {
                type: Object/Array,
                required: true
            },
            refreshKey: {
                type: Number,
            }
        },

        data() {
            return {
                zoom: 13,
                url:'https://{s}.tile.osm.org/{z}/{x}/{y}.png',
                attribution:'&copy; <a href="http://osm.org/copyright">OpenStreetMap</a> contributors',
            }
        },

        computed: {
            center: function() {
                let user = this.users[this.$auth.user().id];

                if (user) {
                    if (user.coordinates.length) {
                        let coordinates = user.coordinates[user.coordinates.length - 1];
                        return L.latLng(coordinates.lat, coordinates.lon);
                    }
                }

                return L.latLng(58.378025, 26.728493);
            }
        },

        methods: {
            updateZoom(zoom) {
                this.zoom = zoom;
            },
        }

    }
</script>

<style scoped>

</style>