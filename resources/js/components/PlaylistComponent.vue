<template>
    <div>
        <h2 class="mb-4">Playlists for {{ course.title }}</h2>

        <button type="button" class="btn btn-success mt-4" data-bs-toggle="modal" data-bs-target="#addPlaylistModal">
            Add Playlist
        </button>

        <div v-for="playlist in playlists" :key="playlist.id" class="mb-4">
            <h3 class="mb-3">{{ playlist.name }}
                <button @click="openAddVideoModal(playlist.id)" class="btn btn-info btn-sm mt-2">Add Video</button>
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
import { ref, onMounted } from 'vue';
import apiService from '@/apiService.js';

export default {
    setup() {
        const course = ref({});
        const playlists = ref([]);
        const newPlaylist = ref({ name: '' });
        const newVideo = ref({ title: '', description: '', url: '' });
        const selectedPlaylistId = ref(null);

        const fetchCourse = async () => {
            const courseId = this.$route.params.courseId;
            try {
                const response = await apiService.getCourseDetails(courseId);
                course.value = response.data;
            } catch (error) {
                console.error('Error fetching course details:', error);
            }
        };

        const fetchPlaylists = async () => {
            const courseId = this.$route.params.courseId;
            try {
                const response = await apiService.getPlaylists(courseId);
                playlists.value = response.data;
            } catch (error) {
                console.error('Error fetching playlists:', error);
            }
        };

        const addPlaylist = async () => {
            const courseId = this.$route.params.courseId;
            try {
                const response = await apiService.addPlaylist(courseId, newPlaylist.value);
                playlists.value.push(response.data);
                newPlaylist.value.name = '';
                const modal = bootstrap.Modal.getInstance(document.getElementById('addPlaylistModal'));
                modal.hide();
            } catch (error) {
                console.error('Error adding playlist:', error);
            }
        };

        const addVideo = async () => {
            const playlistId = selectedPlaylistId.value;
            try {
                const response = await apiService.addVideo(playlistId, newVideo.value);
                const playlist = playlists.value.find(pl => pl.id === playlistId);
                playlist.videos.push(response.data);
                newVideo.value = { title: '', description: '', url: '' };
                const modal = bootstrap.Modal.getInstance(document.getElementById('addVideoModal'));
                modal.hide();
            } catch (error) {
                console.error('Error adding video:', error);
            }
        };

        const openAddVideoModal = (playlistId) => {
            selectedPlaylistId.value = playlistId;
            const modal = new bootstrap.Modal(document.getElementById('addVideoModal'));
            modal.show();
        };

        onMounted(() => {
            fetchCourse();
            fetchPlaylists();
        });

        return {
            course,
            playlists,
            newPlaylist,
            newVideo,
            selectedPlaylistId,
            fetchCourse,
            fetchPlaylists,
            addPlaylist,
            addVideo,
            openAddVideoModal,
        };
    },
};
</script>