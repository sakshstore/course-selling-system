<template>
    <div>
        <form @submit.prevent="saveLead" class="needs-validation" novalidate>
            <!-- Name Field -->
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input v-model="lead.name" type="text" class="form-control" id="name" placeholder="Name" required>
                <div class="invalid-feedback">
                    Please provide a name.
                </div>
            </div>
            <!-- Email Field -->
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input v-model="lead.email" type="email" class="form-control" id="email" placeholder="Email" required>
                <div class="invalid-feedback">
                    Please provide a valid email.
                </div>
            </div>
            <!-- Phone Field -->
            <div class="mb-3">
                <label for="phone" class="form-label">Phone</label>
                <input v-model="lead.phone" type="text" class="form-control" id="phone" placeholder="Phone" required>
                <div class="invalid-feedback">
                    Please provide a phone number.
                </div>
            </div>
            <!-- Status Field -->
            <div class="mb-3">
                <label for="status" class="form-label">Status</label>
                <select v-model="lead.status" class="form-select" id="status" required>
                    <option v-for="status in statuses" :key="status" :value="status">{{ status }}</option>
                </select>
                <div class="invalid-feedback">
                    Please select a status.
                </div>
            </div>
            <!-- Tags Field -->
            <div class="mb-3">
                <label for="tags" class="form-label">Tags</label>
                <vue3-tags-input :tags="lead.tags" @on-tags-changed="updateTags" placeholder="Add a tag" />
                <div class="invalid-feedback">
                    Please provide tags.
                </div>
            </div>
            <!-- Submit Button -->
            <button type="submit" class="btn btn-primary" :disabled="loading">
                <span v-if="loading" class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                Save
            </button>
        </form>
    </div>
</template>




<script>




import axios from 'axios';
import Vue3TagsInput from 'vue3-tags-input';

export default {
    components: {
        Vue3TagsInput
    },
    props: ['leadId'],
    data() {
        return {
            lead: {
                name: '',
                email: '',
                phone: '',
                status: 'new',
                tags: [] // Ensure this is always an array
            },
            tag: '',
            statuses: ['New', 'Contacted', 'Qualified', 'Lost', 'Won'],
            loading: false
        };
    },
    methods: {
        async saveLead() {
            this.loading = true;
            try {




                const leadData = { ...this.lead };


                if (this.leadId) {
                    await axios.put(`/v1/leads/${this.leadId}`, leadData);
                } else {
                    await axios.post('/v1/leads', leadData);
                }
                this.$emit('saved');
                this.resetForm();
            } catch (error) {
                console.error('Error saving lead:', error);
            } finally {
                this.loading = false;
            }
        },
        async fetchLead() {
            if (this.leadId) {
                this.loading = true;
                try {
                    const response = await axios.get(`/v1/leads/${this.leadId}`);
                    const lead = response.data;
                    // Ensure tags is an array


                    lead.tags = Array.isArray(lead.tags) ? lead.tags.map(tag => tag.name) : [];


                    this.lead = lead;
                } catch (error) {
                    console.error('Error fetching lead:', error);
                } finally {
                    this.loading = false;
                }
            }
        },
        updateTags(newTags) {
            this.lead.tags = newTags;


        },
        resetForm() {
            this.lead = {
                name: '',
                email: '',
                phone: '',
                status: 'new',
                tags: []
            };
        }
    },
    mounted() {
        this.fetchLead();
    },
    watch: {
        leadId(newId, oldId) {
            if (newId !== oldId) {
                this.fetchLead();
            }
        }
    }
};

</script>

<style>
.v3ti .v3ti-new-tag {

    background-color: var(--bs-body-bg) !important;
}
</style>