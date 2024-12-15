<template>
    <div   >
      
        <form @submit.prevent="testSmtpSettings">
            <div class="form-group mb-3">
                <label for="testEmail">Test Email Address</label>
                <input type="email" class="form-control" id="testEmail" v-model="testEmail" required>
            </div>
            <button type="submit" class="btn btn-secondary" :disabled="loading">Send Test Email</button>
        </form>
        <div v-if="loading" class="alert alert-info mt-3">Loading...</div>
    </div>
</template>


<script>
import apiService from '@/apiService';
import { ref } from 'vue';
import { useToast } from 'vue-toastification';

export default {
    setup() {
        const testEmail = ref('');
        const loading = ref(false);
        const toast = useToast();

        const testSmtpSettings = async () => {
            loading.value = true;
            try {
                const response = await apiService.testSmtpSettings({ email: testEmail.value });
                toast.success(response.data.message || 'Test email sent successfully!');
            } catch (err) {
                console.error('Error sending test email:', err);
                toast.error(err.response?.data?.error || 'An error occurred while sending test email.');
            } finally {
                loading.value = false;
            }
        };

        return {
            testEmail,
            loading,
            testSmtpSettings,
        };
    },
};

</script>