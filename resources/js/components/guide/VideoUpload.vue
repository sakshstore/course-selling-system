<template>
   <div>
      <router-link class="nav-link" to="/auth/upload-video">Upload Video</router-link>

      <file-pond ref="pond" name="video"
         label-idle='Drag & Drop your videos or <span class="filepond--label-action">Browse</span>'
         allow-multiple="true" accepted-file-types="video/*" @updatefiles="handleFileUpdate"></file-pond>
      <div class="text-center mt-4">
         <button @click="uploadAllVideos" class="btn btn-success">Upload All Videos</button>
      </div>
      <div v-if="uploadProgress !== null" class="progress mt-3">
         <div class="progress-bar" role="progressbar" :style="{ width: uploadProgress + '%' }"
            :aria-valuenow="uploadProgress" aria-valuemin="0" aria-valuemax="100">
            {{ uploadProgress }}%
         </div>
      </div>
      <div v-if="uploadMessage" class="alert" :class="uploadMessageClass">
         {{ uploadMessage }}
      </div>

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
import vueFilePond from 'vue-filepond';
import FilePondPluginFileValidateType from 'filepond-plugin-file-validate-type';
import FilePondPluginImagePreview from 'filepond-plugin-image-preview';
import 'filepond/dist/filepond.min.css';
import 'filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css';
import apiService from '@/apiservice';

// Create FilePond component
const FilePond = vueFilePond(FilePondPluginFileValidateType, FilePondPluginImagePreview);

export default {
   components: {
      FilePond,
   },
   data() {
      return {
         files: [],
         course_id: '', // Add course_id
         playlist_id: '', // Add playlist_id
         description: '', // Add description
         uploadProgress: null, // Add uploadProgress
         uploadMessage: '', // Add uploadMessage
         uploadMessageClass: '', // Add uploadMessageClass
         videos: [], // Add videos array
      };
   },
   methods: {
      handleFileUpdate(fileItems) {
         // Set the files property to the file objects
         this.files = fileItems.map((fileItem) => fileItem.file);
      },

      fetchUserVideos() {
         apiService.getUnattachedVideos()
            .then(response => {
               this.videos = response.data;
            })
            .catch(error => {
               console.error('Error fetching videos:', error);
            });
      },

      async uploadAllVideos() {
         const formData = new FormData();
         this.files.forEach((file, index) => {
            formData.append(`videos[${index}]`, file);
         });
         formData.append('course_id', this.course_id); // Append course_id
         formData.append('playlist_id', this.playlist_id); // Append playlist_id
         formData.append('description', this.description); // Append description

         try {
            await apiService.uploadMultipleVideos(formData, (progressEvent) => {
               this.uploadProgress = Math.round((progressEvent.loaded * 100) / progressEvent.total);
            });

            this.files = [];
            this.$refs.pond.removeFiles();
            this.uploadProgress = null; // Reset progress
            this.uploadMessage = 'Videos uploaded successfully!';
            this.uploadMessageClass = 'alert-success';
            this.fetchUserVideos(); // Refresh the video list
         } catch (error) {
            console.error('Error uploading videos:', error);
            this.uploadMessage = 'Failed to upload videos.';
            this.uploadMessageClass = 'alert-danger';
            this.uploadProgress = null; // Reset progress
         }
      },
   },
   mounted() {
      this.fetchUserVideos(); // Fetch videos when the component is mounted
   },
};
</script>

<style scoped>
.progress {
   height: 20px;
}

.progress-bar {
   background-color: #28a745;
}

.alert {
   margin-top: 20px;
   padding: 10px;
   border-radius: 5px;
}

.alert-success {
   background-color: #d4edda;
   color: #155724;
}

.alert-danger {
   background-color: #f8d7da;
   color: #721c24;
}
</style>