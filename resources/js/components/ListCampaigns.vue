<template>
    <div>
        <h2 class="mb-4">Campaigns</h2>
        <button @click="goToCreateCampaign" class="btn btn-primary mb-3">Create Campaign</button>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Type</th>
                    <th scope="col">Subject</th>
                    <th scope="col">Message</th>
                    <th scope="col">Recipients</th>
                    <th scope="col">Created At</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="campaign in campaigns" :key="campaign.id" @click="goToCampaignStatus(campaign.id)">
                    <th scope="row">{{ campaign.id }}</th>
                    <td>{{ campaign.type }}</td>
                    <td>{{ campaign.subject }}</td>
                    <td>{{ campaign.message }}</td>
                    <td>{{ campaign.recipients.length }}</td>
                    <td>{{ new Date(campaign.created_at).toLocaleString() }}</td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
import apiService from '@/apiService.js';

export default {
    data() {
        return {
            campaigns: []
        };
    },
    created() {
        this.fetchCampaigns();
    },
    methods: {
        async fetchCampaigns() {
            try {
                const response = await apiService.getCampaigns();
                this.campaigns = response.data;
            } catch (error) {
                console.error('Error fetching campaigns:', error);
            }
        },
        goToCreateCampaign() {
            this.$router.push('/guide/campaigns/create');
        },
        goToCampaignStatus(campaignId) {
            this.$router.push(`/guide/campaign/${campaignId}`);
        }
    }
};
</script>