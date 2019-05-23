<template>
    <div>
        <change-password-modal :open="showChangePasswordModal"
                               :admin=true
                               :selectedUserId="selectedUserId"
                               :selectedUserName="selectedUserName"
                               v-on:toggleChangePasswordModal="showChangePasswordModal = !showChangePasswordModal">
        </change-password-modal>

        <div class="alert alert-danger" v-if="error">
            {{ error }}
        </div>
        <h3>List of users</h3>
        <div class="table-responsive">
            <table class="table">
                <thead>
                <tr>
                    <th scope="col">Id</th>
                    <th scope="col">Name</th>
                    <th scope="col">Email</th>
                    <th scope="col">Role</th>
                    <th scope="col">Date of registration</th>
                    <th scope="col">Change password</th>
                    <th scope="col">Delete</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="user in users" v-bind:key="user.id" style="margin-bottom: 5px;">
                    <th scope="row">{{ user.id }}</th>
                    <td>{{ user.name }}</td>
                    <td>{{ user.email }}</td>
                    <td>{{ user.role === 2 ? 'admin' : 'user' }}</td>
                    <td>{{ user.created_at}}</td>
                    <td><button class="btn btn-success" @click.prevent="changeUserPassword(user.id, user.name)">🔑</button></td>
                    <td><button class="btn btn-danger" @click.prevent="deleteUser(user.id)">X</button></td>
                </tr>
                </tbody>
            </table>
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
                showChangePasswordModal: false,
                selectedUserId: 0,
                selectedUserName: '',
                error: ''
            }
        },

        methods: {
            deleteUser(id) {
                if (confirm("Do you really want to delete this user?")) {
                    let app = this;
                    Vue.axios.delete(`/users/${id}`)
                        .then(function(response) {
                            app.error = '';
                            Vue.delete(app.users, id);
                        })
                        .catch(function(error) {
                            app.error = error.response.data.errors;
                        })
                }
            },

            changeUserPassword(id, name) {
                this.selectedUserId = id;
                this.selectedUserName = name;
                this.showChangePasswordModal = true;
            }
        }
    }
</script>