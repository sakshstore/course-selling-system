<template>
    <div class=" ">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="text-primary">Support Ticket</h2>
        </div>
        <div v-if="loading" class="text-center">
            <div class="spinner-border text-primary" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>
        <ul v-else class="list-group">
            <li v-for="ticket in tickets" :key="ticket.id"
                class="list-group-item d-flex justify-content-between align-items-center mb-2 border-2">
                <div>
                    <h5 class="mb-2">{{ ticket.id }} - {{ ticket.title }}</h5>
                    <small class="text-muted">
                        <span class="badge bg-secondary me-2">{{ ticket.category }}</span>
                        <span class="badge bg-info">{{ ticket.status }}</span>
                    </small>
                </div>
                <div>
                    <router-link :to="{ name: 'adminTicketDetails', params: { id: ticket.id } }"
                        class="btn btn-info btn-sm me-2">View Ticket</router-link>
                    <button @click="closeTicket(ticket.id)" class="btn btn-danger btn-sm">Close Ticket</button>
                </div>
            </li>
        </ul>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    data() {
        return {
            tickets: [],
            loading: false
        };
    },
    created() {
        this.fetchTickets();
    },
    methods: {
        async fetchTickets() {
            this.loading = true;
            try {
                const response = await axios.get('/v1/admin/tickets_list');
                this.tickets = response.data;
            } catch (error) {
                console.error('Error fetching tickets:', error);
            } finally {
                this.loading = false;
            }
        },
        async closeTicket(id) {
            try {
                await axios.put(`/v1/admin/tickets/${id}`, { status: 'closed' });
                this.fetchTickets();
            } catch (error) {
                console.error('Error closing ticket:', error);
            }
        }
    }
};
</script>

<style>
.list-group-item {
    border-radius: 10px;
    padding: 15px;
    margin-bottom: 10px;
}

.badge {
    font-size: 0.9em;
}

.spinner-border {
    width: 3rem;
    height: 3rem;
}
</style>