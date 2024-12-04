<template>
    <div>
        <h2 class="mb-4">Event Scores</h2>
        <ul class="list-group mb-4">
            <li v-for="eventScore in eventScores" :key="eventScore.id"
                class="list-group-item d-flex justify-content-between align-items-center">
                <div>
                    <strong>{{ eventScore.event_name }}</strong>
                    <p class="mb-1">Score: {{ eventScore.score }}</p>
                </div>
                <div>
                    <button @click="editEventScore(eventScore)" class="btn btn-primary btn-sm me-2">Edit</button>
                    <button @click="deleteEventScore(eventScore.id)" class="btn btn-danger btn-sm">Delete</button>
                </div>
            </li>
        </ul>
        <button @click="showCreateForm = !showCreateForm" class="btn btn-success mb-4">Create New Event Score</button>
        <div v-if="showCreateForm" class="card card-body mb-4">
            <h3>Create Event Score</h3>
            <form @submit.prevent="createEventScore">
                <div class="mb-3">
                    <label class="form-label">Event Name:</label>
                    <select v-model="newEventScore.event_name" class="form-control" required>
                        <option v-for="event in events" :key="event" :value="event">{{ event }}</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Score:</label>
                    <input v-model="newEventScore.score" type="number" class="form-control" required />
                </div>
                <button type="submit" class="btn btn-primary">Create</button>
            </form>
        </div>
        <div v-if="editingEventScore" class="card card-body">
            <h3>Edit Event Score</h3>
            <form @submit.prevent="updateEventScore">
                <div class="mb-3">
                    <label class="form-label">Event Name:</label>
                    <select v-model="editingEventScore.event_name" class="form-control" required>
                        <option v-for="event in events" :key="event" :value="event">{{ event }}</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Score:</label>
                    <input v-model="editingEventScore.score" type="number" class="form-control" required />
                </div>
                <button type="submit" class="btn btn-primary">Update</button>
            </form>
        </div>
    </div>
</template>

<script>
import apiService from '@/apiService.js';

export default {
    data() {
        return {
            eventScores: [],
            newEventScore: { event_name: '', score: 0 },
            editingEventScore: null,
            events: [],
            showCreateForm: false
        };
    },
    mounted() {
        this.fetchEventScores();
        this.fetchEvents();
    },
    methods: {
        async fetchEventScores() {
            try {
                const response = await apiService.getEventScores();
                this.eventScores = response.data;
            } catch (error) {
                console.error('Error fetching event scores:', error);
            }
        },
        async fetchEvents() {
            try {
                const response = await apiService.getEvents();
                this.events = response.data;
            } catch (error) {
                console.error('Error fetching events:', error);
            }
        },
        async createEventScore() {
            try {
                const response = await apiService.createEventScore(this.newEventScore);
                this.eventScores.push(response.data);
                this.newEventScore = { event_name: '', score: 0 };
                this.showCreateForm = false;
            } catch (error) {
                console.error('Error creating event score:', error);
            }
        },
        editEventScore(eventScore) {
            this.editingEventScore = { ...eventScore };
        },
        async updateEventScore() {
            try {
                const response = await apiService.updateEventScore(this.editingEventScore.id, this.editingEventScore);
                const index = this.eventScores.findIndex(es => es.id === this.editingEventScore.id);
                this.$set(this.eventScores, index, response.data);
                this.editingEventScore = null;
            } catch (error) {
                console.error('Error updating event score:', error);
            }
        },
        async deleteEventScore(id) {
            try {
                await apiService.deleteEventScore(id);
                this.eventScores = this.eventScores.filter(eventScore => eventScore.id !== id);
            } catch (error) {
                console.error('Error deleting event score:', error);
            }
        }
    }
};
</script>