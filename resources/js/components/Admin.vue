<template>
    <div class="col-md-6 offset-md-3" style="margin-top:20px">
        <change-secret-code-modal :open="showChangeSecretCodeModal"
                               v-on:toggleChangeSecretCodeModal="showChangeSecretCodeModal = !showChangeSecretCodeModal">
        </change-secret-code-modal>

        <flash-message class="myCustomClass"></flash-message>

        <div class="card card-default">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12 text-center">
                        <user-list :users="users"></user-list>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 text-center">
                        <h3>Secret code</h3>
                        <div class="col-md-6 offset-md-3">
                            <button class="btn btn-block btn-outline-secondary" @click="showChangeSecretCodeModal = !showChangeSecretCodeModal">Change secret code</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    export default {
        props: {
            users: {
                type: Object/Array,
            },
        },

        data() {
            return {
                showChangeSecretCodeModal: false,
            }
        },
    }
</script>