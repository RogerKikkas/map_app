<template>
    <div class="col-md-4 offset-md-4" style="margin-top:20px">
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
                                    <input type="text" id="color" class="form-control" :value="users[currentUser].color" disabled>
                                    <div class="input-group-append">
                                        <button class="btn btn-outline-secondary" type="button" @click="showColorPicker = !showColorPicker">Choose color</button>
                                    </div>
                                <chrome-picker class="color-picker" :value="users[currentUser].color" v-if="showColorPicker" v-model="color" @input="updateColor()"></chrome-picker>
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
                                    <button name="submit" type="submit" class="btn btn-primary" @click.prevent="">Update My Profile</button>
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
            }
        },

        methods: {
            updateColor() {
                Vue.set(this.users[this.currentUser], 'color', this.color.hex);
            }
        },

        components: {
            //
        }
    }
</script>