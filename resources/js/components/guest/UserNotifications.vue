<template>
    <div>
        <h2 class="mb-4">User Notifications</h2>
        <ul class="list-group">
            <li class="list-group-item" v-for="notification in notifications" :key="notification.id">
                {{ notification.data.message }} - {{ formatTimeAgo(notification.created_at) }}
            </li>
        </ul>
    </div>
</template>

Script
<script>
import apiService from '@/apiGuestService.js';
import { formatDistanceToNow } from 'date-fns';

export default {
    data() {
        return {
            notifications: []
        };
    },
    created() {
        this.fetchNotifications();
    },
    methods: {
        async fetchNotifications() {
            try {
                const response = await apiService.getNotifications();
                this.notifications = response.data;
            } catch (error) {
                console.error('Error fetching notifications:', error);
            }
        },
        formatTimeAgo(date) {
            return formatDistanceToNow(new Date(date), { addSuffix: true });
        }
    }
};
</script>