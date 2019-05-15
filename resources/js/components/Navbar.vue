<template>
    <nav id="navbar" class="navbar navbar-expand-md navbar-dark bg-dark fixed-top" role="navigation">
        <router-link class="navbar-brand" to="/map">Map</router-link>

        <!-- Collapse button -->
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#basicExampleNav"
                aria-controls="basicExampleNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Collapsible content -->
        <div class="collapse navbar-collapse" id="basicExampleNav">

            <!-- Links -->
            <ul class="navbar-nav mr-auto">

                <!-- Dropdown -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="navbarDropdownMenuLink" data-toggle="dropdown"
                       aria-haspopup="true" aria-expanded="false">Users</a>
                    <div class="dropdown-menu dropdown-primary" aria-labelledby="navbarDropdownMenuLink">
                        <div class="dropdown-item" v-for="user in users" @click.stop="toggleUser(user.id)" :key="user.id">
                            <input type="checkbox" :checked="user.showCoordinates">{{ user.name }}
                        </div>
                    </div>
                </li>

                <li class="nav-item">
                    <date-range-picker
                            v-model="dateRange"
                            :start-date="userStartDate"
                            :end-date="userEndDate"
                            @update="dateUpdate()"
                            :locale-data="locale"
                            :opens="opens"
                    >
                    </date-range-picker>
                </li>

            </ul>

            <div class="dropdown-divider"></div>

            <!-- Links -->
            <ul class="navbar-nav">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="navbarUserDropdownLink" data-toggle="dropdown"
                       role="button" aria-haspopup="true" aria-expanded="false">{{ $auth.user().name }}</a>
                    <div class="dropdown-menu dropdown-primary" id="navbarUserDropdownMenu" aria-labelledby="navbarUserDropdownLink">
                        <router-link class="dropdown-item" to="/user">Profile</router-link>
                        <router-link class="dropdown-item" v-if="$auth.check(2)" to="/admin">Admin</router-link>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" v-if="$auth.check()" @click="$auth.logout({
                            makeRequest: true,
                            redirect: '/login'
                        })">Logout</a>
                    </div>
                </li>
            </ul>

        </div>
    </nav>
</template>

<script>
    import * as moment from 'moment';
    import DateRangePicker from 'vue2-daterange-picker';
    import 'vue2-daterange-picker/dist/lib/vue-daterange-picker.min.css';

    export default {
        name: "Navbar",

        components: { DateRangePicker },

        props: {
            users: {
                type: Object/Array,
                    required: true
            },
            userStartDate: {
                type: Object/Array,
                default: moment().subtract(1, 'days'),
            },
            userEndDate: {
                type: Object/Array,
                default: moment(),
            }
        },

        data() {
            return {
                dateRange: {
                    startDate: moment(),
                    endDate: moment()
                },
                opens: "right",
                locale: {
                    direction: 'ltr',
                    format: 'DD-MM-YYYY',
                    separator: ' - ',
                    applyLabel: 'Apply',
                    cancelLabel: 'Cancel',
                    weekLabel: 'W',
                    customRangeLabel: 'Custom Range',
                    daysOfWeek: moment.weekdaysMin(), //array of days - see moment documenations for details
                    monthNames: moment.monthsShort(), //array of month names - see moment documenations for details
                    firstDay: 1, //ISO first day of week - see moment documentations for details
                    showWeekNumbers: true, //show week numbers on each row of the calendar
                    showDropdowns: true,
                },
                ranges: { //default value for ranges object (if you set this to false ranges will no be rendered)
                    'Today': [moment(), moment()],
                    'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    'This month': [moment().startOf('month'), moment().endOf('month')],
                    'This year': [moment().startOf('year'), moment().endOf('year')],
                    'Last week': [moment().subtract(1, 'week').startOf('week'), moment().subtract(1, 'week').endOf('week')],
                    'Last month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
                }
            }
        },

        methods: {
            toggleUser(id) {
                let user = this.users[id];

                if (user.showCoordinates) {
                    user.coordinates = [];
                    user.showCoordinates = false;
                } else {
                    this.getUserCoordinates(id);
                }
            },

            getUserCoordinates(id) {
                let app = this;
                Vue.axios.get(`/userCoordinates/${id}`).then(function(response) {
                    response.data[0].showCoordinates = true;
                    Vue.set(app.users, id, response.data[0]);
                });
            },

            dateUpdate() {
                Vue.set(this.userStartDate, this.dateRange.startDate);
                Vue.set(this.userEndDate, this.dateRange.endDate);
            }
        }

    }
</script>

<style scoped>

</style>