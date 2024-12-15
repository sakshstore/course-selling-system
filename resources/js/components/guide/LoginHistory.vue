<template>
    <div>
        <h2 class="mb-4">Login History</h2>
        <table class="table table-bordered">
            <tr v-for="login in logins" :key="login.id">
                <td>{{ login.ip_address }}</td>
                <td>{{ formatTimeAgo(login.created_at) }}</td>
            </tr>
        </table>
    </div>
</template>

<script>
import apiService from '@/apiService.js';
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
        async fetchLoginHistory() {
            try {
                const response = await apiService.getLoginHistory();
                this.logins = response.data;
            } catch (error) {
                console.error('Error fetching login history:', error);
            }
        },
        formatTimeAgo(date) {
            return formatDistanceToNow(new Date(date), { addSuffix: true });
        }
    }
};
</script>