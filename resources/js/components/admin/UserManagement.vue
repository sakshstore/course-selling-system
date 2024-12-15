<template>
    <div>
        <h1>User Management</h1>
        <table class="table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="user in users" :key="user.id">
                    <td>{{ user.name }}</td>
                    <td>
                        <a @click.prevent="viewUserDetails(user.id)" style="cursor: pointer;">{{ user.email }}</a>
                    </td>
                    <td>{{ user.is_suspended ? 'Suspended' : 'Active' }}</td>
                    <td>
                        <button @click="editUser(user)" class="btn btn-warning">Edit</button>
                        <button v-if="!user.is_suspended" @click="suspendUser(user)"
                            class="btn btn-danger">Suspend</button>
                        <button v-if="user.is_suspended" @click="unsuspendUser(user)"
                            class="btn btn-success">Unsuspend</button>
                        <button @click="deleteUser(user)" class="btn btn-danger">Delete</button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script>



import { useRouter } from 'vue-router';
import apiService from '@/apiService.js';

export default {
    data() {
        return {
            users: [],
        };
    },
    created() {
        this.fetchUsers();
    },
    methods: {
        async fetchUsers() {
            try {
                const response = await apiService.getUsers();
                this.users = response.data;
            } catch (error) {
                console.error('Error fetching users:', error);
            }
        },
        async suspendUser(user) {
            try {
                await apiService.suspendUser(user.id);
                this.fetchUsers(); // Refresh the user list
            } catch (error) {
                console.error('Error suspending user:', error);
            }
        },
        async unsuspendUser(user) {
            try {
                await apiService.unsuspendUser(user.id);
                this.fetchUsers(); // Refresh the user list
            } catch (error) {
                console.error('Error unsuspending user:', error);
            }
        },
        async deleteUser(user) {
            if (confirm(`Are you sure you want to delete ${user.name}?`)) {
                try {
                    await apiService.deleteUser(user.id);
                    this.fetchUsers(); // Refresh the user list
                } catch (error) {
                    console.error('Error deleting user:', error);
                }
            }
        },
        viewUserDetails(userId) {
            this.$router.push({ name: 'UserDetail', params: { id: userId } });
        },
        editUser(user) {
            // Implement the logic to edit the user
            // This could involve navigating to an edit form or opening a modal
            console.log('Edit user:', user);
        }
    }
};


</script>