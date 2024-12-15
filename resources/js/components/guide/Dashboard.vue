<template>
<div>
    <div class="row">
        <div class="col-md-12">
            <!-- Welcome Message -->
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Welcome, {{ user.name }}!</h5>
                    <p class="card-text">Last login: {{ user.last_login_at }}</p>
                </div>
            </div>
        </div>

        <div class="col-md-12">

            <LeadDashboard />

        </div>

        <!-- Dashboard Metrics -->
        <div class="col-md-4" v-for="metric in dashboardData" :key="metric.title">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">{{ metric.title }}</h5>
                    <p class="card-text">{{ metric.value }}</p>
                </div>
            </div>
        </div>

        <!-- Activity Logs -->
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Activity Logs</h5>

                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">Message</th>
                                <th scope="col">Created_at</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="log in activityLogs.slice(0, 5)" :key="log.id">
                                <td>{{ log.message }}</td>
                                <td>{{ formatTimeAgo(log.created_at) }}</td>
                            </tr>
                        </tbody>
                    </table>

                </div>
            </div>
        </div>

        <!-- Weekly Registered Users -->
        <div class="col-md-4">
            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="card-title">Weekly Registered Users</h5>
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">Week</th>
                                <th scope="col">Total Registered Users</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="week in weeklyRegisteredUsers" :key="week.week">
                                <td>{{ week.week }}</td>
                                <td>{{ week.totalUsers }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- New Students -->
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">New Students</h5>
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">Name</th>
                                <th scope="col">Last login</th>
                                <th scope="col">Registered At</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="student in newStudents.slice(0, 5)" :key="student.id">
                                <td>{{ student.name }}</td>
                                <td>{{ formatTimeAgo(student.last_login_at) }}</td>
                                <td>{{ formatTimeAgo(student.created_at) }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Ticket List -->
        <div class="col-md-12">

            <h5 class="  mb-1">Tickets</h5>
            <ul class="list-group">
                <li class="list-group-item" v-for="ticket in tickets.slice(0, 3)" :key="ticket.id">

                    <router-link :to="{ name: 'adminTicketDetails', params: { id: ticket.id } }" class="btn btn-info btn-sm me-2"> {{ ticket.title }}</router-link>

                </li>
            </ul>

        </div>

    </div>

</div>
</template>

<script>
import apiService from '@/apiservice';
import {
    formatDistanceToNow
} from 'date-fns';
import LeadDashboard from './LeadDashboard.vue';

export default {
    name: 'Dashboard',

    components: {
        LeadDashboard
    },

    data() {
        return {
            user: {},
            dashboardData: [],
            weeklyRegisteredUsers: [],
            activityLogs: [],
            newStudents: [],
            tickets: []
        };
    },
    created() {
        this.fetchUserData();
        this.fetchDashboardData();
        this.fetchWeeklyRegisteredUsers();
        this.fetchActivityLogs();
        this.fetchNewStudents();
        this.fetchTickets();
    },
    methods: {
        fetchUserData() {
            apiService.getUserData()
                .then(response => {
                    this.user = response.data;
                })
                .catch(error => {
                    console.error('Error fetching user data:', error);
                });
        },
        fetchDashboardData() {
            apiService.getDashboardData()
                .then(response => {
                    this.dashboardData = response.data;
                })
                .catch(error => {
                    console.error('Error fetching dashboard data:', error);
                });
        },
        fetchWeeklyRegisteredUsers() {
            apiService.getWeeklyRegisteredUsers()
                .then(response => {
                    this.weeklyRegisteredUsers = response.data;
                })
                .catch(error => {
                    console.error('Error fetching weekly registered users:', error);
                });
        },
        fetchActivityLogs() {
            apiService.getActivityLogs()
                .then(response => {
                    this.activityLogs = response.data;
                })
                .catch(error => {
                    console.error('Error fetching activity logs:', error);
                });
        },
        fetchNewStudents() {
            apiService.getNewStudents()
                .then(response => {
                    this.newStudents = response.data;
                })
                .catch(error => {
                    console.error('Error fetching new students:', error);
                });
        },

        fetchTickets() {
            apiService.getTickets()
                .then(response => {
                    this.tickets = response.data;
                })
                .catch(error => {
                    console.error('Error fetching tickets:', error);
                });
        },

        formatTimeAgo(date) {
            return formatDistanceToNow(new Date(date), {
                addSuffix: true
            });
        }
    }
};
</script>

<style scoped>
.card {

    margin-top: 15px;

    margin-bottom: 15px;
}
</style>
