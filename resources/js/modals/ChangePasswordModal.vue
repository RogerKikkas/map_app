<template>
    <div>
        <transition @enter="startTransitionModal" @after-enter="endTransitionModal" @before-leave="endTransitionModal" @after-leave="startTransitionModal">
            <div class="modal fade" v-show="open" ref="modal" @click.self="handleClose()">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" v-if="!admin">Change password</h5>
                            <h5 class="modal-title" v-if="admin">Change password for user: {{ selectedUserName }}</h5>
                            <button class="close" type="button" @click="handleClose()"><span aria-hidden="true">×</span></button>
                        </div>
                        <div class="modal-body">
                            <div class="alert alert-danger" role="alert" v-if="errors" v-for="error in errors">
                                {{ error[0] }}
                            </div>
                            <form autocomplete="off" @submit.prevent="updatePassword($auth.user().id)" method="post">
                                <div class="form-group row" v-if="!admin">
                                    <label class="col-4 col-form-label font-weight-bold">Current password: </label>
                                    <div class="col-8">
                                        <input v-model="currentPassword" id="currentPass" name="currentPass" placeholder="Current password" class="form-control here" type="password" required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-4 col-form-label font-weight-bold">New password: </label>
                                    <div class="col-8">
                                        <input v-model="newPassword" id="newPass" name="newPass" placeholder="New password" class="form-control here" type="password" required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-4 col-form-label font-weight-bold">New password confirmation: </label>
                                    <div class="col-8">
                                        <input v-model="newPasswordConfirmation" id="newPassConfirm" name="newPassConfirm" placeholder="New password confirmation" class="form-control here" type="password" required>
                                    </div>
                                </div>
                                <button class="btn btn-block btn-primary" type="submit">Update password</button>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-block btn-danger" type="button" @click.prevent="handleClose()">Close modal</button>
                        </div>
                    </div>
                </div>
            </div>
        </transition>

        <div class="modal-backdrop fade d-none" ref="backdrop"></div>
    </div>
</template>

<script>
    export default {
        name: "ChangePasswordModal",

        props: {
            open: Boolean,
            admin: {
                type: Boolean,
                default: false
            },
            selectedUserId: {
                type: Number,
                default: 0
            },
            selectedUserName: {
                type: String,
                default: ''
            },
        },

        data() {
            return {
                currentPassword: '',
                newPassword: '',
                newPasswordConfirmation: '',
                errors: '',
            }
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

            updatePassword(id) {
                let app = this;

                // If admin then calls a different function
                if (this.admin) {
                    Vue.axios.post('/admin/changeUserPassword', {
                        userId: this.selectedUserId,
                        newPassword: this.newPassword,
                        newPassword_confirmation: this.newPasswordConfirmation
                    }).then(function(response) {
                        app.flash('Users password changed', 'success', {
                            timeout: 3000,
                        });
                        app.newPassword = '';
                        app.newPasswordConfirmation = '';
                        app.errors = '';
                        app.$emit('toggleChangePasswordModal');
                    }).catch(function(error) {
                        app.errors = error.response.data["errors"];
                    });
                } else {
                    if (!this.currentPassword) return;

                    Vue.axios.post(`/users/${id}`, {
                        currentPassword: this.currentPassword,
                        newPassword: this.newPassword,
                        newPassword_confirmation: this.newPasswordConfirmation,
                    }).then(function(response) {
                        app.flash('Password changed', 'success', {
                            timeout: 3000,
                        });
                        app.currentPassword = '';
                        app.newPassword = '';
                        app.newPasswordConfirmation = '';
                        app.errors = '';
                        app.$emit('toggleChangePasswordModal');
                    }).catch(function(error) {
                        app.errors = error.response.data["errors"];
                    });
                }
            },

            handleClose() {
                this.$emit('toggleChangePasswordModal');
            }
        }
    }
</script>

<style scoped>

</style>