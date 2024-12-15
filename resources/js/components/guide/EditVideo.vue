<template>
<div>
    <h2 class="mb-4">Edit Video</h2>
    <form @submit.prevent="updateVideo">
        <div class="row mb-3">
            <div class="col-md-6">
                <label for="course_id" class="form-label">Course</label>
                <select v-model="video.course_id" @change="fetchPlaylists(video.course_id)" class="form-select" id="course_id" required>
                    <option v-for="course in courses" :key="course.id" :value="course.id">{{ course.title }}</option>
                </select>
                <div class="invalid-feedback">Please select a course.</div>
            </div>
            <div class="col-md-6">
                <label for="playlist_id" class="form-label">Playlist</label>
                <div class="d-flex">
                    <select v-model="video.playlist_id" class="form-select" id="playlist_id" required>
                        <option value="0">default</option>
                        <option v-for="playlist in playlists" :key="playlist.id" :value="playlist.id">{{ playlist.name }}</option>
                    </select>
                    <button type="button" class="btn btn-success ms-2" @click="openAddPlaylistModal">Add Playlist</button>
                </div>
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

    <!-- Add Playlist Modal -->
    <div v-if="showAddPlaylistModal" class="modal fade show d-block" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Playlist</h5>
                    <button type="button" class="btn-close" @click="closeAddPlaylistModal"></button>
                </div>
                <div class="modal-body">
                    <form @submit.prevent="addPlaylist">
                        <div class="form-group">
                            <label for="newPlaylistName">Playlist Name</label>
                            <input type="text" v-model="newPlaylist.name" class="form-control" id="newPlaylistName" required>
                        </div>
                        <button type="submit" class="btn btn-success my-4">Add Playlist</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</template>

<script>
 import apiService from '@/apiService.js';

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
             playlists: [],
             newPlaylist: {
                 name: ''
             },
             showAddPlaylistModal: false
         };
     },
     created() {
         this.fetchVideoDetails();
         this.fetchCourses();
     },
     methods: {
         async fetchVideoDetails() {
             const videoId = this.$route.params.id;
             try {
                 const response = await apiService.getVideo(videoId);
                 this.video = response.data;
                 this.fetchPlaylists(this.video.course_id); // Fetch playlists for the selected course
             } catch (error) {
                 console.error('Error fetching video details:', error);
             }
         },
         async fetchCourses() {
             try {
                 const response = await apiService.getCourses();
                 this.courses = response.data;
             } catch (error) {
                 console.error('Error fetching courses:', error);
             }
         },
         async fetchPlaylists(courseId) {
             try {
                 const response = await apiService.getPlaylists(courseId);
                 this.playlists = response.data;
             } catch (error) {
                 console.error('Error fetching playlists:', error);
             }
         },
         onFileChange(event) {
             this.video.thumbnail = event.target.files[0];
         },
         async updateVideo() {
             const formData = new FormData();
             formData.append('course_id', this.video.course_id);
             formData.append('playlist_id', this.video.playlist_id);
             formData.append('title', this.video.title);
             formData.append('description', this.video.description);
             formData.append('tags', this.video.tags);

             if (this.video.thumbnail) {
                 formData.append('thumbnail', this.video.thumbnail);
             }

             try {
                 await apiService.updateVideo(this.$route.params.id, formData);
               alert("success");
             } catch (error) {
                 console.error('Error updating video:', error);
             }
         },
         openAddPlaylistModal() {
             this.showAddPlaylistModal = true;
         },
         closeAddPlaylistModal() {
             this.showAddPlaylistModal = false;
         },
         async addPlaylist() {
             try {
                 const response = await apiService.addPlaylist(this.video.course_id, this.newPlaylist);
                 this.playlists.push(response.data);
                 this.newPlaylist.name = '';
                 this.showAddPlaylistModal = false;
             } catch (error) {
                 console.error('Error adding playlist:', error);
             }
         }
     }
 };
</script>
