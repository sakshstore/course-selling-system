<template>
<div>
    <h4>Ticket Details</h4>
    <b-spinner v-if="loading" label="Loading..." class="mt-3"></b-spinner>
    <b-card v-else class="mt-3 shadow-sm">
        <b-card-body>
            <b-card-title class="d-flex justify-content-between align-items-center">
                <span>#{{ ticket.id }} - {{ ticket.title }}</span>
                <b-badge variant="info">{{ ticket.status }}</b-badge>
            </b-card-title>
            <b-row class="mb-2">
                <b-col cols="6">
                    <b-card-sub-title><strong>Category:</strong> {{ ticket.category }}</b-card-sub-title>
                </b-col>
                <b-col cols="6">
                    <b-card-sub-title><strong>Priority:</strong>
                        <b-badge :variant="getPriorityVariant(ticket.priority)">{{ ticket.priority
                                }}</b-badge>
                    </b-card-sub-title>
                </b-col>
            </b-row>
            <b-card-text>
                <strong>Description:</strong> {{ ticket.description }}
            </b-card-text>
        </b-card-body>
    </b-card>

    <!-- Discussion Section -->
    <div class="mt-4">
        <h4 class="text-primary">Discussion</h4>
        <b-spinner v-if="loadingMessages" label="Loading..." class="mt-3"></b-spinner>
        <b-list-group v-else>
            <b-list-group-item v-for="message in messages" :key="message.id">
                <strong>{{ message.user ? message.user.name : 'Unknown User' }}:</strong> {{ message.message }}
                <small class="text-muted float-end">{{ new Date(message.created_at).toLocaleString() }}</small>
            </b-list-group-item>
        </b-list-group>
        <b-form-textarea v-model="newMessage" class="mt-3" rows="3" placeholder="Type your message here..."></b-form-textarea>
        <b-button @click="postMessage" variant="primary" class="mt-2">Post Message</b-button>
    </div>

    <b-alert v-if="error" variant="danger" class="mt-3" dismissible>
        {{ error }}
    </b-alert>
</div>
</template>

<script>
import {
    ref,
    onMounted
} from 'vue';
import apiService from '@/apiservice';

export default {
    setup() {
        const ticket = ref({});
        const messages = ref([]);
        const newMessage = ref('');
        const loading = ref(true);
        const loadingMessages = ref(true);
        const error = ref(null);

        const fetchTicketDetails = () => {
            const ticketId = this.$route.params.id;
            apiService.getTicketDetails(ticketId)
                .then(response => {
                    ticket.value = response.data;
                    loading.value = false;
                })
                .catch(() => {
                    error.value = 'Failed to load ticket details. Please try again later.';
                    loading.value = false;
                });
        };

        const fetchMessages = () => {
            const ticketId = this.$route.params.id;
            apiService.getMessages(ticketId)
                .then(response => {
                    messages.value = response.data;
                    loadingMessages.value = false;
                })
                .catch(() => {
                    error.value = 'Failed to load messages. Please try again later.';
                    loadingMessages.value = false;
                });
        };

        const postMessage = () => {
            const ticketId = this.$route.params.id;
            apiService.postMessage(ticketId, newMessage.value)
                .then(() => {
                    newMessage.value = '';
                    fetchMessages();
                })
                .catch(() => {
                    error.value = 'Failed to post message. Please try again later.';
                });
        };

        onMounted(() => {
            fetchTicketDetails();
            fetchMessages();
        });

        return {
            ticket,
            messages,
            newMessage,
            loading,
            loadingMessages,
            error,
            postMessage
        };
    }
};
</script>
