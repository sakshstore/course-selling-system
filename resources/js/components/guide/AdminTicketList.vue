<template>
    <div>
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="text-primary">Support Ticket</h2>
        </div>
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <label for="filterStatus" class="form-label me-2">Filter by Status:</label>
                <select v-model="filterStatus" class="form-select" id="filterStatus">
                    <option value="all">All</option>
                    <option value="open">Open</option>
                    <option value="closed">Closed</option>
                </select>
            </div>
            <div>
                <label for="filterPriority" class="form-label me-2">Filter by Priority:</label>
                <select v-model="filterPriority" class="form-select" id="filterPriority">
                    <option value="all">All</option>
                    <option v-for="prio in priorities" :key="prio" :value="prio">{{ prio }}</option>
                </select>
            </div>
            <div>
                <label for="filterCategory" class="form-label me-2">Filter by Category:</label>
                <select v-model="filterCategory" class="form-select" id="filterCategory">
                    <option value="all">All</option>
                    <option v-for="cat in categories" :key="cat" :value="cat">{{ cat }}</option>
                </select>
            </div>
        </div>
        <div v-if="loading" class="text-center">
            <div class="spinner-border text-primary" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>
        <ul v-else class="list-group">
            <li v-for="ticket in filteredTickets" :key="ticket.id"
                class="list-group-item d-flex justify-content-between align-items-center mb-2 border-2">
                <div>
                    <h5 class="mb-2">{{ ticket.id }} - {{ ticket.title }}</h5>
                    <small class="text-muted">
                        <span class="badge bg-secondary me-2">{{ ticket.category }}</span>
                        <span class="badge bg-info me-2">{{ ticket.priority }}</span>
                        <span class="badge bg-success">{{ ticket.status }}</span>
                    </small>
                </div>
                <div>
                    <router-link :to="{ name: 'adminTicketDetails', params: { id: ticket.id } }"
                        class="btn btn-info btn-sm me-2">View Ticket</router-link>
                    <button v-if="ticket.status!='closed'"  @click="closeTicket(ticket.id)" class="btn btn-danger btn-sm">Close Ticket</button>
                </div>
            </li>
        </ul>
    </div>
</template>

<script>
import apiService from '@/apiService';

export default {
    data() {
        return {
            tickets: [],
            loading: false,
            filterStatus: 'all',
            filterPriority: 'all',
            filterCategory: 'all',
            priorities: ['Low', 'Medium', 'High', 'Urgent'], // Assuming these are the priorities
            categories: [] // This will be fetched from the API
        };
    },
    computed: {
        filteredTickets() {
            return this.tickets.filter(ticket => {
                const statusMatch = this.filterStatus === 'all' || ticket.status === this.filterStatus;
                const priorityMatch = this.filterPriority === 'all' || ticket.priority === this.filterPriority;
                const categoryMatch = this.filterCategory === 'all' || ticket.category === this.filterCategory;
                return statusMatch && priorityMatch && categoryMatch;
            });
        }
    },
    created() {
        this.fetchTickets();
        this.fetchCategoriesAndPriorities();
    },
    methods: {
        async fetchTickets() {
            this.loading = true;
            try {
                const response = await apiService.getTickets();
                this.tickets = response.data;
            } catch (error) {
                console.error('Error fetching tickets:', error);
            } finally {
                this.loading = false;
            }
        },
        async fetchCategoriesAndPriorities() {
            try {
                const response = await apiService.getCategoriesAndPriorities();
                this.categories = response.data.categories;
                this.priorities = response.data.priorities;
            } catch (error) {
                console.error('Error fetching categories and priorities:', error);
            }
        },
        async closeTicket(id) {
            try {
                await apiService.closeTicket(id);
                this.fetchTickets();
            } catch (error) {
                console.error('Error closing ticket:', error);
            }
        }
    }
};
</script>