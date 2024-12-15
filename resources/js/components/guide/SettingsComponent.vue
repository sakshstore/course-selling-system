<template>
    <div>
        <h4>Settings</h4>
        <b-tabs>

            <b-tab title="Brand Setting">
                <BrandSettings />
            </b-tab>

            <b-tab title="Images Upload">
                <ImagesUpload />
            </b-tab>

            
            <b-tab title="Social Media">
                <SocialMedia />
            </b-tab>



            <b-tab title="Text Settings">
                <TextSettings />
            </b-tab>

            <b-tab title="Currency Setting">
                <form @submit.prevent="updateSettings">
                    <div class="mb-3">
                        <label for="currency_symbol" class="form-label">Currency Symbol</label>
                        <input type="text" class="form-control" id="currency_symbol" v-model="currencySymbol"
                            required />
                    </div>
                    <button type="submit" class="btn btn-primary">Save</button>
                </form>
            </b-tab>

            <b-tab title="SMTP Setting">
                <SmtpSettings />


                <hr />

                <TestSMTPsettings/>


                
            </b-tab>
            <b-tab title="AI Key ">
                <AIKeySettings />
            </b-tab>

            

            <b-tab title="API Token">
                <div class="mt-3">
                    <p>API Token: <strong>{{ token }}</strong></p>
                </div>
            </b-tab>


        </b-tabs>

        <p><a target="_blank" href="https://github.com/sakshstore/course-selling-system/wiki" > Project Wiki </a> </p>
    </div>
</template>

<script>
import { ref, onMounted } from 'vue';
import apiService from '@/apiService.js';
import { useToast } from 'vue-toastification';
import SmtpSettings from '@/components/guide/SmtpSettings.vue'; // Adjust the path as needed
import BrandSettings from '@/components/guide/BrandSettings.vue';

import SocialMedia from '@/components/guide/SocialMedia.vue';
import TextSettings from '@/components/guide/TextSettings.vue'; // 
import ImagesUpload from '@/components/guide/ImagesUpload.vue'; // 

import AIKeySettings from '@/components/guide/AIKeySettings.vue'; // 

import TestSMTPsettings from '@/components/guide/TestSMTPsettings.vue'; // 






export default {
    components: {
        SmtpSettings,TextSettings,
        BrandSettings, SocialMedia, ImagesUpload,AIKeySettings,TestSMTPsettings,
    },
    setup() {
        const currencySymbol = ref('');
        const token = ref('');
        const toast = useToast();

        const fetchAPIToken = async () => {
            try {
                const response = await apiService.getApiToken();
                token.value = response.data.token;
            } catch (error) {
                console.error('Error fetching API token:', error);
            }
        };

        const fetchSettings = async () => {
            try {
                const response = await apiService.getSettings();
                currencySymbol.value = response.data.currency_symbol;
            } catch (error) {
                console.error('Error fetching settings:', error);
            }
        };

        const updateSettings = async () => {
            try {
                const response = await apiService.updateCurrencySymbol(currencySymbol.value);
                toast.success('Settings updated successfully!');
            } catch (error) {
                console.error('Error updating settings:', error);
            }
        };

        onMounted(() => {
            fetchSettings();
            fetchAPIToken();
        });

        return {
            currencySymbol,
            token,
            updateSettings,
        };
    },
};
</script>