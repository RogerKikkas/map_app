<template>
    <div>
        <transition @enter="startTransitionModal" @after-enter="endTransitionModal" @before-leave="endTransitionModal" @after-leave="startTransitionModal">
            <div class="modal fade" v-show="open" ref="modal" @click.prevent="">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">You have successfully registered</h5>
                            <button class="close" type="button" @click="showModal = false"><span aria-hidden="true">×</span></button>
                        </div>
                        <div class="modal-body">
                            <h3>Setting up the GPS app</h3>
                            <ul>
                                <li>
                                    <h5>Set API url to</h5>
                                    <div class="input-group mb-3">
                                        <input type="text" class="form-control" aria-label="API Url" :value="apiURL" disabled>
                                        <div class="input-group-append">
                                            <button class="btn btn-outline-secondary" type="button" v-clipboard:copy="apiURL">Copy</button>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <h5>Set HTTP Method to</h5>
                                    <div class="input-group mb-3">
                                        <input type="text" class="form-control" aria-label="HTTP Method" :value="method" disabled>
                                        <div class="input-group-append">
                                            <button class="btn btn-outline-secondary" type="button" v-clipboard:copy="method">Copy</button>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <h5>Set HTTP Body to</h5>
                                    <div class="input-group mb-3">
                                        <input type="text" class="form-control" aria-label="HTTP Body" :value="httpBody" disabled>
                                        <div class="input-group-append">
                                            <button class="btn btn-outline-secondary" type="button" v-clipboard:copy="httpBody">Copy</button>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <h5>This setup uses GPS Logger app for android, HTTP body might be different for different apps.</h5>
                                </li>
                            </ul>
                            <h3>Your api token (included in HTTP body)</h3>
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" aria-label="API token" :value="token" disabled>
                                <div class="input-group-append">
                                    <button class="btn btn-outline-secondary" type="button" v-clipboard:copy="token">Copy</button>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-block btn-primary" type="button" @click.prevent="redirectToLogin()">Go to Login</button>
                        </div>
                    </div>
                </div>
            </div>
        </transition>
        <div class="modal-backdrop fade d-none" ref="backdrop"></div>
    </div>
</template>

<script>
    import { websiteURL } from '../app.js';

    export default {
        name: "APIModal",

        props: {
            open: Boolean,
            token: String,
        },

        data() {
            return {
                apiURL: websiteURL + '/log',
                method: 'POST',
                httpBody: '',
            }
        },

        mounted() {
            this.httpBody = 'lat=%LAT&lng=%LON&speed=%SPD&altitude=%ALT&travelled=%DIST&time=%TIME&token=' + this.token;
        },

        methods: {
            startTransitionModal() {
                this.$refs.backdrop.classList.toggle("d-block");
                this.$refs.modal.classList.toggle("d-block");
            },
            endTransitionModal() {
                this.$refs.backdrop.classList.toggle("show");
                this.$refs.modal.classList.toggle("show");
            },

            redirectToLogin() {
                this.$emit('toggleAPIModal');
                this.$router.push({name: 'login'})
            },
        }
    }
</script>

<style scoped>

</style>