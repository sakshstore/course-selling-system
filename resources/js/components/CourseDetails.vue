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
import apiService from '@/apiService';

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
        async fetchCourseDetails() {
            const courseId = this.$route.params.id;
            try {
                const response = await apiService.getCourseDetails(courseId);
                this.course = response.data;
            } catch (error) {
                console.error('Error fetching course details:', error);
            }
        },
        async fetchPlaylists() {
            const courseId = this.$route.params.id;
            try {
                const response = await apiService.getPlaylists(courseId);
                this.playlists = response.data;
                this.playlists.forEach(playlist => {
                    this.fetchVideos(playlist);
                });
            } catch (error) {
                console.error('Error fetching playlists:', error);
            }
        },
        async fetchVideos(playlist) {
            const courseId = this.$route.params.id;
            try {
                const response = await apiService.getVideos(courseId, playlist.id);
                this.$set(playlist, 'videos', response.data);
            } catch (error) {
                console.error('Error fetching videos:', error);
            }
        }
    }
};
</script>

<style scoped>
/* Add any additional styling here */
</style>