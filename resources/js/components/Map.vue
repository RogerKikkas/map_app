<template>
    <l-map :zoom="zoom" :center="center">
        <l-tile-layer :url="url" :attribution="attribution"></l-tile-layer>
        <user-map v-for="user in usersdata" v-if="user.show" :key="user.user_id" :userdata="user"></user-map>
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
                usersdata : [
                    {
                        user_id: 1,
                        user_name: 'Tom',
                        markers: [
                            {
                                id: 1,
                                lat: 58.356634,
                                lng: 26.723277
                            },
                            {
                                id: 2,
                                lat: 58.359776,
                                lng: 26.721412
                            }
                        ],
                        color: 'green',
                        show: true
                    },
                    {
                        user_id: 2,
                        user_name: 'Joe',
                        markers: [
                            {
                                id: 3,
                                lat: 58.369652,
                                lng: 26.727763
                            },
                            {
                                id: 4,
                                lat: 58.368696,
                                lng: 26.734282
                            },
                        ],
                        color: 'red',
                        show: true
                    }
                ]
            }
        }
    }
</script>

<style scoped>

</style>