<template>
    <div>
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="text-white">Students</h2>
            <div>
                <router-link :to="{ name: 'SearchStudent' }" class="btn btn-info btn-sm me-2">
                    <i class="fas fa-file-export"></i> Search
                </router-link>
                <button class="btn btn-info btn-sm me-2" @click="createStudent">
                    <i class="fas fa-plus"></i>
                </button>
                <router-link :to="{ name: 'StudentsImport' }" class="btn btn-info btn-sm me-2">
                    <i class="fas fa-file-import"></i>
                </router-link>
                <router-link :to="{ name: 'StudentsExport' }" class="btn btn-info btn-sm me-2">
                    <i class="fas fa-file-export"></i>
                </router-link>
            </div>
        </div>
        <input type="text" v-model="searchQuery" @input="searchStudents" placeholder="Search students..."
            class="form-control mb-3" />

        <div v-if="loading" class="text-center">
            <div class="spinner-border text-primary" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>

        <table v-else class="table">
            <thead>
                <tr>
                    <th scope="col">Name</th>
                    <th scope="col">Email</th>
                    <th scope="col">Phone Number</th>
                    <th scope="col">Registered At</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="student in students" :key="student.id">
                    <td>{{ student.name }}</td>
                    <td>{{ student.email }}</td>
                    <td>{{ student.phoneNumber }}</td>
                    <td>{{ formatTimeAgo(student.created_at) }}</td>
                    <td class="text-end">
                        <router-link :to="{ name: 'StudentDetails', params: { id: student.id } }"
                            class="btn btn-info btn-sm me-2">
                            <i class="fas fa-eye fixed-width-icon"></i>
                        </router-link>
                        <button @click="editStudent(student.id)" class="btn btn-warning btn-sm me-2">
                            <i class="fas fa-edit fixed-width-icon"></i>
                        </button>
                        <button @click="suspendStudent(student.id)" class="btn btn-danger btn-sm me-2"
                            v-if="!student.is_suspended">
                            <i class="fas fa-ban fixed-width-icon"></i>
                        </button>
                        <button @click="unsuspendStudent(student.id)" class="btn btn-success btn-sm me-2"
                            v-if="student.is_suspended">
                            <i class="fas fa-check fixed-width-icon"></i>
                        </button>
                    </td>
                </tr>
            </tbody>
        </table>

        <!-- Modal for creating/editing student -->
        <div v-if="showModal" class="modal fade show" tabindex="-1" style="display: block;">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">{{ isEditing ? 'Edit Student' : 'Create Student' }}</h5>
                        <button type="button" class="btn-close" @click="closeModal"></button>
                    </div>
                    <div class="modal-body">
                        <StudentForm :studentId="selectedStudentId" :isEditing="isEditing" @saved="handleSaved" />
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { formatDistanceToNow } from 'date-fns';
import StudentForm from './StudentForm.vue';
import apiService from '@/apiService';


export default {
    components: {
        StudentForm
    },
    data() {
        return {
            students: [],
            searchQuery: '',
            showModal: false,
            isEditing: false,
            selectedStudentId: null,
            loading: false
        };
    },
    created() {
        this.fetchStudents();
    },
    methods: {
        async fetchStudents() {
            this.loading = true;
            try {
                const response = await apiService.getStudents();
                this.students = response.data;
            } catch (error) {
                console.error('Error fetching students:', error);
            } finally {
                this.loading = false;
            }
        },
        createStudent() {
            this.isEditing = false;
            this.selectedStudentId = null;
            this.showModal = true;
        },
        editStudent(id) {
            this.selectedStudentId = id;
            this.isEditing = true;
            this.showModal = true;
        },
        async suspendStudent(id) {
            try {
                await apiService.suspendStudent(id);
                this.fetchStudents();
            } catch (error) {
                console.error('Error suspending student:', error);
            }
        },
        async unsuspendStudent(id) {
            try {
                await apiService.unsuspendStudent(id);
                this.fetchStudents();
            } catch (error) {
                console.error('Error unsuspending student:', error);
            }
        },
        async searchStudents() {
            try {
                const response = await apiService.getStudents(this.searchQuery);
                this.students = response.data;
            } catch (error) {
                console.error('Error searching students:', error);
            }
        },
        closeModal() {
            this.showModal = false;
        },
        formatTimeAgo(date) {
            return formatDistanceToNow(new Date(date), { addSuffix: true });
        },
        handleSaved(student) {
            if (this.isEditing) {
                const index = this.students.findIndex(s => s.id === student.id);
                this.students.splice(index, 1, student);
            } else {
                this.students.push(student);
            }
            this.closeModal();
        }
    }
};
</script>