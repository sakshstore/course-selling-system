<template>
    <div>
        <h2 class="mb-4">Videos
            <router-link :to="{ name: 'VideoUpload' }" class="btn btn-primary">
                <i class="fas fa-plus"></i> Add New
            </router-link>
        </h2>

        <div class="row">
            <div v-for="video in videos" :key="video.id" class="col-md-2">
                <div class="card">
                    <video controls :src="video.url" class="card-img-top"></video>
                    <div class="card-body">
                        <p>{{ video.title }}</p>
                        <router-link :to="{ name: 'EditVideo', params: { id: video.id } }" class="btn btn-primary mt-2">
                            <i class="fas fa-edit"></i> Edit
                        </router-link>
                    </div>
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
            videos: []
        };
    },
    created() {
        this.fetchUserVideos();
    },
    methods: {
        fetchUserVideos() {
            apiService.getAttachedVideos()
                .then(response => {
                    this.videos = response.data;
                })
                .catch(error => {
                    console.error('Error fetching videos:', error);
                });
        }
    }
};
</script>