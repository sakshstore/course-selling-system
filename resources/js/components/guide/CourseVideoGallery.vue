<template>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3 p-3">
                <h2>Chapters</h2>
                <ul class="list-group">
                    <li v-for="video in videos" :key="video.id" class="list-group-item list-group-item-action"
                        @click="playVideo(video.url, video.id)">
                        {{ video.title }}
                    </li>
                </ul>
            </div>
            <div class="col-md-9 p-4">
                <h2 class="mb-4">{{ currentVideoTitle }}</h2>
                <div class="ratio ratio-16x9 mb-4">
                    <iframe :src="currentVideoUrl" frameborder="0" allowfullscreen></iframe>
                </div>
                <div class="mb-4">
                    <p>{{ currentVideoDescription }}</p>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import apiService from '@/apiservice';

export default {
    data() {
        return {
            videos: [],
            currentVideoUrl: '',
            currentVideoTitle: '',
            currentVideoDescription: ''
        };
    },
    created() {
        this.fetchVideos();
    },
    watch: {
        '$route.params.course_id': 'fetchVideos'
    },
    methods: {
        fetchVideos() {
            const courseId = this.$route.params.course_id;
            apiService.getVideos(courseId).then(response => {
                this.videos = response.data;
                if (this.videos.length > 0) {
                    this.playVideo(this.videos[0].url, this.videos[0].id); // Play the first video by default
                }
            }).catch(error => {
                console.error('Error fetching videos:', error);
            });
        },
        getThumbnailUrl(url) {
            const videoId = this.getYoutubeId(url);
            return `https://img.youtube.com/vi/${videoId}/hqdefault.jpg`;
        },
        getYoutubeId(url) {
            const regExp = /^.*(youtu.be\/|v\/|u\/\w\/|embed\/|watch\?v=|\&v=)([^#\&\?]*).*/;
            const match = url.match(regExp);
            return (match && match[2].length === 11) ? match[2] : null;
        },
        playVideo(url, id) {
            const video = this.videos.find(v => v.id === id);
            const videoId = this.getYoutubeId(url);
            this.currentVideoUrl = `https://www.youtube.com/embed/${videoId}?autoplay=1`;
            this.currentVideoTitle = video.title;
            this.currentVideoDescription = video.description;
            this.$router.push({ query: { videoId: id } });
        }
    }
};
</script>