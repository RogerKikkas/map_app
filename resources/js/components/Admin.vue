<template>
    <div class="col-md-6 offset-md-3" style="margin-top:20px">
        <div class="card card-default">
            <div class="card-body">
                <user-list :users="users"></user-list>
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
                //
            }
        },
    }
</script>