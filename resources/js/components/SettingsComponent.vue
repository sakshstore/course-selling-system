<template>
    <div>
        <h1>Settings</h1>
        <form @submit.prevent="updateSettings">
            <div class="form-group">
                <label for="currency_symbol">Currency Symbol</label>
                <input type="text" class="form-control" id="currency_symbol" v-model="currencySymbol" required />
            </div>
            <button type="submit" class="btn btn-primary">Save</button>
        </form>
    </div>
</template>

<script>
import { ref } from 'vue';
import axios from 'axios';

export default {
    setup() {
        const currencySymbol = ref('');

        const fetchSettings = async () => {
            try {
                const response = await axios.get('/v1/settings/currency-symbol');
                currencySymbol.value = response.data.value;
            } catch (error) {
                console.error('Error fetching settings:', error);
            }
        };

        const updateSettings = async () => {
            try {
                await axios.post('/v1/settings', {
                    currency_symbol: currencySymbol.value,
                });
                alert('Settings updated successfully');
            } catch (error) {
                console.error('Error updating settings:', error);
            }
        };

        fetchSettings();

        return {
            currencySymbol,
            updateSettings,
        };
    },
};
</script>