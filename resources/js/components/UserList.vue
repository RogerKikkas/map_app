<template>
    <div>
        <div class="alert alert-danger" v-if="error">
            {{ error }}
        </div>
        <h3>List of users</h3>
        <table class="table">
            <tr>
                <th scope="col">Id</th>
                <th scope="col">Name</th>
                <th scope="col">Email</th>
                <th scope="col">Role</th>
                <th scope="col">Date of registration</th>
                <th scope="col">Delete</th>
            </tr>
            <tr v-for="user in users" v-bind:key="user.id" style="margin-bottom: 5px;">
                <th scope="row">{{ user.id }}</th>
                <td>{{ user.name }}</td>
                <td>{{ user.email }}</td>
                <td>{{ user.role === 2 ? 'admin' : 'user' }}</td>
                <td>{{ user.created_at}}</td>
                <td><button class="btn btn-danger" @click.prevent="deleteUser(user.id)">X</button></td>
            </tr>
        </table>
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
            }
        }
    }
</script>