<template>
    <div>
        <h2 class="mb-4">{{ course.title }}</h2>
        <p>{{ course.description }}</p>
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
                        <video controls :src="video.url" class="w-100"></video>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
</template>

<script>
import { ref, onMounted } from 'vue';
import apiService from '@/apiService.js';

export default {
    setup() {
        const course = ref({
            title: '',
            description: '',
        });
        const playlists = ref([]);

        const fetchCourseDetails = async (courseId) => {
            try {
                const response = await apiService.getCourseDetails(courseId);
                course.value = response.data;
            } catch (error) {
                console.error('Error fetching course details:', error);
            }
        };

        const fetchPlaylists = async (courseId) => {
            try {
                const response = await apiService.getPlaylists(courseId);
                playlists.value = response.data;
                playlists.value.forEach(playlist => {
                    fetchVideos(courseId, playlist);
                });
            } catch (error) {
                console.error('Error fetching playlists:', error);
            }
        };

        const fetchVideos = async (courseId, playlist) => {
            try {
                const response = await apiService.getVideos(courseId, playlist.id);
                playlist.videos = response.data;
            } catch (error) {
                console.error('Error fetching videos:', error);
            }
        };

        onMounted(() => {
            const courseId = 2; // Replace with dynamic course ID if needed
            fetchCourseDetails(courseId);
            fetchPlaylists(courseId);
        });

        return {
            course,
            playlists,
            fetchCourseDetails,
            fetchPlaylists,
            fetchVideos,
        };
    },
};
</script> 