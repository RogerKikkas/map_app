<template>
    <div>
        <transition @enter="startTransitionModal" @after-enter="endTransitionModal" @before-leave="endTransitionModal" @after-leave="startTransitionModal">
            <div class="modal fade" v-show="open" ref="modal">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Change password</h5>
                            <button class="close" type="button" @click="handleClose()"><span aria-hidden="true">×</span></button>
                        </div>
                        <div class="modal-body">
                            <div class="alert alert-danger" role="alert" v-if="error">
                                {{ error }}
                            </div>
                            <form autocomplete="off" @submit.prevent="updatePassword($auth.user().id)" method="post">
                                <div class="form-group row">
                                    <label class="col-4 col-form-label font-weight-bold">Current password: </label>
                                    <div class="col-8">
                                        <input v-model="current_password" id="currentPass" name="currentPass" placeholder="Current password" class="form-control here" type="password" required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-4 col-form-label font-weight-bold">New password: </label>
                                    <div class="col-8">
                                        <input v-model="new_password" id="newPass" name="newPass" placeholder="New password" class="form-control here" type="password" required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-4 col-form-label font-weight-bold">New password confirmation: </label>
                                    <div class="col-8">
                                        <input v-model="new_password_confirmation" id="newPassConfirm" name="newPassConfirm" placeholder="New password confirmation" class="form-control here" type="password" required>
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
        },

        data() {
            return {
                current_password: '',
                new_password: '',
                new_password_confirmation: '',
                error: '',
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

                if (!this.current_password) return;

                Vue.axios.post(`/users/${id}`, {
                    current_password: this.current_password,
                    new_password: this.new_password,
                    new_password_confirmation: this.new_password_confirmation,
                }).then(function(response) {
                    app.flash('Password changed', 'success', {
                        timeout: 3000,
                    });
                    app.current_password = '';
                    app.new_password = '';
                    app.new_password_confirmation = '';
                    app.error = '';
                    app.$emit('toggleChangePasswordModal');
                }).catch(function(error) {
                    app.error = error.response.data["errors"];
                });
            },

            handleClose() {
                this.$emit('toggleChangePasswordModal');
            }
        }
    }
</script>

<style scoped>

</style>