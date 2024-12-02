<template>
    <div >
        <h2 class="mb-4">Playlists for {{ course.title }}</h2>

        <button type="button" class="btn btn-success mt-4" data-bs-toggle="modal" data-bs-target="#addPlaylistModal">
            Add Playlist
        </button>

        <div v-for="playlist in playlists" :key="playlist.id" class="mb-4">
            <h3 class="mb-3">{{ playlist.name }}

                <button @click="openAddVideoModal(playlist.id)" class="btn btn-info btn-sm mt-2">Add Video</button>
      

                sss
            </h3>
            <ul class="list-group">
                <li v-for="video in playlist.videos" :key="video.id" class="list-group-item">
                    <h5 class="mb-1">{{ video.title }}</h5>
                    <p class="mb-1">{{ video.description }}</p>
                    <a :href="video.url" target="_blank" class="btn btn-primary btn-sm">Watch</a>
                </li>
            </ul>
        </div>

        <!-- Add Playlist Modal -->
        <div class="modal fade" id="addPlaylistModal" tabindex="-1" aria-labelledby="addPlaylistModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addPlaylistModalLabel">Add Playlist</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form @submit.prevent="addPlaylist">
                            <div class="mb-3">
                                <label for="name" class="form-label">Name</label>
                                <input v-model="newPlaylist.name" type="text" class="form-control" id="name"
                                    placeholder="Name" required>
                            </div>
                            <button type="submit" class="btn btn-success">Add Playlist</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Add Video Modal -->
        <div class="modal fade" id="addVideoModal" tabindex="-1" aria-labelledby="addVideoModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addVideoModalLabel">Add Video</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form @submit.prevent="addVideo">
                            <div class="mb-3">
                                <label for="videoTitle" class="form-label">Title</label>
                                <input v-model="newVideo.title" type="text" class="form-control" id="videoTitle"
                                    placeholder="Title" required>
                            </div>
                            <div class="mb-3">
                                <label for="videoDescription" class="form-label">Description</label>
                                <textarea v-model="newVideo.description" class="form-control" id="videoDescription"
                                    placeholder="Description"></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="videoUrl" class="form-label">URL</label>
                                <input v-model="newVideo.url" type="url" class="form-control" id="videoUrl"
                                    placeholder="URL" required>
                            </div>
                            <button type="submit" class="btn btn-success">Add Video</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
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
        fetchPlaylists() {
            const courseId = this.$route.params.courseId;
            axios.get(`/v1/courses/${courseId}/playlists`).then(response => {
                this.playlists = response.data;
            });
        },
        addPlaylist() {
            const courseId = this.$route.params.courseId;
            axios.post(`/v1/courses/${courseId}/playlists`, this.newPlaylist).then(response => {
                this.playlists.push(response.data);
                this.newPlaylist.name = '';
                // Close the modal
                const modal = bootstrap.Modal.getInstance(document.getElementById('addPlaylistModal'));
                modal.hide();
            });
        },
        addVideo() {
            const playlistId = this.selectedPlaylistId;
            axios.post(`/v1/playlists/${playlistId}/videos`, this.newVideo).then(response => {
                const playlist = this.playlists.find(pl => pl.id === playlistId);
                playlist.videos.push(response.data);
                this.newVideo = { title: '', description: '', url: '' };
                // Close the modal
                const modal = bootstrap.Modal.getInstance(document.getElementById('addVideoModal'));
                modal.hide();
            });
        },
        openAddVideoModal(playlistId) {
            this.selectedPlaylistId = playlistId;
            const modal = new bootstrap.Modal(document.getElementById('addVideoModal'));
            modal.show();
        }
    }
};
</script>
 