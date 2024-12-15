<template>
    <div>
        <h1>Leads</h1>
        <button @click="openCreateModal" class="btn btn-primary mb-3">Add Lead</button>

        <div v-for="lead in leads" :key="lead.id" class="card mb-2">
            <div class="card-body">
                <strong>{{ lead.name }}</strong> - {{ lead.email }} - {{ lead.phone }} - {{ lead.status }}
                <div>
                    <button @click="editLead(lead)" class="btn btn-sm btn-warning me-2">Edit</button>
                    <button @click="deleteLead(lead.id)" class="btn btn-sm btn-danger">Delete</button>
                </div>
            </div>
        </div>

        <!-- Create/Edit Lead Modal -->
        <div v-if="showCreateLeadModal" class="modal fade show d-block" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">{{ modalTitle }}</h5>
                        <button type="button" class="btn-close" @click="closeModal"></button>
                    </div>
                    <div class="modal-body">
                        <LeadForm :leadId="selectedLeadId" @saved="handleSaved" />
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import apiService from '@/apiService.js';
import LeadForm from './LeadForm.vue';

export default {
    components: { LeadForm },
    data() {
        return {
            leads: [],
            showCreateLeadModal: false,
            selectedLeadId: null,
            modalTitle: 'Add Lead'
        };
    },
    methods: {
        async fetchLeads() {
            try {
                const response = await apiService.getLeads();
                this.leads = response.data;
            } catch (error) {
                console.error('Error fetching leads:', error);
            }
        },
        editLead(lead) {
            this.selectedLeadId = lead.id;
            this.modalTitle = 'Edit Lead';
            this.showCreateLeadModal = true;
        },
        async deleteLead(id) {
            try {
                await apiService.deleteLead(id);
                this.fetchLeads();
            } catch (error) {
                console.error('Error deleting lead:', error);
            }
        },
        openCreateModal() {
            this.selectedLeadId = null;
            this.modalTitle = 'Add Lead';
            this.showCreateLeadModal = true;
        },
        closeModal() {
            this.showCreateLeadModal = false;
        },
        handleSaved() {
            this.fetchLeads();
            this.closeModal();
        }
    },
    mounted() {
        this.fetchLeads();
    }
};
</script>