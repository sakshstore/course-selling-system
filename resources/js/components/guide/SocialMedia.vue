<template>
    <div >
        <h4>Settings</h4>
        <form @submit.prevent="updateSettings">
            <!-- Social Media Section -->

            <div class="mb-3">
                <label for="whatsapp" class="form-label">WhatsApp</label>
                <input type="text" class="form-control" id="whatsapp" v-model="settings.whatsapp">
            </div>
            <div class="mb-3">
                <label for="instagram" class="form-label">Instagram</label>
                <input type="text" class="form-control" id="instagram" v-model="settings.instagram">
            </div>
            <div class="mb-3">
                <label for="twitter" class="form-label">Twitter</label>
                <input type="text" class="form-control" id="twitter" v-model="settings.twitter">
            </div>
            <div class="mb-3">
                <label for="facebook" class="form-label">Facebook</label>
                <input type="text" class="form-control" id="facebook" v-model="settings.facebook">
            </div>
            <div class="mb-3">
                <label for="youtube" class="form-label">YouTube</label>
                <input type="text" class="form-control" id="youtube" v-model="settings.youtube">
            </div>
            <div class="mb-3">
                <label for="snapchat" class="form-label">Snapchat</label>
                <input type="text" class="form-control" id="snapchat" v-model="settings.snapchat">
            </div>
            <button type="submit" class="btn btn-primary">Save</button>
        </form>
    </div>
</template>

<script>
import apiService from '@/apiService';

export default {
    data() {
        return {
            settings: {
                companyName: '',
                companyLogo: '',
                supportContact: '',
                email: '',
                phoneNumber: '',
                whatsapp: '',
                instagram: '',
                twitter: '',
                facebook: '',
                youtube: '',
                snapchat: ''
            }
        };
    },
    created() {
        this.fetchSettings();
    },
    methods: {
        fetchSettings() {
            apiService.getSettings().then(response => {
                this.settings = response.data;
            }).catch(error => {
                console.error('Error fetching settings:', error);
            });
        },
        updateSettings() {
            apiService.updateSettings(this.settings).then(response => {
                this.$printtoast('Settings updated successfully');
            }).catch(error => {
                console.error('Error updating settings:', error);
            });
        }
    }
};
</script>