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
import axios from 'axios';

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
            selectedPlaylistId: null
        };
    },
    created() {
        this.fetchCourse();
        this.fetchPlaylists();
    },
    methods: {
        fetchCourse() {
            const courseId = this.$route.params.courseId;

            axios.get(`/v1/courses/${courseId}`).then(response => {
                this.course = response.data;
            });
        },


        fetchVideos(playlist) {
            const courseId = this.$route.params.id;

            const playlistId = this.$route.params.playlistId;
            axios.get(`/v1/courses/${courseId}/playlists/${playlistId}/videos`).then(response => {
                console.log(playlist, 'videos', response.data);

                this.videos = response.data;


            });
        }
    }
};
</script>

<style scoped>
/* Add any additional styling here */
</style>