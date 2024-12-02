<template>
    <div>
        <h2 class="mb-4">Create Campaign</h2>
        <form @submit.prevent="createCampaign">
            <div class="mb-3">
                <label for="type" class="form-label">Type</label>
                <select v-model="type" class="form-select" id="type" required>
                    <option value="email">Email</option>
                    <option value="sms">SMS</option>
                    <option value="whatsapp">WhatsApp</option>
                    <option value="notification">Notification</option>
                </select>
            </div>
            <div class="mb-3" v-if="type === 'email'">
                <label for="subject" class="form-label">Subject</label>
                <input v-model="subject" type="text" class="form-control" id="subject" placeholder="Subject" />
            </div>
            <div class="mb-3">
                <label for="message" class="form-label">Message</label>
                <textarea v-model="message" class="form-control" id="message" rows="3" placeholder="Message"
                    required></textarea>
            </div>
            <div class="mb-3">
                <label for="recipientType" class="form-label">Contacts</label>
                <select v-model="recipientType" class="form-select" id="recipientType" required>
                    <option value="students">To Students</option>
                    <option value="leads">To Leads</option>
                    <option value="manual">Type Emails</option>
                </select>
            </div>
            <div class="mb-3" v-if="recipientType === 'students' || recipientType === 'leads'">
                <label for="tags" class="form-label">Tags</label>
                <multiselect v-model="selectedTags" :options="tags" :multiple="true" :close-on-select="false"
                    :clear-on-select="false" :preserve-search="true" placeholder="Pick some" label="name"
                    track-by="name" taggable @tag="addTag">
                   
                </multiselect>
            </div>
            <div class="mb-3" v-if="recipientType === 'manual'">
                <label for="contacts" class="form-label">Contacts</label>
                <textarea v-model="contacts" class="form-control" id="contacts" rows="3"
                    placeholder="Enter contacts separated by commas"></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Create Campaign</button>
        </form>
        <div v-if="errorMessage" class="alert alert-danger mt-3">{{ errorMessage }}</div>
    </div>
</template>

<script>
import axios from 'axios';
import Multiselect from 'vue-multiselect';
export default {
    components: { Multiselect },
    data() {
        return {
            type: 'email',
            subject: '',
            message: '',
            recipientType: 'students',
            contacts: '',
            selectedTags: [],
            tags: [],
            errorMessage: ''
        };
    },
    created() {
        this.fetchTags();
    },
    methods: {
        async fetchTags() {
            try {
                const response = await axios.get('/v1/tags');
                this.tags = response.data;
            } catch (error) {
                console.error('Error fetching tags:', error);
            }
        },
        addTag(newTag) {
            const tag = { name: newTag, id: newTag }; // Assuming the tag name is unique
            this.tags.push(tag);
            this.selectedTags.push(tag);
        },
        async createCampaign() {
            try {
                let contacts = [];
                if (this.recipientType === 'manual') {
                    contacts = this.contacts.split(',').map(contact => contact.trim());
                }
                const response = await axios.post('/v1/campaigns', {
                    type: this.type,
                    subject: this.type === 'email' ? this.subject : null,
                    message: this.message,
                    contacts: contacts,
                    recipientType: this.recipientType,
                    tagIds: this.recipientType !== 'manual' ? this.selectedTags.map(tag => tag.id) : null
                });
                // Handle success (e.g., show a success message, clear the form, etc.)
                this.resetForm();
                alert('Campaign created successfully!');
            } catch (error) {
                this.errorMessage = 'Failed to create campaign. Please try again.';
            }
        },
        resetForm() {
            this.type = 'email';
            this.subject = '';
            this.message = '';
            this.recipientType = 'students';
            this.contacts = '';
            this.selectedTags = [];
            this.errorMessage = '';
        }
    }
};
</script>

<style  >
 
.multiselect__tags , .multiselect__select{

    background-color: inherit !important;
}
</style>