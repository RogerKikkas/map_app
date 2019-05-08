<template>
    <div>
        <h3>List of users</h3>
        <div class="alert alert-danger" v-if="has_error">
            <p>Error, unable to retrieve user list</p>
        </div>
        <table class="table">
            <tr>
                <th scope="col">Id</th>
                <th scope="col">Name</th>
                <th scope="col">Email</th>
                <th scope="col">Role</th>
                <th scope="col">Date of registration</th>
            </tr>
            <tr v-for="user in users" v-bind:key="user.id" style="margin-bottom: 5px;">
                <th scope="row">{{ user.id }}</th>
                <td>{{ user.name }}</td>
                <td>{{ user.email }}</td>
                <td>{{ user.role === 2 ? 'admin' : 'user' }}</td>
                <td>{{ user.created_at}}</td>
            </tr>
        </table>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                has_error: false,
                users: null
            }
        },

        mounted() {
            this.getUsers()
        },

        methods: {
            getUsers() {
                Vue.axios.get('auth/users')
                    .then(response => this.users = response.data.users)
                    .catch((error) => this.has_error = true);
            }
        }
    }
</script>