<template>
    <div class="row h-100">
        <div class="col-sm-4 offset-sm-4 my-auto">
            <div class="card">
                <h5 class="card-header text-center">Register</h5>
                <div class="card-body">
                    <form autocomplete="off" @submit.prevent="register" v-if="!success" method="post">
                        <div class="form-group col-sm-6 offset-sm-3" v-bind:class="{'has-error': has_error && errors.name}">
                            <label for="name">Name</label>
                            <input type="text" id="name" class="form-control" placeholder="John Doe" v-model="name" required>
                            <span class="help-block" v-if="has_error && errors.name">{{ errors.name[0] }}</span>
                        </div>
                        <div class="form-group col-sm-6 offset-sm-3" v-bind:class="{'has-error': has_error && errors.email}">
                            <label for="email">E-mail</label>
                            <input type="email" id="email" class="form-control" placeholder="user@example.com" v-model="email" required>
                            <span class="help-block" v-if="has_error && errors.email">{{ errors.email[0] }}</span>
                        </div>
                        <div class="form-group col-sm-6 offset-sm-3" v-bind:class="{'has-error': has_error && errors.password}">
                            <label for="password">Password</label>
                            <input type="password" id="password" class="form-control" v-model="password" required>
                            <span class="help-block" v-if="has_error && errors.password">{{ errors.password[0] }}</span>
                        </div>
                        <div class="form-group col-sm-6 offset-sm-3" v-bind:class="{'has-error': has_error && errors.password}">
                            <label for="password_confirmation">Password confirmation</label>
                            <input type="password" id="password_confirmation" class="form-control" v-model="password_confirmation" required>
                        </div>
                        <div class="form-group col-sm-6 offset-sm-3">
                            <div class="input-group mb-3">
                                <input type="text" id="color" class="form-control" v-model="color.hex" disabled>
                                <div class="input-group-append">
                                    <button class="btn btn-outline-secondary" type="button" @click="showColorPicker = !showColorPicker">Choose color</button>
                                </div>
                            </div>
                            <chrome-picker :value="color" v-if="showColorPicker" v-model="color"></chrome-picker>
                        </div>
                        <div class="form-group col-sm-6 offset-sm-3">
                            <button type="submit" class="btn btn-block btn-success">Register</button>
                        </div>
                        <div class="form-group col-sm-6 offset-sm-3">
                            <button type="submit" class="btn btn-block btn-primary" @click.prevent="$router.push({name: 'login'})">Login</button>
                        </div>
                    </form>
                </div>
                <div class="card-footer"></div>
            </div>
        </div>
    </div>
</template>
<script>
    export default {
        data() {
            return {
                name: '',
                email: '',
                password: '',
                password_confirmation: '',
                has_error: false,
                error: '',
                errors: {},
                success: false,
                color: { hex: ''},
                showColorPicker: false,
            }
        },

        mounted() {
            // Generates a random hex color
            this.color.hex = ('#'+(Math.random()*0xFFFFFF<<0).toString(16).toUpperCase());
        },

        methods: {
            register() {
                var app = this;
                this.$auth.register({
                    data: {
                        name: app.name,
                        email: app.email,
                        password: app.password,
                        password_confirmation: app.password_confirmation
                    },
                    success: function () {
                        app.success = true;
                        this.$router.push({name: 'register', params: {successRegistrationRedirect: true}})
                    },
                    error: function (res) {
                        console.log(res.response.data.errors);
                        app.has_error = true;
                        app.error = res.response.data.error;
                        app.errors = res.response.data.errors || {}
                    }
                })
            }
        }
    }
</script>