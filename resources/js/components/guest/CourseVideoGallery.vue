<template>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-3 p-3">
            <h2>Playlists</h2>
            <ul class="list-group">
                <li v-for="playlist in playlists" :key="playlist.id" class="list-group-item">
                    <h5>
                        <a data-bs-toggle="collapse" :href="'#collapse' + playlist.id" role="button" aria-expanded="false" :aria-controls="'collapse' + playlist.id">
                            {{ playlist.name }}
                            <span v-if="playlist.videos.length" class="ms-2">
                                <i class="bi bi-chevron-down"></i>
                            </span>
                        </a>
                    </h5>
                    <div :id="'collapse' + playlist.id" class="collapse">
                        <ul class="list-group mt-2">
                            <li v-for="video in playlist.videos" :key="video.id" class="list-group-item" @click="playVideo(video)">
                                {{ video.title }}
                            </li>
                        </ul>
                    </div>
                </li>
            </ul>
        </div>
        <div class="col-md-9 p-4">
            <h2 class="mb-4">Course Description</h2>
            <p>{{ course.description }}</p>
            <div v-if="currentVideo">
                <h3>{{ currentVideo.title }}</h3>
                <video :src="currentVideo.url" controls class="w-100"></video>
                <p>{{ currentVideo.description }}</p>
            </div>
        </div>
    </div>
</div>
</template>

    
<script>
import apiService from '@/apiGuestService.js';

export default {
    data() {
        return {
            playlists: [],
            course: {
                description: ''
            },
            currentVideo: null
        };
    },
    created() {
        this.fetchCourseAndPlaylists();
        this.checkForVideoInUrl();
    },
    watch: {
        '$route.params.course_id': 'fetchCourseAndPlaylists'
    },
    methods: {
        async fetchCourseAndPlaylists() {
            const courseId = this.$route.params.course_id;
            try {
                const response = await apiService.getCourseAndPlaylists(courseId);
                this.course = response.data.course;
                this.playlists = response.data.playlists;
            } catch (error) {
                console.error('Error fetching course and playlists:', error);
            }
        },
        playVideo(video) {
            this.currentVideo = video;
            this.updateUrl(video.id);
        },
        updateUrl(videoId) {
            this.$router.push({
                name: 'CourseWithVideo',
                params: {
                    course_id: this.$route.params.course_id,
                    video_id: videoId
                }
            });
        },
        checkForVideoInUrl() {
            const videoId = this.$route.params.video_id;
            if (videoId) {
                this.findAndPlayVideo(videoId);
            }
        },
        findAndPlayVideo(videoId) {
            for (const playlist of this.playlists) {
                const video = playlist.videos.find(video => video.id === parseInt(videoId));
                if (video) {
                    this.currentVideo = video;
                    break;
                }
            }
        }
    }
};
</script>
