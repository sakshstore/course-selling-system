<template>
   <div>
      <h2 class="mb-4">SMTP Settings</h2>
      <form @submit.prevent="saveSmtpSettings">
         <div class="form-group mb-3">
            <label for="smtpHost">SMTP Host</label>
            <input type="text" class="form-control" id="smtpHost" v-model="smtpSettings.host" required>
         </div>
         <div class="form-group mb-3">
            <label for="smtpPort">SMTP Port</label>
            <input type="number" class="form-control" id="smtpPort" v-model="smtpSettings.port" required>
         </div>
         <div class="form-group mb-3">
            <label for="smtpUsername">SMTP Username</label>
            <input type="text" class="form-control" id="smtpUsername" v-model="smtpSettings.username" required>
         </div>
         <div class="form-group mb-3">
            <label for="smtpPassword">SMTP Password</label>
            <input type="password" class="form-control" id="smtpPassword" v-model="smtpSettings.password" required>
         </div>
         <div class="form-group mb-3">
            <label for="smtpEncryption">SMTP Encryption</label>
            <select class="form-control" id="smtpEncryption" v-model="smtpSettings.encryption" required>
               <option value="tls">TLS</option>
               <option value="ssl">SSL</option>
               <option value="none">None</option>
            </select>
         </div>
         <button type="submit" class="btn btn-primary" :disabled="loading">Save Settings</button>
      </form>
      <div v-if="loading" class="alert alert-info mt-3">Loading...</div>
   </div>
</template>

<script>


import apiService from '@/apiService';



import { ref, onMounted } from 'vue';
import { useToast } from 'vue-toastification';

export default {
   setup() {
      const smtpSettings = ref({
         host: '',
         port: '',
         username: '',
         password: '',
         encryption: 'tls',
      });
      const loading = ref(false);
      const toast = useToast();

      const fetchSmtpSettings = async () => {
         loading.value = true;
         try {
            const response = await apiService.getSmtpSettings();
            smtpSettings.value = response.data;

         } catch (err) {
            console.error('Error fetching SMTP settings:', err);

         } finally {
            loading.value = false;
         }
      };

      const saveSmtpSettings = async () => {
         loading.value = true;
         try {
            const response = await apiService.saveSmtpSettings(smtpSettings.value);
            toast.success(response.data.message || 'SMTP settings saved successfully!');
         } catch (err) {
            console.error('Error saving SMTP settings:', err);
            toast.error(err.response?.data?.error || 'An error occurred while saving settings.');
         } finally {
            loading.value = false;
         }
      };

      onMounted(() => {
         fetchSmtpSettings();
      });

      return {
         smtpSettings,
         loading,
         saveSmtpSettings,
      };
   },
};
</script>