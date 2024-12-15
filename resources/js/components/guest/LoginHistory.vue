<template>
    <div>
        <h2 class="mb-4">Login History</h2>
        <div v-if="logins.length">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>IP Address</th>
                        <th>User Agent</th>
                        <th>Created At</th>
                        <th>Formatted Date</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="login in logins" :key="login.id">
                        <td>{{ login.ip_address }}</td>
                        <td>{{ login.user_agent }}</td>
                        <td>{{ $formatTimeAgo(login.created_at) }}</td>
                        <td>{{ $formatDate(login.created_at) }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div v-else>
            <p>No data available</p>
        </div>
    </div>
</template>

<script>
import { ref, onMounted } from 'vue';
import apiService from '@/apiGuestService.js';

export default {
    setup() {
        const logins = ref([]);

        const fetchLoginHistory = async () => {
            try {
                const response = await apiService.getLoginHistory();
                logins.value = response.data;
            } catch (error) {
                console.error('Error fetching login history:', error);
            }
        };

        onMounted(fetchLoginHistory);

        return {
            logins,
        };
    },
};
</script>