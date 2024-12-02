<template>
    <div  >
        <h2 class="text-primary">Ticket Details</h2>
        <div v-if="loading" class="text-center mt-3">
            <div class="spinner-border" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>
        <div v-else class="card mt-3">
            <div class="card-body">
                <h5 class="card-title"><strong>ID:</strong> {{ ticket.id }}</h5>
                <h5 class="card-title"><strong>Title:</strong> {{ ticket.title }}</h5>
                <h5 class="card-title"><strong>Category:</strong> {{ ticket.category }}</h5>
                <h5 class="card-title"><strong>Priority:</strong> {{ ticket.priority }}</h5>
                <p class="card-text"><strong>Description:</strong> {{ ticket.description }}</p>
                <small class="text-muted"><strong>Status:</strong> {{ ticket.status }}</small>
            </div>
        </div>

        <!-- Discussion Section -->
        <div class="mt-4">
            <h4 class="text-primary">Discussion</h4>
            <div v-if="loadingMessages" class="text-center mt-3">
                <div class="spinner-border" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
            </div>
            <ul v-else class="list-group">
                <li v-for="message in messages" :key="message.id" class="list-group-item">
                    <strong>{{ message.user ? message.user.name : 'Unknown User' }}:</strong> {{ message.message }}
                    <small class="text-muted float-end">{{ new Date(message.created_at).toLocaleString() }}</small>
                </li>
            </ul>
            <div class="mt-3">
                <textarea v-model="newMessage" class="form-control" rows="3"
                    placeholder="Type your message here..."></textarea>
                <button @click="postMessage" class="btn btn-primary mt-2">Post Message</button>
            </div>
        </div>

        <div v-if="error" class="alert alert-danger mt-3" role="alert">
            {{ error }}
        </div>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    data() {
        return {
            ticket: {},
            messages: [],
            newMessage: '',
            loading: true,
            loadingMessages: true,
            error: null
        };
    },
    created() {
        this.fetchTicketDetails();
        this.fetchMessages();
    },
    methods: {
        fetchTicketDetails() {
            const ticketId = this.$route.params.id;
            axios.get(`/v1/admin/tickets/${ticketId}`)
                .then(response => {
                    this.ticket = response.data;
                    this.loading = false;

                    
                })
                .catch(error => {
                    this.error = 'Failed to load ticket details. Please try again later.';
                    this.loading = false;
                });
        },
        fetchMessages() {
            const ticketId = this.$route.params.id;
            axios.get(`/v1/admin/tickets/${ticketId}/messages`)
                .then(response => {
                    this.messages = response.data;
                    this.loadingMessages = false;
                })
                .catch(error => {
                    this.error = 'Failed to load messages. Please try again later.';
                    this.loadingMessages = false;
                });
        },
        postMessage() {
            const ticketId = this.$route.params.id;
            axios.post(`/v1/admin/tickets/${ticketId}/messages`, { message: this.newMessage })
                .then(response => {
           
                
                    this.newMessage = ''; 
                   
                    this.fetchMessages();
                })
                .catch(error => {
                    this.error = 'Failed to post message. Please try again later.';
                });
        }
    }
};
</script>