<template>
    <div>
        <h2 class="mb-4">{{ course.title }}</h2>
        <p>{{ course.description }}</p>

        <h3>Study Materials</h3>
        <ul class="list-group mb-4">
            <li v-for="material in course.studyMaterials" :key="material.id" class="list-group-item">
                <h5>{{ material.title }}</h5>
                <p>{{ material.description }}</p>
                <a :href="`/storage/${material.file_path}`" target="_blank" class="btn btn-primary btn-sm">Download</a>
            </li>
        </ul>


        <router-link :to="{ name: 'CourseVideoGallery', params: { course_id: course.id } }"
            class="btn btn-secondary btn-sm ms-2">View Videos</router-link>

        <button @click="purchaseCourse(course.id)" class="btn btn-primary btn-sm ms-2">Purchase</button>

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
                studyMaterials: []
            },
            playlists: []
        };
    },
    created() {
        this.fetchCourseDetails();
        this.fetchPlaylists();
    },
    methods: {
        fetchCourseDetails() {
            const courseId = this.$route.params.id;
            axios.get(`/v1/courses/${courseId}`).then(response => {
                this.course = response.data;
            });
        },
        fetchPlaylists() {
            const courseId = this.$route.params.id;
            axios.get(`/v1/courses/${courseId}/playlists`).then(response => {
                this.playlists = response.data;
                this.playlists.forEach(playlist => {
                    this.fetchVideos(playlist);
                });
            });
        },
        fetchVideos(playlist) {
            const courseId = this.$route.params.id;
            axios.get(`/v1/courses/${courseId}/playlists/${playlist.id}/videos`).then(response => {
                this.$set(playlist, 'videos', response.data);
            });
        },

        purchaseCourse(courseId) {
            axios.post(`/v1/courses/${courseId}/purchase`).then(response => {
                // Handle successful purchase
                alert('Course purchased successfully!');
                this.$router.push({ name: 'Invoice', params: { invoiceId: response.data.invoice_id } });
            }).catch(error => {
                // Handle purchase error
                console.error('Error purchasing course:', error);
                alert('Failed to purchase course.');
            });
        }


    }
};
</script>

<style scoped>
.list-group-item {
    margin-bottom: 10px;
    padding: 15px;
    border-radius: 5px;
    background-color: #f8f9fa;
    transition: background-color 0.3s;
}

.list-group-item:hover {
    background-color: #e9ecef;
}

.btn-primary {
    margin-top: 10px;
}
</style>