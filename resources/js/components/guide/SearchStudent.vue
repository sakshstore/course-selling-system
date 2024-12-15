<template>
    <div>
        <h2 class="text-primary mb-4">Search Students</h2>
        <input type="text" v-model="searchQuery" @input="searchStudents" class="form-control"
            placeholder="Search by name, email, or phone number">
        <table class="table mt-3" v-if="searchResults.length">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Last login</th>
                    <th>Registered At</th>
                    <th>View</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="student in searchResults" :key="student.id">
                    <td>{{ student.name }}</td>
                    <td>{{ student.email }}</td>
                    <td>{{ student.phone }}</td>
                    <td>{{ formatTimeAgo(student.last_login_at) }}</td>
                    <td>{{ formatTimeAgo(student.created_at) }}</td>
                    <td>
                        <router-link :to="{ name: 'StudentDetails', params: { id: student.id } }"
                            class="btn btn-info btn-sm me-2">
                            <i class="fas fa-eye fixed-width-icon"></i>
                        </router-link>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script>

import apiService from '@/apiService';



import { formatDistanceToNow } from 'date-fns';

export default {
    name: 'SearchStudents',
    data() {
        return {
            searchQuery: '',
            searchResults: []
        };
    },
    methods: {
        searchStudents() {
            if (this.searchQuery.length > 2) {
                apiService.searchStudents(this.searchQuery)
                    .then(response => {
                        this.searchResults = response.data;
                    })
                    .catch(error => {
                        console.error('Error searching students:', error);
                    });
            } else {
                this.searchResults = [];
            }
        },
        formatTimeAgo(date) {
            return formatDistanceToNow(new Date(date), { addSuffix: true });
        }
    }
};
</script>