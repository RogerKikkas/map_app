<template>
    <div class="container h-100">
        <!-- MODAL -->
        <transition @enter="startTransitionModal" @after-enter="endTransitionModal" @before-leave="endTransitionModal" @after-leave="startTransitionModal">
            <div class="modal fade" v-show="showRegisteredModal" ref="modal" @click.self="redirectToLogin">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">You have successfully registered</h5>
                            <button class="close" type="button" @click="showModal = false"><span aria-hidden="true">×</span></button>
                        </div>
                        <div class="modal-body">
                            <h3>Your api token</h3>
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" aria-label="API token" :value="token" disabled>
                                <div class="input-group-append">
                                    <button class="btn btn-outline-secondary" type="button" v-clipboard:copy="token">Copy</button>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-primary" type="button" @click.prevent="redirectToLogin()">Go to Login</button>
                        </div>
                    </div>
                </div>
            </div>
        </transition>
        <div class="modal-backdrop fade d-none" ref="backdrop"></div>

        <!-- FORM -->
        <div class="row h-100">
            <div class="col-sm-4 offset-sm-4 my-auto">
                <div class="card">
                    <h5 class="card-header text-center">Register</h5>
                    <div class="card-body">
                        <form autocomplete="off" @submit.prevent="register" method="post">
                            <div class="form-group" v-bind:class="{'has-error': has_error && errors.name}">
                                <label for="name">Name</label>
                                <input type="text" id="name" class="form-control" placeholder="John Doe" v-model="name" required>
                                <span class="help-block" v-if="has_error && errors.name">{{ errors.name[0] }}</span>
                            </div>
                            <div class="form-group" v-bind:class="{'has-error': has_error && errors.email}">
                                <label for="email">E-mail</label>
                                <input type="email" id="email" class="form-control" placeholder="user@example.com" v-model="email" required>
                                <span class="help-block" v-if="has_error && errors.email">{{ errors.email[0] }}</span>
                            </div>
                            <div class="form-group" v-bind:class="{'has-error': has_error && errors.password}">
                                <label for="password">Password</label>
                                <input type="password" id="password" class="form-control" v-model="password" required>
                                <span class="help-block" v-if="has_error && errors.password">{{ errors.password[0] }}</span>
                            </div>
                            <div class="form-group" v-bind:class="{'has-error': has_error && errors.password}">
                                <label for="password_confirmation">Password confirmation</label>
                                <input type="password" id="password_confirmation" class="form-control" v-model="password_confirmation" required>
                            </div>
                            <div class="form-group">
                                <div class="input-group mb-3">
                                    <input type="text" id="color" class="form-control" v-model="color.hex" disabled>
                                    <div class="input-group-append">
                                        <button class="btn btn-outline-secondary" type="button" @click="showColorPicker = !showColorPicker">Choose color</button>
                                    </div>
                                </div>
                                <chrome-picker class="color-picker" :value="color" v-if="showColorPicker" v-model="color"></chrome-picker>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-block btn-success">Register</button>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-block btn-primary" @click.prevent="$router.push({name: 'login'})">Login</button>
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
                name: '',
                email: '',
                password: '',
                password_confirmation: '',
                token: '',
                has_error: false,
                error: '',
                errors: {},
                color: { hex: ''},
                showColorPicker: false,
                showRegisteredModal: false,
            }
        },

        mounted() {
            // Generates a random hex color
            this.color.hex = ('#'+(Math.random()*0xFFFFFF<<0).toString(16).toUpperCase());
            this.token = this.randomString(10);
        },

        methods: {
            // generate a random string to use as a token
            randomString(len) {
                let text = "";
                let chars = "abcdefghijklmnopqrstuvwxyz123456789";

                for( let i=0; i < len; i++ ) {
                    text += chars.charAt(Math.floor(Math.random() * chars.length))
                }

                return text
            },

            register() {
                var app = this;
                this.$auth.register({
                    data: {
                        name: app.name,
                        email: app.email,
                        password: app.password,
                        password_confirmation: app.password_confirmation,
                        token: app.token,
                        color: app.color.hex
                    },
                    success: function (res) {
                        this.showRegisteredModal = true;
                    },
                    error: function (res) {
                        app.has_error = true;
                        app.error = res.response.data.error;
                        app.errors = res.response.data.errors || {}
                    },
                    redirect: '',
                })
            },

            startTransitionModal() {
                this.$refs.backdrop.classList.toggle("d-block");
                this.$refs.modal.classList.toggle("d-block");
            },
            endTransitionModal() {
                this.$refs.backdrop.classList.toggle("show");
                this.$refs.modal.classList.toggle("show");
            },

            redirectToLogin() {
                this.showRegisteredModal = false;
                this.$router.push({name: 'login'})
            }
        }
    }
</script>