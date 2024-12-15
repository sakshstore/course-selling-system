<template>
    <div>
        <h2 class="mb-4">Badges</h2>
        <ul class="list-group mb-4">
            <li v-for="badge in badges" :key="badge.id"
                class="list-group-item d-flex justify-content-between align-items-center">
                <div>
                    <img :src="badge.icon" alt="badge.name" class="img-thumbnail me-3"
                        style="width: 50px; height: 50px;" />
                    <strong>{{ badge.name }}</strong>
                    <p class="mb-1">{{ badge.description }}</p>
                </div>
                <div>
                    <button @click="editBadge(badge)" class="btn btn-primary btn-sm me-2">Edit</button>
                    <button @click="deleteBadge(badge.id)" class="btn btn-danger btn-sm">Delete</button>
                </div>
            </li>
        </ul>
        <button @click="showCreateForm = !showCreateForm" class="btn btn-success mb-4">Create New Badge</button>
        <div v-if="showCreateForm" class="card card-body mb-4">
            <h3>Create Badge</h3>
            <form @submit.prevent="createBadge">
                <div class="mb-3">
                    <label class="form-label">Name:</label>
                    <input v-model="newBadge.name" class="form-control" required />
                </div>
                <div class="mb-3">
                    <label class="form-label">Description:</label>
                    <input v-model="newBadge.description" class="form-control" required />
                </div>
                <div class="mb-3">
                    <label class="form-label">Icon URL:</label>
                    <input v-model="newBadge.icon" class="form-control" required />
                </div>
                <div class="mb-3">
                    <label class="form-label">Event Name:</label>
                    <select v-model="newBadge.event_name" class="form-control" required>
                        <option v-for="event in events" :key="event" :value="event">{{ event }}</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Create</button>
            </form>
        </div>
        <div v-if="editingBadge" class="card card-body">
            <h3>Edit Badge</h3>
            <form @submit.prevent="updateBadge">
                <div class="mb-3">
                    <label class="form-label">Name:</label>
                    <input v-model="editingBadge.name" class="form-control" required />
                </div>
                <div class="mb-3">
                    <label class="form-label">Description:</label>
                    <input v-model="editingBadge.description" class="form-control" required />
                </div>
                <div class="mb-3">
                    <label class="form-label">Icon URL:</label>
                    <input v-model="editingBadge.icon" class="form-control" required />
                </div>
                <div class="mb-3">
                    <label class="form-label">Event Name:</label>
                    <select v-model="editingBadge.event_name" class="form-control" required>
                        <option v-for="event in events" :key="event" :value="event">{{ event }}</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Update</button>
            </form>
        </div>
    </div>
</template>

<script>
import apiService from '@/apiService';

export default {
    data() {
        return {
            badges: [],
            newBadge: { name: '', description: '', icon: '', event_name: '' },
            editingBadge: null,
            events: [],
            showCreateForm: false
        };
    },
    mounted() {
        this.fetchBadges();
        this.fetchEvents();
    },
    methods: {
        fetchBadges() {
            apiService.getBadges().then(response => {
                this.badges = response.data;
            });
        },
        fetchEvents() {
            apiService.getEvents().then(response => {
                this.events = response.data;
            });
        },
        createBadge() {
            apiService.createBadge(this.newBadge).then(response => {
                this.badges.push(response.data);
                this.newBadge = { name: '', description: '', icon: '', event_name: '' };
                this.showCreateForm = false;
            });
        },
        editBadge(badge) {
            this.editingBadge = { ...badge };
        },
        updateBadge() {
            apiService.updateBadge(this.editingBadge.id, this.editingBadge).then(response => {
                const index = this.badges.findIndex(b => b.id === this.editingBadge.id);
                this.$set(this.badges, index, response.data);
                this.editingBadge = null;
            });
        },
        deleteBadge(id) {
            apiService.deleteBadge(id).then(() => {
                this.badges = this.badges.filter(badge => badge.id !== id);
            });
        }
    }
};
</script>