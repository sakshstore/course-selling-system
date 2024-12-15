<template>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-3 p-3">
            <h2>Playlists</h2>
            <ul class="list-group">
                <li v-for="playlist in playlists" :key="playlist.id" class="list-group-item">
                    <h5>{{ playlist.name }}</h5>
                </li>
            </ul>
        </div>
        <div class="col-md-9 p-4">
            <h2 class="mb-4">Course Description</h2>
            <p>{{ course.description }}</p>
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
            }
        };
    },
    created() {
        this.fetchPlaylists();
        this.fetchCourseDetails();
    },
    watch: {
        '$route.params.course_id': 'fetchPlaylists'
    },
    methods: {
        async fetchPlaylists() {
            const courseId = this.$route.params.course_id;
            try {
                const response = await apiService.getPlaylists(courseId);
                this.playlists = response.data;
            } catch (error) {
                console.error('Error fetching playlists:', error);
            }
        },
        

        async fetchCourseDetails() {
            const courseId = this.$route.params.course_id;
            try {
                const response = await apiService.getCourseDetails(courseId);
                this.course = response.data;
            } catch (error) {
                console.error('Error fetching course details:', error);
            }
        },


    }
};
</script>
