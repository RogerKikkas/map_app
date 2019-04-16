<template>
    <l-map :zoom="zoom" :center="center">
        <l-tile-layer :url="url" :attribution="attribution"></l-tile-layer>
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
            }
        }
    }
</script>

<style scoped>

</style>