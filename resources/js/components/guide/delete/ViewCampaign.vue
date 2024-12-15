<template>
    <div>
        <h4>Campaign Details   </h4>
        <b-button @click="duplicateCampaign" variant="primary" class="mb-3">Duplicate Campaign</b-button>
        <b-tabs pills card>
            <b-tab title="Campaign Details" active>
                <div v-if="loading" class="text-center mt-3">
                    <b-spinner label="Loading..."></b-spinner>
                </div>
                <div v-else-if="campaign" class="card mt-3">
                    <div class="card-body">
                        <p><strong>Subject:</strong> {{ campaign.subject }}</p>

                        <p><strong>Message:</strong> {{ campaign.message }}</p>


                        <p><strong>Status:</strong> {{ campaign.status }}</p>
                        <p><strong>Type:</strong> {{ campaign.type }}</p>
                        <p><strong>Created At:</strong> {{ new Date(campaign.created_at).toLocaleString() }}</p>
                    </div>
                </div>
                <div v-else class="alert alert-danger mt-3">
                    Failed to load campaign details. Please try again later.
                </div>
            </b-tab>
            <b-tab title="Recipient List">
                <div v-if="loading" class="text-center mt-3">
                    <b-spinner label="Loading..."></b-spinner>
                </div>
                <div v-else-if="campaign" class="card mt-3">
                    <div class="card-body">
                        <h3>Recipient List</h3>
                        <b-table :items="campaign.recipients" :fields="recipientFields" bordered>
                            <template #cell(contact)="data">
                                {{ data.item.contact }}
                            </template>
                            <template #cell(status)="data">
                                {{ data.item.status }}
                            </template>
                            <template #cell(updated_at)="data">
                                {{ new Date(data.item.updated_at).toLocaleString() }}
                            </template>
                        </b-table>
                    </div>
                </div>
                <div v-else class="alert alert-danger mt-3">
                    Failed to load recipient list. Please try again later.
                </div>
            </b-tab>
            <b-tab title="Progress Report">
                <div v-if="loading" class="text-center mt-3">
                    <b-spinner label="Loading..."></b-spinner>
                </div>
                <div v-else-if="campaign" class="card mt-3">
                    <div class="card-body">
                        <!-- Progress report content goes here -->
                    </div>
                </div>
                <div v-else class="alert alert-danger mt-3">
                    Failed to load progress report. Please try again later.
                </div>
            </b-tab>
        </b-tabs>
    </div>
</template>

Script
<script>
import { ref, onMounted } from 'vue';
import { useRouter } from 'vue-router';
import apiService from '@/apiservice';

export default {
    props: ['id'],
    setup(props) {
        const campaign = ref(null);
        const loading = ref(true);
        const error = ref(false);
        const router = useRouter();

        const recipientFields = [
            { key: 'contact', label: 'Contact' },
            { key: 'status', label: 'Status' },
            { key: 'updated_at', label: 'Updated At' }
        ];

        const fetchCampaign = async () => {
            try {
                const response = await apiService.getCampaign(props.id);
                campaign.value = response.data;
            } catch (err) {
                console.error(err);
                error.value = true;
            } finally {
                loading.value = false;
            }
        };

        const duplicateCampaign = async () => {
            try {
                const response = await apiService.duplicateCampaign(props.id);
                router.push(`/guide/campaign/${response.data.id}`);
            } catch (err) {
                console.error('Error duplicating campaign:', err);
                this.$printtoast('Failed to duplicate campaign.');
            }
        };

        onMounted(fetchCampaign);

        return {
            campaign,
            loading,
            error,
            recipientFields,
            duplicateCampaign
        };
    }
};
</script>

Style
<style scoped>
.card {
    margin-top: 20px;
}

.spinner-border {
    width: 3rem;
    height: 3rem;
}

.alert {
    margin-top: 20px;
}
</style>