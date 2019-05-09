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
                       aria-haspopup="true" aria-expanded="false">Dropdown</a>
                    <div class="dropdown-menu dropdown-primary" aria-labelledby="navbarDropdownMenuLink">
                        <a class="dropdown-item" href="#">Action</a>
                        <a class="dropdown-item" href="#">Another action</a>
                        <a class="dropdown-item" href="#">Something else here</a>
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

    }
</script>

<style scoped>

</style>