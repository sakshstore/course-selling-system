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
            <div class="mb-3">
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
import { ref, onMounted } from 'vue';
import { useRouter } from 'vue-router';
import apiService from '@/apiservice';
import Multiselect from 'vue-multiselect';
import { useToast } from 'vue-toastification';

export default {
    components: { Multiselect },
    setup() {
        const type = ref('email');
        const subject = ref('');
        const message = ref('');
        const recipientType = ref('students');
        const contacts = ref('');
        const selectedTags = ref([]);
        const tags = ref([]);
        const errorMessage = ref('');
        const toast = useToast();
        const router = useRouter();

        const fetchTags = async () => {
            try {
                const response = await apiService.getTags();
                tags.value = response.data;
            } catch (error) {
                console.error('Error fetching tags:', error);
                errorMessage.value = 'Failed to load tags. Please try again.';
            }
        };

        const addTag = (newTag) => {
            const tag = { name: newTag, id: newTag }; // Assuming the tag name is unique
            tags.value.push(tag);
            selectedTags.value.push(tag);
        };

        const createCampaign = async () => {
            try {
                let contactsArray = [];
                if (recipientType.value === 'manual') {
                    contactsArray = contacts.value.split(',').map(contact => contact.trim());
                }
                const campaignData = {
                    type: type.value,
                    subject: subject.value,
                    message: message.value,
                    contacts: contactsArray,
                    recipientType: recipientType.value,
                    tagIds: recipientType.value !== 'manual' ? selectedTags.value.map(tag => tag.id) : null
                };
                await apiService.createCampaign(campaignData);
                resetForm();
                toast.success('Campaign created successfully!');
                router.push({ name: 'ListCampaigns' });
            } catch (error) {
                console.error('Error creating campaign:', error);
                errorMessage.value = 'Failed to create campaign. Please try again.';
                toast.error('Failed to create campaign. Please try again.');
            }
        };

        const resetForm = () => {
            type.value = 'email';
            subject.value = '';
            message.value = '';
            recipientType.value = 'students';
            contacts.value = '';
            selectedTags.value = [];
            errorMessage.value = '';
        };

        onMounted(() => {
            fetchTags();
        });

        return {
            type,
            subject,
            message,
            recipientType,
            contacts,
            selectedTags,
            tags,
            errorMessage,
            fetchTags,
            addTag,
            createCampaign,
            resetForm
        };
    }
};
</script>

<style>
.multiselect__tags,
.multiselect__select {
    background-color: inherit !important;
}
</style>