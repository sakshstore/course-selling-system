<template>
    <div  >
        <h2>Campaign Details</h2>
        <ul class="nav nav-tabs" id="campaignTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="details-tab" data-bs-toggle="tab" data-bs-target="#details"
                    type="button" role="tab" aria-controls="details" aria-selected="true">Campaign Details</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="recipients-tab" data-bs-toggle="tab" data-bs-target="#recipients"
                    type="button" role="tab" aria-controls="recipients" aria-selected="false">Recipient List</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="progress-tab" data-bs-toggle="tab" data-bs-target="#progress" type="button"
                    role="tab" aria-controls="progress" aria-selected="false">Progress Report</button>
            </li>
        </ul>
        <div class="tab-content" id="campaignTabsContent">
            <div class="tab-pane fade show active" id="details" role="tabpanel" aria-labelledby="details-tab">
                <div v-if="loading" class="text-center mt-3">
                    <div class="spinner-border" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
                <div v-else-if="campaign" class="card mt-3">
                    <div class="card-body">
                        <p><strong>Subject:</strong> {{ campaign.subject }}</p>
                        <p><strong>Message:</strong> {{ campaign.message }}</p>
                        <p><strong>Created At:</strong> {{ new Date(campaign.created_at).toLocaleString() }}</p>
                    </div>
                </div>
                <div v-else class="alert alert-danger mt-3">
                    Failed to load campaign details. Please try again later.
                </div>
            </div>
            <div class="tab-pane fade" id="recipients" role="tabpanel" aria-labelledby="recipients-tab">
                <div v-if="loading" class="text-center mt-3">
                    <div class="spinner-border" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
                <div v-else-if="campaign" class="card mt-3">
                    <div class="card-body">
                        <h3>Recipient List</h3>
                        <ul class="list-group">
                            <li v-for="recipient in campaign.recipients" :key="recipient" class="list-group-item">
                                {{ recipient.contact }}
                            </li>
                        </ul>
                    </div>
                </div>
                <div v-else class="alert alert-danger mt-3">
                    Failed to load recipient list. Please try again later.
                </div>
            </div>
            <div class="tab-pane fade" id="progress" role="tabpanel" aria-labelledby="progress-tab">
                <div v-if="loading" class="text-center mt-3">
                    <div class="spinner-border" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
                <div v-else-if="campaign" class="card mt-3">
                    <div class="card-body">
                        <h3>Progress Report</h3>
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">Recipient</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Delivered At</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="report in campaign.delivery_reports" :key="report.id">
                                    <td>{{ report.recipient }}</td>
                                    <td>{{ report.status }}</td>
                                    <td>{{ report.delivered_at ? new Date(report.delivered_at).toLocaleString() :
                                        'Pending' }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div v-else class="alert alert-danger mt-3">
                    Failed to load progress report. Please try again later.
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    props: ['id'],
    data() {
        return {
            campaign: null,
            loading: true,
            error: false
        };
    },
    created() {
        this.fetchCampaign();
    },
    methods: {
        async fetchCampaign() {
            try {
                const response = await axios.get(`/v1/campaign/${this.id}`);
                this.campaign = response.data;
            } catch (error) {
                console.error(error);
                this.error = true;
            } finally {
                this.loading = false;
            }
        }
    }
};
</script>

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