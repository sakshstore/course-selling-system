<template>
    <div  >
        <h2 class="mb-4">Login History</h2>
        <ul class="list-group">
            <li class="list-group-item" v-for="login in logins" :key="login.id">
                {{ login.ip_address }} - {{ formatTimeAgo(login.created_at) }}
            </li>
        </ul>
    </div>
</template>

<script>
import axios from 'axios';
import { formatDistanceToNow } from 'date-fns';

export default {
    data() {
        return {
            logins: []
        };
    },
    created() {
        this.fetchLoginHistory();
    },
    methods: {
        fetchLoginHistory() {
            axios.get('/v1/login-history')
                .then(response => {
                    this.logins = response.data;
                });
        },
        formatTimeAgo(date) {
            return formatDistanceToNow(new Date(date), { addSuffix: true });
        }
    }
};
</script>