<template>
    <div>
        <h2 class="mb-4">Courses</h2>



        <router-link :to="{ name: 'CreateCourse' }" class="btn btn-info btn-sm  ">Course Form</router-link>



        <ul class="list-group mt-3">
            <li v-for="course in courses" :key="course.id"
                class="list-group-item d-flex justify-content-between border align-items-center mb-3">
                <div @click="viewCourseDetails(course.id)" style="cursor: pointer;">
                    <h5 class="mb-1">{{ course.title }}</h5>
                    <p class="mb-1">{{ course.description }}</p>
                </div>
                <div>
                    <button @click="openEditModal(course)" class="btn btn-primary btn-sm me-2">Edit</button>
                    <button @click="deleteCourse(course.id)" class="btn btn-danger btn-sm">Delete</button>
                    <router-link :to="{ name: 'Playlists', params: { courseId: course.id } }"
                        class="btn btn-info btn-sm ms-2">View Playlists</router-link>
                </div>
            </li>
        </ul>

        <button type="button" class="btn btn-success mt-4" data-bs-toggle="modal" data-bs-target="#courseModal">Add
            Course</button>

        <!-- Add/Edit Course Modal -->
        <div class="modal fade" id="courseModal" tabindex="-1" aria-labelledby="courseModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="courseModalLabel">{{ isEditMode ? 'Edit Course' : 'Add Course' }}
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form @submit.prevent="isEditMode ? updateCourse() : addCourse()">
                            <div class="mb-3">
                                <label for="title" class="form-label">Title</label>
                                <input v-model="currentCourse.title" type="text" class="form-control" id="title"
                                    placeholder="Title" required>
                            </div>
                            <div class="mb-3">
                                <label for="description" class="form-label">Description</label>
                                <textarea v-model="currentCourse.description" class="form-control" id="description"
                                    placeholder="Description"></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="instructor_id" class="form-label">Instructor ID</label>
                                <input v-model="currentCourse.instructor_id" type="number" class="form-control"
                                    id="instructor_id" placeholder="Instructor ID" required>
                            </div>
                            <div class="mb-3">
                                <label for="category" class="form-label">Category</label>
                                <input v-model="currentCourse.category" type="text" class="form-control" id="category"
                                    placeholder="Category">
                            </div>
                            <div class="mb-3">
                                <label for="duration" class="form-label">Duration</label>
                                <input v-model="currentCourse.duration" type="number" class="form-control" id="duration"
                                    placeholder="Duration">
                            </div>
                            <div class="mb-3">
                                <label for="level" class="form-label">Level</label>
                                <input v-model="currentCourse.level" type="text" class="form-control" id="level"
                                    placeholder="Level">
                            </div>
                            <div class="mb-3">
                                <label for="price" class="form-label">Price</label>
                                <input v-model="currentCourse.price" type="number" step="0.01" class="form-control"
                                    id="price" placeholder="Price">
                            </div>
                            <div class="mb-3">
                                <label for="start_date" class="form-label">Start Date</label>
                                <input v-model="currentCourse.start_date" type="date" class="form-control"
                                    id="start_date">
                            </div>
                            <div class="mb-3">
                                <label for="end_date" class="form-label">End Date</label>
                                <input v-model="currentCourse.end_date" type="date" class="form-control" id="end_date">
                            </div>
                            <div class="mb-3">
                                <label for="status" class="form-label">Status</label>
                                <select v-model="currentCourse.status" class="form-select" id="status">
                                    <option value="draft">Draft</option>
                                    <option value="published">Published</option>
                                    <option value="archived">Archived</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-success">{{ isEditMode ? 'Update Course' : 'Add Course'
                                }}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import apiService from '@/apiService';

export default {
    data() {
        return {
            courses: [],
            currentCourse: {
                title: '',
                description: '',
                instructor_id: '',
                category: '',
                duration: '',
                level: '',
                price: '',
                start_date: '',
                end_date: '',
                status: 'draft'
            },
            isEditMode: false
        };
    },
    created() {
        this.fetchCourses();
    },
    methods: {
        async fetchCourses() {
            try {
                const response = await apiService.getCourses();
                this.courses = response.data;
            } catch (error) {
                console.error('Error fetching courses:', error);
            }
        },
        async addCourse() {
            try {
                const response = await apiService.saveCourse(null, this.currentCourse);
                this.courses.push(response.data);
                this.resetForm();
                this.closeModal();
            } catch (error) {
                console.error('Error adding course:', error);
            }
        },
        openAddModal() {
            this.isEditMode = false;
            this.resetForm();
            this.showModal();
        },
        openEditModal(course) {
            this.isEditMode = true;
            this.currentCourse = { ...course };
            this.showModal();
        },
        async updateCourse() {
            try {
                const response = await apiService.saveCourse(this.currentCourse.id, this.currentCourse);
                const index = this.courses.findIndex(course => course.id === this.currentCourse.id);
                this.courses.splice(index, 1, response.data);
                this.resetForm();
                this.closeModal();
            } catch (error) {
                console.error('Error updating course:', error);
            }
        },
        async deleteCourse(courseId) {
            try {
                await apiService.deleteCourse(courseId);
                this.courses = this.courses.filter(course => course.id !== courseId);
            } catch (error) {
                console.error('Error deleting course:', error);
            }
        },
        resetForm() {
            this.currentCourse = {
                title: '',
                description: '',
                instructor_id: '',
                category: '',
                duration: '',
                level: '',
                price: '',
                start_date: '',
                end_date: '',
                status: 'draft'
            };
        },
        showModal() {
            const modalElement = document.getElementById('courseModal');
            const modal = new bootstrap.Modal(modalElement);
            modal.show();
        },
        closeModal() {
            const modalElement = document.getElementById('courseModal');
            const modal = bootstrap.Modal.getInstance(modalElement);
            modal.hide();
        },
        viewCourseDetails(courseId) {
            this.$router.push({ name: 'CourseDetails', params: { id: courseId } });
        }
    }
};
</script>