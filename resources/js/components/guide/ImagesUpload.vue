<template>
    <div>
        <!-- Logo Upload -->
        <p>Upload Logo</p>
        <file-pond ref="logoPond" name="companyLogo"
            label-idle='Drag & Drop your logo or <span class="filepond--label-action">Browse</span>'
            accepted-file-types="image/*" @updatefiles="handleLogoFileUpdate">
        </file-pond>
        <div class="text-center mt-4">
            <button @click="uploadLogo" class="btn btn-success">Upload Logo</button>
        </div>
        <div v-if="logoUploadProgress !== null" class="progress mt-3">
            <div class="progress-bar" role="progressbar" :style="{ width: logoUploadProgress + '%' }"
                :aria-valuenow="logoUploadProgress" aria-valuemin="0" aria-valuemax="100">
                {{ logoUploadProgress }}%
            </div>
        </div>
        <div v-if="logoUploadMessage" class="alert" :class="logoUploadMessageClass">
            {{ logoUploadMessage }}
        </div>

        <!-- Banner Upload -->
        <p >Upload Login Page Banner</p>
        <file-pond ref="bannerPond" name="loginBanner"
            label-idle='Drag & Drop your banner or <span class="filepond--label-action">Browse</span>'
            accepted-file-types="image/*" @updatefiles="handleBannerFileUpdate">
        </file-pond>
        <div class="text-center mt-4">
            <button @click="uploadBanner" class="btn btn-success">Upload Banner</button>
        </div>
        <div v-if="bannerUploadProgress !== null" class="progress mt-3">
            <div class="progress-bar" role="progressbar" :style="{ width: bannerUploadProgress + '%' }"
                :aria-valuenow="bannerUploadProgress" aria-valuemin="0" aria-valuemax="100">
                {{ bannerUploadProgress }}%
            </div>
        </div>
        <div v-if="bannerUploadMessage" class="alert" :class="bannerUploadMessageClass">
            {{ bannerUploadMessage }}
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
            logoFiles: [],
            bannerFiles: [],
            logoUploadProgress: null,
            bannerUploadProgress: null,
            logoUploadMessage: '',
            bannerUploadMessage: '',
            logoUploadMessageClass: '',
            bannerUploadMessageClass: '',
        };
    },
    methods: {
        handleLogoFileUpdate(fileItems) {
            // Set the logoFiles property to the file objects
            this.logoFiles = fileItems.map((fileItem) => fileItem.file);
        },
        handleBannerFileUpdate(fileItems) {
            // Set the bannerFiles property to the file objects
            this.bannerFiles = fileItems.map((fileItem) => fileItem.file);
        },
        async uploadLogo() {
            const formData = new FormData();
            this.logoFiles.forEach((file, index) => {
                formData.append('companyLogo', file);
            });

            try {
                await apiService.savecompanyLogo(formData, (progressEvent) => {
                    this.logoUploadProgress = Math.round((progressEvent.loaded * 100) / progressEvent.total);
                });

                this.logoFiles = [];
                this.$refs.logoPond.removeFiles();
                this.logoUploadProgress = null; // Reset progress
                this.logoUploadMessage = 'Logo uploaded successfully!';
                this.logoUploadMessageClass = 'alert-success';
            } catch (error) {
                console.error('Error uploading logo:', error);
                this.logoUploadMessage = 'Failed to upload logo.';
                this.logoUploadMessageClass = 'alert-danger';
                this.logoUploadProgress = null; // Reset progress
            }
        },
        async uploadBanner() {
            const formData = new FormData();
            this.bannerFiles.forEach((file, index) => {
                formData.append('loginBanner', file);
            });

            try {
                await apiService.saveloginBanner(formData, (progressEvent) => {
                    this.bannerUploadProgress = Math.round((progressEvent.loaded * 100) / progressEvent.total);
                });

                this.bannerFiles = [];
                this.$refs.bannerPond.removeFiles();
                this.bannerUploadProgress = null; // Reset progress
                this.bannerUploadMessage = 'Banner uploaded successfully!';
                this.bannerUploadMessageClass = 'alert-success';
            } catch (error) {
                console.error('Error uploading banner:', error);
                this.bannerUploadMessage = 'Failed to upload banner.';
                this.bannerUploadMessageClass = 'alert-danger';
                this.bannerUploadProgress = null; // Reset progress
            }
        },
    },
};


</script>