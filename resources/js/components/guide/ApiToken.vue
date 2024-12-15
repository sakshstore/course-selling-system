<template>
    <div>
        <h1>Settings</h1>

        <form @submit.prevent="updateSettings">
            <div class="mb-3">
                <label for="currency_symbol" class="form-label">Currency Symbol</label>
                <input type="text" class="form-control" id="currency_symbol" v-model="currencySymbol" required />
            </div>
            <button type="submit" class="btn btn-primary">Save</button>
        </form>

        <div class="mt-3">
            <p>API Token: <strong>{{ token }}</strong></p>
        </div>
    </div>
</template>

<script>
import { ref, onMounted } from 'vue';
import apiService from '@/apiService.js';

export default {
    setup() {
        const currencySymbol = ref('');
        const token = ref('');

        const fetchAPIToken = async () => {
            try {
                const response = await apiService.getApiToken();
                token.value = response.data.token;
            } catch (error) {
                this.$printtoast('Error fetching API token:', error);
            }
        };




        onMounted(() => {

            fetchAPIToken();
        });

        return {

            token,
            updateSettings,
        };
    },
};
</script>