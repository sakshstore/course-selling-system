<template>
    <div>
        <h2 class="mb-4 text-center">Upload Video</h2>
        <form @submit.prevent="uploadVideo" class="needs-validation" novalidate>
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
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="title" class="form-label">Title</label>
                    <input v-model="video.title" type="text" class="form-control" id="title" placeholder="Title"
                        required>
                    <div class="invalid-feedback">Please enter a title.</div>
                </div>
                <div class="col-md-6">
                    <label for="description" class="form-label">Description</label>
                    <textarea v-model="video.description" class="form-control" id="description"
                        placeholder="Description" required></textarea>
                    <div class="invalid-feedback">Please enter a description.</div>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="url" class="form-label">Video URL</label>
                    <input v-model="video.url" type="text" class="form-control" id="url" placeholder="Video URL"
                        required>
                    <div class="invalid-feedback">Please enter a video URL.</div>
                </div>
                <div class="col-md-6">
                    <label for="video_file" class="form-label">Upload Video File</label>
                    <input @change="onFileChange" type="file" class="form-control" id="video_file" required>
                    <div class="invalid-feedback">Please upload a video file.</div>
                </div>
            </div>
            <div class="text-center">
                <button type="submit" class="btn btn-success">Upload Video</button>
            </div>
        </form>

        <h3 class="mt-5 text-center">Last 3 Uploaded Videos</h3>
        <div class="row">
            <div v-for="video in lastThreeVideos" :key="video.id" class="col-md-4 mb-4">
                <div class="card">
                    <img :src="video.thumbnail" class="card-img-top" alt="Video Thumbnail">
                    <div class="card-body">
                        <h5 class="card-title">{{ video.title }}</h5>
                        <p class="card-text">{{ video.description }}</p>
                        <youtube :video-id="getYoutubeId(video.url)" class="w-100"></youtube>
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
            courses: [],
            playlists: [],
            video: {
                course_id: '',
                playlist_id: '',
                title: '',
                description: '',
                url: '',
                video_file: null
            },
            lastThreeVideos: []
        };
    },
    created() {
        this.fetchCourses();
        this.fetchLastThreeVideos();
    },
    methods: {
        fetchCourses() {
            apiService.getCourses().then(response => {
                this.courses = response.data;
            });
        },
        fetchPlaylists(courseId) {
            apiService.getPlaylists(courseId).then(response => {
                this.playlists = response.data;
            });
        },
        uploadVideo() {
            const formData = new FormData();
            for (const key in this.video) {
                formData.append(key, this.video[key]);
            }
            formData.append('video_file', this.video.video_file); // Append the video file
            apiService.uploadVideo(formData).then(response => {
                alert('Video uploaded successfully!');
                this.resetForm();
                this.fetchLastThreeVideos(); // Refresh the list of last three videos
            }).catch(error => {
                console.error('Error uploading video:', error);
                alert('Failed to upload video.');
            });
        },
        fetchLastThreeVideos() {
            apiService.getLastThreeVideos().then(response => {
                this.lastThreeVideos = response.data;
            }).catch(error => {
                console.error('Error fetching last three videos:', error);
            });
        },
        resetForm() {
            this.video = {
                course_id: '',
                playlist_id: '',
                title: '',
                description: '',
                url: '',
                video_file: null
            };
        },
        onFileChange(event) {
            this.video.video_file = event.target.files[0];
        },
        getYoutubeId(url) {
            const regExp = /^.*(youtu.be\/|v\/|u\/\w\/|embed\/|watch\?v=|\&v=)([^#\&\?]*).*/;
            const match = url.match(regExp);
            return (match && match[2].length === 11) ? match[2] : null;
        }
    }
};
</script>
 