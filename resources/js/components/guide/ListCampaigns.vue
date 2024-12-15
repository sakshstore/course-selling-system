<template>
    <div>
        <h4>Campaigns</h4>
        <button @click="goToCreateCampaign" class="btn btn-primary mb-3">Create a new Campaign</button>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Type</th>
                    <th scope="col">Subject</th>
                    <th scope="col">Status</th>
                    <th scope="col">Recipients</th>
                    <th scope="col">Created At</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="campaign in campaigns" :key="campaign.id">
                    <th scope="row">{{ campaign.id }}</th>
                    <td>{{ campaign.type }}</td>
                    <td>{{ campaign.subject }}</td>
                    <td>{{ campaign.status }}</td>
                    <td>{{ campaign.recipients.length }}</td>
                    <td>{{ new Date(campaign.created_at).toLocaleString() }}</td>
                    <td>
                        <button @click="goToCampaignStatus(campaign.id)" class="btn btn-info">View</button>
                        <button @click="duplicateCampaign(campaign.id)" class="btn btn-secondary">Duplicate</button>
                    </td>
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
        },
        async duplicateCampaign(campaignId) {
            try {
                await apiService.duplicateCampaign(campaignId);
                this.fetchCampaigns();
                this.$printtoast('Campaign duplicated successfully!');
            } catch (error) {
                console.error('Error duplicating campaign:', error);
                this.$printtoast('Failed to duplicate campaign.');
            }
        }
    }
};
</script>
