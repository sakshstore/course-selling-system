<template>
    <div>
        <div v-if="loginHistory.length" class="mt-3">
            <h4>Login History</h4>
            <ul class="list-group">
                <li v-for="login in loginHistory" :key="login.id" class="list-group-item">
                    {{ formatTimeAgo(login.created_at) }} from {{ login.ip_address }}
                </li>
            </ul>
        </div>
    </div>
</template>

<script>
import { formatDistanceToNow } from 'date-fns';
import apiService from '@/apiService';


export default {
    props: {
        studentId: {
            type: String,
            required: true,
        },
    },
    data() {
        return {
            loginHistory: [],
        };
    },
    created() {
        this.fetchLoginHistory();
    },
    methods: {
        fetchLoginHistory() {
            apiService.getLoginHistory(this.studentId)
                .then(response => {
                    this.loginHistory = response.data;
                })
                .catch(error => {
                    console.error('Error fetching login history:', error);
                });
        },
        formatTimeAgo(date) {
            return formatDistanceToNow(new Date(date), { addSuffix: true });
        }
    }
};
</script>