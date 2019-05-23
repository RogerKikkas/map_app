<template>
    <div>
        <transition @enter="startTransitionModal" @after-enter="endTransitionModal" @before-leave="endTransitionModal" @after-leave="startTransitionModal">
            <div class="modal fade" v-show="open" ref="modal" @click.self="handleClose()">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Change secret code</h5>
                            <button class="close" type="button" @click="handleClose()"><span aria-hidden="true">×</span></button>
                        </div>
                        <div class="modal-body">
                            <div class="alert alert-danger" role="alert" v-if="errors" v-for="error in errors">
                                {{ error[0] }}
                            </div>
                            <form autocomplete="off" @submit.prevent="updateSecretCode()" method="post">
                                <div class="form-group row">
                                    <label class="col-4 col-form-label font-weight-bold">Secret Code: </label>
                                    <div class="col-8">
                                        <input v-model="secretCode" id="secretCode" name="secretCode" placeholder="Secret Code" class="form-control here" type="text" required>
                                    </div>
                                </div>
                                <button class="btn btn-block btn-primary" type="submit">Update secret code</button>
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
        name: "ChangeSecretCodeModal",

        props: {
            open: Boolean,
        },

        data() {
            return {
                secretCode: '',
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

            updateSecretCode() {
                let app = this;

                Vue.axios.post('/admin/changeSecretCode', {
                    secretCode: this.secretCode,
                }).then(function(response) {
                    app.flash('Secret code changed', 'success', {
                        timeout: 3000,
                    });
                    app.secretCode = '';
                    app.errors = '';
                    app.$emit('toggleChangeSecretCodeModal');
                }).catch(function(error) {
                    app.errors = error.response.data["errors"];
                });
            },

            handleClose() {
                this.$emit('toggleChangeSecretCodeModal');
            }
        }
    }
</script>

<style scoped>

</style>