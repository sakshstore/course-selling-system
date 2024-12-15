<template>
    <div>
        <form @submit.prevent="saveContact">
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input v-model="contact.name" type="text" class="form-control" id="name" placeholder="Name" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input v-model="contact.email" type="email" class="form-control" id="email" placeholder="Email"
                    required>
            </div>
            <div class="mb-3">
                <label for="phone" class="form-label">Phone</label>
                <input v-model="contact.phone" type="text" class="form-control" id="phone" placeholder="Phone" required>
            </div>
            <div class="mb-3">
                <label for="tags" class="form-label">Tags</label>
                <input v-model="tags" type="text" class="form-control" id="tags" placeholder="Tags (comma separated)">
            </div>
            <div class="mb-3">
                <label for="notes" class="form-label">Notes</label>
                <textarea v-model="notes" class="form-control" id="notes" placeholder="Notes"></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Save</button>
        </form>
    </div>
</template>

<script>
import apiService from '@/apiService';

export default {
    props: ['contactId'],
    data() {
        return {
            contact: {
                name: '',
                email: '',
                phone: '',
            },
            tags: '',
            notes: '',
        };
    },
    methods: {
        async saveContact() {
            const contactData = {
                ...this.contact,
                tags: this.tags.split(',').map(tag => tag.trim()),
                notes: this.notes,
            };

            try {
                await apiService.saveContact(this.contactId, contactData);
                this.$emit('saved');
                this.resetForm();
            } catch (error) {
                console.error('Error saving contact:', error);
            }
        },
        async fetchContact() {
            if (this.contactId) {
                try {
                    const response = await apiService.fetchContact(this.contactId);
                    this.contact = response.data;
                    this.tags = response.data.tags.map(tag => tag.name).join(', ');
                    this.notes = response.data.notes.map(note => note.content).join('\n');
                } catch (error) {
                    console.error('Error fetching contact:', error);
                }
            }
        },
        resetForm() {
            this.contact = {
                name: '',
                email: '',
                phone: '',
            };
            this.tags = '';
            this.notes = '';
        }
    },
    mounted() {
        this.fetchContact();
    },
    watch: {
        contactId(newId, oldId) {
            if (newId !== oldId) {
                this.fetchContact();
            }
        }
    }
};
</script>