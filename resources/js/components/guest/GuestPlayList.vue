<template>
    <div>


        <h3 class="mb-3">name



        </h3>
        <ul class="list-group">
            <li v-for="video in videos" :key="video.id" class="list-group-item">
                <h5 class="mb-1">{{ video.title }}</h5>
                <p class="mb-1">{{ video.description }}</p>
                <a :href="video.url" target="_blank" class="btn btn-primary btn-sm">Watch</a>
            </li>
        </ul>




    </div>
</template>

<script>



import apiService from '@/apiGuestService.js';

export default {
    data() {
        return {
            course: {},
            playlists: [],
            newPlaylist: {
                name: ''
            },
            newVideo: {
                title: '',
                description: '',
                url: ''
            },
            selectedPlaylistId: null,
            videos: []
        };
    },
    created() {
        this.fetchCourse();
        this.fetchPlaylists();
    },
    methods: {
        async fetchCourse() {
            const courseId = this.$route.params.courseId;
            try {
                const response = await apiService.getCourse(courseId);
                this.course = response.data;
            } catch (error) {
                console.error('Error fetching course:', error);
            }
        },
        async fetchVideos(playlist) {
            const courseId = this.$route.params.id;
            const playlistId = this.$route.params.playlistId;
            try {
                const response = await apiService.getVideos(courseId, playlistId);
                console.log(playlist, 'videos', response.data);
                this.videos = response.data;
            } catch (error) {
                console.error('Error fetching videos:', error);
            }
        }
    }
};

</script> 