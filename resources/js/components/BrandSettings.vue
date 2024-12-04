<template>
    <div class="container mt-5">
        <h2>Settings</h2>
        <form @submit.prevent="updateSettings">
            <!-- Branding Section -->
            <div class="card mb-4">
                <div class="card-header">
                    Branding
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label for="companyName" class="form-label">Company Name</label>
                        <input type="text" class="form-control" id="companyName" v-model="settings.companyName">
                    </div>
                    <div class="mb-3">
                        <label for="companyLogo" class="form-label">Company Logo URL</label>
                        <input type="text" class="form-control" id="companyLogo" v-model="settings.companyLogo">
                    </div>
                </div>
            </div>

            <!-- Support Section -->
            <div class="card mb-4">
                <div class="card-header">
                    Support
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label for="phoneNumber" class="form-label">Phone Number</label>
                        <input type="text" class="form-control" id="phoneNumber" v-model="settings.phoneNumber">
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" v-model="settings.email">
                    </div>
                </div>
            </div>

            <!-- Social Media Section -->
            <div class="card mb-4">
                <div class="card-header">
                    Social Media
                </div>
                <div class="card-body">
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
                </div>
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
                alert('Settings updated successfully');
            }).catch(error => {
                console.error('Error updating settings:', error);
            });
        }
    }
};
</script>