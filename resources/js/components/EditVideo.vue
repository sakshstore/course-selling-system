<template>
    <div>
        <h2 class="mb-4 ">Edit Video</h2>
        <form @submit.prevent="updateVideo">
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="course_id" class="form-label">Course</label>
                    <select v-model="video.course_id" @change="fetchPlaylists(video.course_id)" class="form-select"
                        id="course_id" required>
                        <option v-for="course in courses" :key="course.id" :value="course.id">{{ course.title }}
                        </option>
                    </select>
                    <div class="invalid-feedback">Please select a course.</div>
                </div>
                <div class="col-md-6">
                    <label for="playlist_id" class="form-label">Playlist</label>
                    <select v-model="video.playlist_id" class="form-select" id="playlist_id" required>
                        <option v-for="playlist in playlists" :key="playlist.id" :value="playlist.id">{{ playlist.name
                            }}</option>
                    </select>
                    <div class="invalid-feedback">Please select a playlist.</div>
                </div>
            </div>
            <div class="form-group">
                <label for="title">Title</label>
                <input type="text" v-model="video.title" class="form-control" id="title" required>
            </div>
            <div class="form-group">
                <label for="description">Description</label>
                <textarea v-model="video.description" class="form-control" id="description" required></textarea>
            </div>
            <div class="form-group">
                <label for="thumbnail">Thumbnail</label>
                <input type="file" @change="onFileChange" class="form-control-file" id="thumbnail">
            </div>
            <div class="form-group">
                <label for="tags">Tags</label>
                <input type="text" v-model="video.tags" class="form-control" id="tags" required>
            </div>

            <button type="submit" class="btn btn-primary my-4">Update Video</button>
        </form>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    data() {
        return {
            video: {
                course_id: '',
                playlist_id: '',
                title: '',
                description: '',
                thumbnail: null,
                tags: '',
                category: ''
            },
            courses: [],
            playlists: []
        };
    },
    created() {
        this.fetchVideoDetails();
        this.fetchCourses();
    },
    methods: {
        fetchVideoDetails() {
            const videoId = this.$route.params.id;
            axios.get(`/v1/video/${videoId}`).then(response => {
                this.video = response.data;
                this.fetchPlaylists(this.video.course_id); // Fetch playlists for the selected course
            }).catch(error => {
                console.error('Error fetching video details:', error);
            });
        },
        fetchCourses() {
            axios.get('/v1/courses').then(response => {
                this.courses = response.data;
            }).catch(error => {
                console.error('Error fetching courses:', error);
            });
        },
        fetchPlaylists(courseId) {
            axios.get(`/v1/courses/${courseId}/playlists`).then(response => {
                this.playlists = response.data;
            }).catch(error => {
                console.error('Error fetching playlists:', error);
            });
        },
        onFileChange(event) {
            this.video.thumbnail = event.target.files[0];
        },
        updateVideo() {
            const formData = new FormData();
            formData.append('course_id', this.video.course_id);
            formData.append('playlist_id', this.video.playlist_id);
            formData.append('title', this.video.title);
            formData.append('description', this.video.description);
            formData.append('tags', this.video.tags);

            if (this.video.thumbnail) {
                formData.append('thumbnail', this.video.thumbnail);
            }

            axios.post(`/v1/video/${this.$route.params.id}`, formData).then(response => {
                this.$router.push('/my-videos');
            }).catch(error => {
                console.error('Error updating video:', error);
            });
        }
    }
};
</script>

<style>
.form-group {
    margin: 10px 0 30px;
}
</style>