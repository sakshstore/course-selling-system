<template>
<div>
    <div class="row">
        <div class="col-12 mb-4">
            <div class="ratio ratio-16x9">
                <iframe :src="currentVideoUrl" frameborder="0" allowfullscreen></iframe>
            </div>
        </div>
        <div v-for="video in videos" :key="video.id" class="col-md-4 mb-4">
            <div class="card">
                <img :src="getThumbnailUrl(video.url)" class="card-img-top" @click="playVideo(video.url, video.id)" alt="Video Thumbnail">
                <div class="card-body">
                    <h5 class="card-title">{{ video.title }}</h5>
                    <p class="card-text">{{ video.description }}</p>
                </div>
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
            videos: [],
            currentVideoUrl: ''
        };
    },
    created() {
        this.fetchVideos();
    },
    methods: {
        async fetchVideos() {
            try {
                const response = await apiService.getLatestVideos();
                this.videos = response.data;
                const videoId = this.$route.query.videoId;
                if (videoId) {
                    const video = this.videos.find(v => v.id === videoId);
                    if (video) {
                        this.playVideo(video.url, video.id);
                    } else {
                        this.playVideo(this.videos[0].url, this.videos[0].id); // Play the first video by default
                    }
                } else {
                    this.playVideo(this.videos[0].url, this.videos[0].id); // Play the first video by default
                }
            } catch (error) {
                console.error('Error fetching videos:', error);
            }
        },
        getThumbnailUrl(url) {
            const videoId = this.getYoutubeId(url);
            return `https://img.youtube.com/vi/${videoId}/hqdefault.jpg`;
        },
        getYoutubeId(url) {
            const regExp = /^.*(youtu.be\/|v\/|u\/\w\/|embed\/|watch\?v=|&v=)([^#&?]*).*/;
            const match = url.match(regExp);
            return (match && match[2].length === 11) ? match[2] : null;
        },
        playVideo(url, id) {
            const videoId = this.getYoutubeId(url);
            this.currentVideoUrl = `https://www.youtube.com/embed/${videoId}?autoplay=1`;
            this.$router.push({
                query: {
                    videoId: id
                }
            });
        }
    }
};
</script>
