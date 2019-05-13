<template>
    <nav id="navbar" class="navbar navbar-expand-md navbar-dark bg-dark fixed-top" role="navigation">
        <router-link class="navbar-brand" to="/map">Map</router-link>

        <!-- Collapse button -->
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#basicExampleNav"
                aria-controls="basicExampleNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Collapsible content -->
        <div class="collapse navbar-collapse" id="basicExampleNav">

            <!-- Links -->
            <ul class="navbar-nav mr-auto">

                <!-- Dropdown -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="navbarDropdownMenuLink" data-toggle="dropdown"
                       aria-haspopup="true" aria-expanded="false">Users</a>
                    <div class="dropdown-menu dropdown-primary" aria-labelledby="navbarDropdownMenuLink">
                        <div class="dropdown-item" v-for="user in users" @click.stop="toggleUser(user.id)" :key="user.id">
                            <input type="checkbox" :checked="user.showCoordinates">{{ user.name }}
                        </div>
                    </div>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="#">Date</a>
                </li>

                <li class="nav-item">
                    <span class="oi oi-calendar"></span>
                </li>

            </ul>
            <!-- Links -->
            <ul class="navbar-nav">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="navbarUserDropdownLink" data-toggle="dropdown"
                       role="button" aria-haspopup="true" aria-expanded="false">{{ $auth.user().name }}</a>
                    <div class="dropdown-menu dropdown-primary" id="navbarUserDropdownMenu" aria-labelledby="navbarUserDropdownLink">
                        <router-link class="dropdown-item" to="/user">Profile</router-link>
                        <router-link class="dropdown-item" v-if="$auth.check(2)" to="/admin">Admin</router-link>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" v-if="$auth.check()" @click="$auth.logout({
                            makeRequest: true,
                            redirect: '/login'
                        })">Logout</a>
                    </div>
                </li>
            </ul>

        </div>
    </nav>
</template>

<script>
    export default {
        name: "Navbar",

        props: {
            users: {
                type: Object/Array,
                    required: true
            }
        },

        methods: {
            toggleUser(id) {
                let user = this.users[id];

                if (user.showCoordinates) {
                    user.coordinates = [];
                    user.showCoordinates = false;
                } else {
                    this.getUserCoordinates(id);
                }

                console.log(this.users[id]);
            },

            getUserCoordinates(id) {
                console.log('id: ' + id);
                let app = this;
                Vue.axios.get(`/userCoordinates/${id}`).then(function(response) {
                    response.data[0].showCoordinates = true;
                    Vue.set(app.users, id, response.data[0]);
                });
            }
        }

    }
</script>

<style scoped>

</style>