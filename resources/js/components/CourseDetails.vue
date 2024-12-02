<template>
    <div >
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
        <h3>Playlists</h3>
        <ul class="list-group">
            <li v-for="playlist in playlists" :key="playlist.id" class="list-group-item">
                <h5>{{ playlist.name }}</h5>
                <p>{{ playlist.description }}</p>
                <h4>Videos</h4>
                <ul class="list-group">
                    <li v-for="video in playlist.videos" :key="video.id" class="list-group-item">
                        <h5>{{ video.title }}</h5>
                        <p>{{ video.description }}</p>
                        <a :href="video.url" target="_blank" class="btn btn-primary btn-sm">Watch</a>
                    </li>
                </ul>
            </li>
        </ul>
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
        }
    }
};
</script>

<style scoped>
/* Add any additional styling here */
</style>