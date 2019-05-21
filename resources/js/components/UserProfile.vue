<template>
    <div class="col-md-4 offset-md-4" style="margin-top:20px">
        <api-modal :open="showAPIModal"
                   :token="$auth.user().api_token"
                   v-on:toggleAPIModal="showAPIModal = !showAPIModal"
                   :registered="false">
        </api-modal>
        <change-password-modal :open="showChangePasswordModal"
                   v-on:toggleChangePasswordModal="showChangePasswordModal = !showChangePasswordModal">
        </change-password-modal>

        <flash-message class="myCustomClass"></flash-message>

        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12 text-center">
                        <h4>Your Profile</h4>
                        <hr>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <form v-if="users[currentUser]">
                            <div class="form-group row">
                                <label class="col-4 col-form-label font-weight-bold">Name: </label>
                                <div class="col-8">
                                    <label class="col-form-label">{{ users[currentUser].name }}</label>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-4 col-form-label font-weight-bold">Email: </label>
                                <div class="col-8">
                                    <label class="col-form-label">{{ users[currentUser].email }}</label>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-4 col-form-label font-weight-bold">Color: </label>
                                <div class="col-8 input-group">
                                    <input type="text" id="color" class="form-control" :value="color.hex" disabled>
                                    <div class="input-group-append">
                                        <button class="btn btn-outline-secondary" type="button" @click="showColorPicker = !showColorPicker">Choose color</button>
                                    </div>
                                <chrome-picker class="color-picker" :value="users[currentUser].color" v-if="showColorPicker" v-model="color"></chrome-picker>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-4 col-form-label font-weight-bold">API Token: </label>
                                <div class="col-8">
                                    <button class="btn btn-block btn-outline-secondary" type="button" @click="showAPIModal = !showAPIModal">Show API guide</button>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-4 col-form-label font-weight-bold">Change password: </label>
                                <div class="col-8">
                                    <button class="btn btn-block btn-outline-secondary" type="button" @click="showChangePasswordModal = !showChangePasswordModal">Change password</button>
                                </div>
                            </div>
                            <!--
                            <div class="form-group row">
                                <label for="newpass" class="col-4 col-form-label">New Password</label>
                                <div class="col-8">
                                    <input id="newpass" name="newpass" placeholder="New Password" class="form-control here" type="text">
                                </div>
                            </div>
                            -->
                            <div class="form-group row">
                                <div class="offset-4 col-8">
                                    <button name="submit" type="submit" class="btn btn-primary" @click.prevent="updateUser(currentUser)">Update My Profile</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    require('vue-flash-message/dist/vue-flash-message.min.css');

    export default {

        props: {
            users: {
                type: Object/Array,
                required: true
            },
        },

        data() {
            return {
                errors: {},
                currentUser: this.$auth.user().id,
                showColorPicker: false,
                color: {},
                showAPIModal: false,
                showChangePasswordModal: false,
            }
        },

        mounted() {
            Vue.set(this.color, 'hex', this.$auth.user().color);
        },

        methods: {
            updateUser(id) {
                let app = this;
                Vue.axios.post(`/users/${id}`, {
                    color: this.color.hex
                }).then(function(response) {
                    Vue.set(app.users[id], 'color', app.color.hex);
                    app.flash('User updated', 'success', {
                        timeout: 3000,
                    });
                    app.showColorPicker = false;
                    // Small hack to show the correct color if user navigates to another component and comes back
                    // without refreshing
                    app.$auth.user().color = app.users[app.currentUser].color;
                }).catch(function(error) {
                    app.flash('User update failed', 'error', {
                        timeout: 3000,
                    });
                    app.showColorPicker = false;
                });
            }
        },

        components: {
            //
        }
    }
</script>