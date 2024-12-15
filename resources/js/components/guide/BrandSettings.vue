<template>
    <div  >
        <h4>Settings</h4>
        <form @submit.prevent="updateSettings">


            <div class="mb-3">
                <label for="companyName" class="form-label">Company Name</label>
                <input type="text" class="form-control" id="companyName" v-model="settings.companyName">
            </div>
            <div class="mb-3">
                <label for="companyLogo" class="form-label">Company Logo URL</label>
                <input type="text" class="form-control" id="companyLogo" v-model="settings.companyLogo">
            </div>

            <div class="mb-3">
                <label for="phoneNumber" class="form-label">Phone Number</label>
                <input type="text" class="form-control" id="phoneNumber" v-model="settings.phoneNumber">
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" v-model="settings.email">
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