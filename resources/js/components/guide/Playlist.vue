
<template>
    <div>
    <h2 class="mb-4">Playlists for {{ course.title }}</h2>
    
    <button @click="openAddPlaylistModal" class="btn btn-success mt-4">
    Add Playlist
    </button>
    <table class="table table-bordered">
            <tr v-for="playlist in playlists" :key="playlist.id" >
                <td>{{ playlist.name }}</td>
              
            </tr>
        </table>

    
     
    
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
    <div class="mb-3">
    <label for="name" class="form-label">Name</label>
    <input v-model="newPlaylist.name" type="text" class="form-control" id="name" placeholder="Name" required>
    </div>
    <button type="submit" class="btn btn-success">Add Playlist</button>
    </form>
    </div>
    </div>
    </div>
    </div>
    </div>
    </template>
    
    <script>
    import { ref, onMounted } from 'vue';
    import { useRoute } from 'vue-router';
    import apiService from '@/apiservice.js';
    
    export default {
    setup() {
    const route = useRoute();
    const course = ref({});
    const playlists = ref([]);
    const newPlaylist = ref({ name: '' });
    const showAddPlaylistModal = ref(false);
    
    const fetchCourse = async () => {
    const courseId = route.params.courseId;
    try {
    const response = await apiService.getCourseDetails(courseId);
    course.value = response.data;
    } catch (error) {
    console.error('Error fetching course details:', error);
    }
    };
    
    const fetchPlaylists = async () => {
    const courseId = route.params.courseId;
    try {
    const response = await apiService.getPlaylists(courseId);
    playlists.value = response.data;
    } catch (error) {
    console.error('Error fetching playlists:', error);
    }
    };
    
    const addPlaylist = async () => {
    const courseId = route.params.courseId;
    try {
    const response = await apiService.addPlaylist(courseId, newPlaylist.value);
    playlists.value.push(response.data);
    newPlaylist.value.name = '';
    showAddPlaylistModal.value = false;
    } catch (error) {
    console.error('Error adding playlist:', error);
    }
    };
    
    const openAddPlaylistModal = () => {
    showAddPlaylistModal.value = true;
    };
    
    const closeAddPlaylistModal = () => {
    showAddPlaylistModal.value = false;
    };
    
    onMounted(() => {
    fetchCourse();
    fetchPlaylists();
    });
    
    return {
    course,
    playlists,
    newPlaylist,
    showAddPlaylistModal,
    fetchCourse,
    fetchPlaylists,
    addPlaylist,
    openAddPlaylistModal,
    closeAddPlaylistModal,
    };
    },
    };
    </script>