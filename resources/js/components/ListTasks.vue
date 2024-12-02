<template>
    <div class="container mt-5">
        <h2 class="mb-4">Tasks</h2>
        <button @click="showModal = true" class="btn btn-primary mb-3">Create Task</button>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Title</th>
                    <th scope="col">Description</th>
                    <th scope="col">Status</th>
                    <th scope="col">Priority</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="task in tasks" :key="task.id">
                    <th scope="row">{{ task.id }}</th>
                    <td>{{ task.title }}</td>
                    <td>{{ task.description }}</td>
                    <td>{{ task.status }}</td>
                    <td>{{ task.priority }}</td>
                    <td>
                        <button @click="goToEditTask(task.id)" class="btn btn-warning btn-sm">Edit</button>
                        <button @click="deleteTask(task.id)" class="btn btn-danger btn-sm">Delete</button>
                    </td>
                </tr>
            </tbody>
        </table>

        <!-- Modal -->
        <div v-if="showModal" class="modal fade show" style="display: block;" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Create Task</h5>
                        <button type="button" class="btn-close" @click="showModal = false"></button>
                    </div>
                    <div class="modal-body">
                        <form @submit.prevent="createTask">
                            <div class="mb-3">
                                <label for="title" class="form-label">Title</label>
                                <input v-model="title" type="text" class="form-control" id="title" placeholder="Title"
                                    required />
                            </div>
                            <div class="mb-3">
                                <label for="description" class="form-label">Description</label>
                                <textarea v-model="description" class="form-control" id="description" rows="3"
                                    placeholder="Description"></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="status" class="form-label">Status</label>
                                <select v-model="status" class="form-select" id="status" required>
                                    <option value="pending">Pending</option>
                                    <option value="in-progress">In Progress</option>
                                    <option value="completed">Completed</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="priority" class="form-label">Priority</label>
                                <select v-model="priority" class="form-select" id="priority" required>
                                    <option value="low">Low</option>
                                    <option value="medium">Medium</option>
                                    <option value="high">High</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary">Create Task</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div v-if="showModal" class="modal-backdrop fade show"></div>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    data() {
        return {
            tasks: [],
            showModal: false,
            title: '',
            description: '',
            status: 'pending',
            priority: 'medium'
        };
    },
    created() {
        this.fetchTasks();
    },
    methods: {
        fetchTasks() {
            axios.get('/v1/tasks').then(response => {
                this.tasks = response.data;
            }).catch(error => {
                console.error(error);
            });
        },
        goToEditTask(id) {
            this.$router.push(`/tasks/${id}/edit`);
        },
        deleteTask(id) {
            axios.delete(`/v1/tasks/${id}`).then(() => {
                this.fetchTasks();
            }).catch(error => {
                console.error(error);
            });
        },
        createTask() {
            axios.post('/v1/tasks', {
                title: this.title,
                description: this.description,
                status: this.status,
                priority: this.priority
            }).then(response => {
                this.tasks.push(response.data);
                this.showModal = false;
                this.title = '';
                this.description = '';
                this.status = 'pending';
                this.priority = 'medium';
            }).catch(error => {
                console.error(error);
            });
        }
    }
};
</script>