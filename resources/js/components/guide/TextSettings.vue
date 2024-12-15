<template>
    <div  >
        <h4>Text Settings</h4>
        <form @submit.prevent="updateTextSettings">
            <!-- Footer Text Section -->

            <div class="mb-3">
                <label for="footerText" class="form-label">Footer Text</label>
                <textarea class="form-control" id="footerText" v-model="textSettings.footerText" required></textarea>
            </div>

            <div class="mb-3">
                <label for="welcomeText" class="form-label">Welcome Text</label>
                <textarea class="form-control" id="welcomeText" v-model="textSettings.welcomeText" required></textarea>
            </div>

            <div class="mb-3">
                <label for="supportText" class="form-label">Support Request Text</label>
                <textarea class="form-control" id="supportText" v-model="textSettings.supportText" required></textarea>
            </div>

            <button type="submit" class="btn btn-primary">Save</button>
        </form>
    </div>
</template>

<script>
import apiService from '@/apiService';
import { ref, onMounted } from 'vue';
import { useToast } from 'vue-toastification';

export default {
    setup() {

        
        const textSettings = ref({
            footerText: '',
            welcomeText: '',
            supportText: '',
        });
        const loading = ref(false);
        const toast = useToast();

        const fetchTextSettings = async () => {
            loading.value = true;
            try {
                const response = await apiService.getSectionsText();
                textSettings.value = response.data;
              
            } catch (err) {
                console.error('Error fetching text settings:', err);
                toast.error('Failed to fetch text settings.');
            } finally {
                loading.value = false;
            }
        };

        const updateTextSettings = async () => {
            loading.value = true;
            try {
    

                const response = await apiService.postSectionsText(textSettings.value);
                toast.success(response.data.message || 'Text settings saved successfully!');
            } catch (err) {
                console.error('Error saving text settings:', err);
                toast.error(err.response?.data?.error || 'An error occurred while saving settings.');
            } finally {
                loading.value = false;
            }
        };

        onMounted(() => {
            fetchTextSettings();
        });

        return {
            textSettings,
            loading,
            updateTextSettings,
        };
    },
};
</script>