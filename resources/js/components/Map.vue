<template>
    <l-map :zoom="zoom" :center="center" id="map" @update:zoom="updateZoom">
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
            },
            zoom: {
                type: Number,
            },
            center: {
                type: Object/Array,
            }
        },

        data() {
            return {
                url:'https://{s}.tile.osm.org/{z}/{x}/{y}.png',
                attribution:'&copy; <a href="http://osm.org/copyright">OpenStreetMap</a> contributors',
            }
        },

        methods: {
            updateZoom(zoom) {
                this.$emit('updateZoom', zoom);
            }
        }

    }
</script>

<style scoped>

</style>