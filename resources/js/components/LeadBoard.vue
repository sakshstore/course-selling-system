<template>
    <div>
        <h1 class="mb-4">Leads
            <button @click="openCreateModal" class="btn btn-info btn-sm me-3">Add Lead</button>

            <button @click="createDummyData" class="btn btn-info btn-sm me-3">Create Dummy Data</button>


            <router-link :to="{ name: 'ContactImport' }" class="btn btn-info btn-sm me-3">
                <i class="fas fa-file-import"></i>Import
            </router-link>
            <router-link :to="{ name: 'ContactExport' }" class="btn btn-info btn-sm me-3">
                <i class="fas fa-file-export"></i>Export
            </router-link>

            <button @click="deleteAll" class="btn btn-danger btn-sm me-3">Delete All</button>

        </h1>
        <div class="row">
            <div class="col-md-3" v-for="(column, index) in columns" :key="index" :data-status="column.status">
                <div class="card mb-4">
                    <div class="card-header  d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">{{ column.status }}</h5>
                    </div>
                    <div class="card-body p-2">
                        <VueDraggableNext v-model="column.items" group="columns" @end="onEnd">
                            <div v-for="lead in column.items" :key="lead.id" class="card mb-2 shadow-sm"
                                :data-id="lead.id">
                                <div class="card-body p-3 position-relative">
                                    <strong>{{ lead.name }}</strong>
                                    <p class="mb-1">{{ lead.email }}</p>
                                    <p class="mb-1">{{ lead.phone }}</p>
                                    <p class="mb-1"><span class="badge bg-info">{{ lead.status }}</span></p>
                                    <div class="dropdown position-absolute top-0 end-0 me-2 mt-2">
                                        <button class="btn btn-link text-white   p-0" type="button"
                                            id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">


                                            <i class="fa-solid fa-bars"></i>
                                        </button>
                                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                            <li><a class="dropdown-item" href="#" @click="editLead(lead)">Edit</a></li>
                                            <li><a class="dropdown-item" href="#"
                                                    @click="deleteLead(lead.id)">Delete</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </VueDraggableNext>
                    </div>
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
import axios from 'axios';
import { defineComponent } from 'vue';
import { VueDraggableNext } from 'vue-draggable-next';
import LeadForm from './LeadForm.vue';

export default defineComponent({
    components: { LeadForm, VueDraggableNext },
    data() {
        return {
            columns: [],
            showCreateLeadModal: false,
            selectedLeadId: null,
            modalTitle: 'Add Lead',
        };
    },
    methods: {
        async fetchLeadStatuses() {
            const response = await axios.get('/v1/get_lead_status');
            const statuses = response.data;
            this.columns = statuses.map(status => ({ status, items: [] }));
            this.fetchLeads();
        },
        async fetchLeads() {
            const response = await axios.get('/v1/leads_list');
            const leads = response.data;
            this.columns.forEach(column => {
                column.items = leads.filter(lead => lead.status === column.status);
            });
        },
        editLead(lead) {
            this.selectedLeadId = lead.id;
            this.modalTitle = 'Edit Lead';
            this.showCreateLeadModal = true;
        },
        async deleteLead(id) {
            await axios.delete(`/v1/leads/${id}`);
            this.fetchLeads();
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
        },
        async onEnd(event) {
            const movedElement = event.item;
            const newStatus = event.to.closest('.col-md-3').getAttribute('data-status');
            const leadId = movedElement.getAttribute('data-id');

            const lead = this.columns.flatMap(column => column.items).find(item => item.id == leadId);
            if (lead && lead.status !== newStatus) {
                lead.status = newStatus;
                await axios.put(`/v1/leads/updateStatus/${lead.id}`, { status: newStatus });
            }
        },
        async createDummyData() {
            await axios.post('/v1/leads/bulk_create');
            this.fetchLeads();
        },

        async deleteAll() {
            await axios.delete('/v1/leads/delete_all');
            this.fetchLeads();
        }
    },
    mounted() {
        this.fetchLeadStatuses();
    },
});
</script>