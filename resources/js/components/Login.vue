<template>
    <div class="container h-100">
        <div class="row h-100">
            <div class="col-sm-4 offset-sm-4 my-auto">
                <div class="card">
                    <h5 class="card-header text-center">Login</h5>
                    <div class="card-body">
                        <div class="alert alert-danger" v-if="has_error">
                            <p>Error, unable to connect with these credentials.</p>
                        </div>
                        <form autocomplete="off" @submit.prevent="login" method="post">
                            <div class="form-group">
                                <label for="email">E-mail</label>
                                <input type="email" id="email" class="form-control" placeholder="user@example.com" v-model="email" required>
                            </div>
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" id="password" class="form-control" v-model="password" required>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-block btn-primary">Login</button>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-block btn-success" @click.prevent="$router.push({name: 'register'})">Register</button>
                            </div>
                        </form>
                    </div>
                    <div class="card-footer"></div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                email: null,
                password: null,
                has_error: false
            }
        },

        methods: {
            login() {
                // get the redirect object
                var redirect = this.$auth.redirect();
                var app = this;

                this.$auth.login({
                    data: {
                        email: app.email,
                        password: app.password
                    },

                    success: function() {
                        // handle redirection
                        this.$router.push({name: 'map'})
                    },

                    error: function() {
                        app.has_error = true
                    },

                    rememberMe: true,
                    fetchUser: true
                })
            }
        }
    }
</script>