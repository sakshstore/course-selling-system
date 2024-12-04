<template>
    <div>
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="text-primary">Ticket Management</h2>
            <button class="btn btn-success" @click="showCreateTicketModal = true">Create New Ticket</button>
        </div>
        <div v-if="loading" class="text-center">
            <div class="spinner-border text-primary" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>
        <ul v-else class="list-group">
            <li v-for="ticket in tickets" :key="ticket.id"
                class="list-group-item d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="mb-2"><strong>ID:</strong> {{ ticket.id }} - {{ ticket.title }}</h5>
                    <small class="text-muted">
                        <span class="badge bg-secondary me-2">{{ ticket.category }}</span>
                        <span class="badge bg-info me-2">{{ ticket.priority }}</span>
                        <span class="badge bg-success">{{ ticket.status }}</span>
                    </small>
                </div>
                <div>
                    <router-link :to="{ name: 'authTicketDetails', params: { id: ticket.id } }"
                        class="btn btn-info btn-sm me-2">View Ticket</router-link>
                    <button @click="closeTicket(ticket.id)" class="btn btn-danger btn-sm">Close Ticket</button>
                </div>
            </li>
        </ul>

        <!-- Create Ticket Modal -->
        <div v-if="showCreateTicketModal" class="modal fade show d-block" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Create New Ticket</h5>
                        <button type="button" class="btn-close" @click="showCreateTicketModal = false"></button>
                    </div>
                    <div class="modal-body">
                        <form @submit.prevent="createTicket">
                            <div class="mb-3">
                                <label for="title" class="form-label">Title</label>
                                <input v-model="newTicket.title" type="text" class="form-control" id="title"
                                    placeholder="Enter ticket title" required />
                            </div>
                            <div class="mb-3">
                                <label for="description" class="form-label">Description</label>
                                <textarea v-model="newTicket.description" class="form-control" id="description" rows="3"
                                    placeholder="Enter ticket description" required></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="category" class="form-label">Category</label>
                                <select v-model="newTicket.category" class="form-control" id="category" required>
                                    <option value="" disabled>Select Category</option>
                                    <option v-for="cat in categories" :key="cat" :value="cat">{{ cat }}</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="priority" class="form-label">Priority</label>
                                <select v-model="newTicket.priority" class="form-control" id="priority" required>
                                    <option value="" disabled>Select Priority</option>
                                    <option v-for="prio in priorities" :key="prio" :value="prio">{{ prio }}</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="attachment" class="form-label">Attachment</label>
                                <input type="file" class="form-control" id="attachment" @change="handleFileUpload" />
                            </div>
                            <button type="submit" class="btn btn-primary">Create Ticket</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import apiService from '@/apiService.js';

export default {
    data() {
        return {
            tickets: [],
            showCreateTicketModal: false,
            newTicket: {
                title: '',
                description: '',
                category: '',
                priority: '',
                attachment: null
            },
            categories: [],
            priorities: [],
            loading: false
        };
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
        handleFileUpload(event) {
            this.newTicket.attachment = event.target.files[0];
        },
        async createTicket() {
            const formData = new FormData();
            formData.append('title', this.newTicket.title);
            formData.append('description', this.newTicket.description);
            formData.append('category', this.newTicket.category);
            formData.append('priority', this.newTicket.priority);
            if (this.newTicket.attachment) {
                formData.append('attachment', this.newTicket.attachment);
            }

            try {
                const response = await apiService.createTicket(formData);
                this.tickets.push(response.data);
                this.showCreateTicketModal = false;
                this.newTicket = { title: '', description: '', category: '', priority: '', attachment: null };
            } catch (error) {
                console.error('Error creating ticket:', error);
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