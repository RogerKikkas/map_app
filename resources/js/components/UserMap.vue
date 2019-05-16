<template>
    <div>
        <l-circle-marker v-for="coordinate in coordinates" :lat-lng="[coordinate.lat, coordinate.lng]" :key="coordinate.id" :color="color" :radius="radius">
            <l-popup>
                <ul>
                    <li>Date: {{ coordinate.created_at }}</li>
                    <li>Lat: {{ coordinate.lat }}</li>
                    <li>Lng: {{ coordinate.lng }}</li>
                    <li>Speed: {{ coordinate.speed }} m/s</li>
                    <li>Altitude: {{ coordinate.altitude }} m</li>
                    <li>Travelled: {{ coordinate.travelled }} m</li>
                </ul>
            </l-popup>
        </l-circle-marker>
        <l-polyline :lat-lngs="polyline" :color="color">
            <l-tooltip>{{ userdata.name }}</l-tooltip>
        </l-polyline>
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
                coordinates: this.userdata.coordinates,
                color: this.userdata.color,
                polyline: this.userdata.coordinates.map((x) => [x.lat, x.lng])
            }
        }
    }
</script>

<style scoped>
ul {
    padding: 0;
}
</style>