<template>
    <div>
        <h2 class="mb-4">{{ course.title }}</h2>
        <p>{{ course.description }}</p>

        <p>{{ course.id }}</p>

        <router-link :to="{ name: 'CourseVideoGallery', params: { 'course_id': course.id } }"
            class="btn btn-secondary btn-sm ms-2">View Videos</router-link>


        <div v-if="loading" class="spinner-border" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
        <div v-if="error" class="alert alert-danger" role="alert">
            {{ error }}
        </div>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    data() {
        return {
            course: {
                title: '',
                description: '',
                id: this.$route.params.id// Ensure id is initialized
            },
            loading: false,
            error: null
        };
    },
    created() {
        this.fetchCourseDetails();
    },
    methods: {
        async fetchCourseDetails() {
            const courseId = this.$route.params.id;
            this.loading = true;
            this.error = null;
            try {
                const response = await axios.get(`/v1/courses/${courseId}`);
                this.course = response.data;
            } catch (err) {
                this.error = 'Failed to load course details.';
            } finally {
                this.loading = false;
            }
        }
    }
};
</script>