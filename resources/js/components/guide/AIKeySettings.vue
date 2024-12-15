<template>
    <div>
        <h2 class="mb-4">AI API Settings</h2>
        <form @submit.prevent="saveApiSettings">
            <div class="form-group mb-3">
                <label for="apiProvider">AI API Provider</label>
                <select class="form-control" id="apiProvider" v-model="apiSettings.provider" required>
                    <option value="openai">OpenAI</option>
                    <option value="google_geminie">Google Geminie</option>
                </select>
            </div>
            <div class="form-group mb-3" v-if="apiSettings.provider === 'openai'">
                <label for="openaiKey">OpenAI Key</label>
                <input type="text" class="form-control" id="openaiKey" v-model="apiSettings.openaiKey" required>
            </div>
            <div class="form-group mb-3" v-if="apiSettings.provider === 'google_geminie'">
                <label for="googleGeminieKey">Google Geminie Key</label>
                <input type="text" class="form-control" id="googleGeminieKey" v-model="apiSettings.googleGeminieKey"
                    required>
            </div>
            <button type="submit" class="btn btn-primary" :disabled="loading">Save Settings</button>
        </form>
        <div v-if="loading" class="alert alert-info mt-3">Loading...</div>

        <p> Only Google Geminie AI is working and in future version we will setup other API provider </p>
    </div>
</template>

<script>
import apiService from '@/apiService';
import { ref, onMounted } from 'vue';
 

export default {
    setup() {
        const apiSettings = ref({
            provider: 'openai',
            openaiKey: '',
            googleGeminieKey: '',
        });
        const loading = ref(false);
    

     
                    
        const fetchApiSettings = async () => {
            loading.value = true;
            try {
                const response = await apiService.getApiSettings();
                apiSettings.value = response.data;
              
            } catch (err) {
                console.error('Error fetching API settings:', err);
                this.$printtoast('Failed to fetch API settings.');
            } finally {
                loading.value = false;
            }
        };

        const saveApiSettings = async () => {
            loading.value = true;
            try {
                const response = await apiService.saveApiSettings(apiSettings.value);
                this.$printtoast(response.data.message || 'API settings saved successfully!');
            } catch (err) {
                console.error('Error saving API settings:', err);
                this.$printtoast(err.response?.data?.error || 'An error occurred while saving settings.');
            } finally {
                loading.value = false;
            }
        };

        onMounted(() => {
            fetchApiSettings();
        });

        return {
            apiSettings,
            loading,
            saveApiSettings,
        };
    },
};
</script>