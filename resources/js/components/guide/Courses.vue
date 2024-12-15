<template>
    <div>
        <h2>Courses</h2>
        <ul>
            <li v-for="course in courses" :key="course.id">
                <h3>{{ course.title }}</h3>
                <p>{{ course.description }}</p>
                <button @click="editCourse(course)">Edit</button>
                <button @click="deleteCourse(course.id)">Delete</button>
            </li>
        </ul>
        <form @submit.prevent="addCourse">
            <input v-model="newCourse.title" placeholder="Title" required>
            <textarea v-model="newCourse.description" placeholder="Description"></textarea>
            <input v-model="newCourse.instructor_id" placeholder="Instructor ID" required>
            <input v-model="newCourse.category" placeholder="Category">
            <input v-model="newCourse.duration" placeholder="Duration">
            <input v-model="newCourse.level" placeholder="Level">
            <input v-model="newCourse.price" placeholder="Price">
            <input v-model="newCourse.start_date" placeholder="Start Date">
            <input v-model="newCourse.end_date" placeholder="End Date">
            <select v-model="newCourse.status">
                <option value="draft">Draft</option>
                <option value="published">Published</option>
                <option value="archived">Archived</option>
            </select>
            <button type="submit">Add Course</button>
        </form>
    </div>
</template>

<script>
import apiService from '@/apiService';

export default {
    data() {
        return {
            courses: [],
            newCourse: {
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
            }
        };
    },
    created() {
        this.fetchCourses();
    },
    methods: {
        fetchCourses() {
            apiService.getCourses().then(response => {
                this.courses = response.data;
            });
        },
        addCourse() {
            apiService.saveCourse(null, this.newCourse).then(response => {
                this.courses.push(response.data);
                this.resetNewCourse();
            });
        },
        deleteCourse(courseId) {
            apiService.deleteCourse(courseId).then(() => {
                this.courses = this.courses.filter(course => course.id !== courseId);
            });
        },
        resetNewCourse() {
            this.newCourse = {
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
        editCourse(course) {
            // Implement edit functionality
        }
    }
};
</script>