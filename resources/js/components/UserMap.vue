<template>
    <div>
        <l-circle-marker v-for="coordinate in userdata.coordinates" :lat-lng="[coordinate.lat, coordinate.lon]" :key="coordinate.id" :color="color" :radius="radius">
            <l-popup>
                <ul>
                    <li>Date: {{ coordinate.created_at }} UTC</li>
                    <li>Lat: {{ coordinate.lat }}</li>
                    <li>Lon: {{ coordinate.lon }}</li>
                    <li>Speed: {{ coordinate.speed }} km/h</li>
                    <li>Altitude: {{ coordinate.altitude }} m</li>
                    <li>Travelled: {{ coordinate.travelled }} m</li>
                </ul>
            </l-popup>
            <l-tooltip>{{ userdata.name }}</l-tooltip>
        </l-circle-marker>
        <l-polyline :lat-lngs="polyline" :color="color"></l-polyline>
    </div>
</template>

<script>
    export default {
        name: "UserMap",
        props: {
            userdata: {
                type: Object/Array,
                required: true
            }
        },

        data() {
            return {
                radius: 3,
            }
        },

        computed: {
            polyline: function() {
                return this.userdata.coordinates.map((x) => [x.lat, x.lon]);
            },

            color: function() {
                return this.userdata.color;
            }
        }
    }
</script>

<style scoped>
ul {
    padding: 0;
}
</style>