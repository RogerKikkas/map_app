<template>
    <div>
        <l-circle-marker v-for="marker in markers" :lat-lng="[marker.lat, marker.lng]" :key="marker.id" :color="color" :radius="radius">
            <l-popup>
                <ul>
                    <li>Lat: {{ marker.lat }}</li>
                    <li>Lng: {{ marker.lng }}</li>
                </ul>
            </l-popup>
        </l-circle-marker>
        <l-polyline :lat-lngs="polyline" :color="color">
            <l-tooltip>{{ userdata.user_name }}</l-tooltip>
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
                markers: this.userdata.markers,
                color: this.userdata.color,
                polyline: this.userdata.markers.map((x) => [x.lat, x.lng])
            }
        }
    }
</script>

<style scoped>

</style>