<template>
    <div>
        <h2 class="mb-4">Create Ticket</h2>
        <form @submit.prevent="createTicket">
            <div class="mb-3">
                <label for="title" class="form-label">Title</label>
                <input v-model="title" type="text" class="form-control" id="title" placeholder="Title" required />
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea v-model="description" class="form-control" id="description" rows="3" placeholder="Description"
                    required></textarea>
            </div>
            <div class="mb-3">
                <label for="category" class="form-label">Category</label>
                <select v-model="category" class="form-control" id="category" required>
                    <option value="" disabled>Select Category</option>
                    <option v-for="cat in categories" :key="cat" :value="cat">{{ cat }}</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="priority" class="form-label">Priority</label>
                <select v-model="priority" class="form-control" id="priority" required>
                    <option value="" disabled>Select Priority</option>
                    <option v-for="prio in priorities" :key="prio" :value="prio">{{ prio }}</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Create</button>
        </form>
    </div>
</template>

<script>
import apiService from '@/apiservice';

export default {
    data() {
        return {
            title: '',
            description: '',
            category: '',
            priority: '',
            categories: [],
            priorities: []
        };
    },
    created() {
        this.fetchCategoriesAndPriorities();
    },
    methods: {
        fetchCategoriesAndPriorities() {
            apiService.getCategoriesAndPriorities()
                .then(response => {
                    this.categories = response.data.categories;
                    this.priorities = response.data.priorities;
                })
                .catch(error => {
                    console.error('Error fetching categories and priorities:', error);
                });
        },
        createTicket() {
            const ticketData = {
                title: this.title,
                description: this.description,
                category: this.category,
                priority: this.priority
            };
            apiService.createTicket(ticketData)
                .then(response => {
                    this.$emit('ticket-created', response.data);
                    alert("Ticket created");
                })
                .catch(error => {
                    console.error('Error creating ticket:', error);
                });
        }
    }
};
</script>