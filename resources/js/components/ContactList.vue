<template>
    <div>

        <div class="    mb-3">
            <h2 class="mb-4">Contacts</h2>
            <button class="btn btn-info btn-sm me-3" @click="openCreateModal">Add Contact</button>



            <router-link :to="{ name: 'ContactImport' }" class="btn btn-info btn-sm me-3">
                <i class="fas fa-file-import"></i>Import
            </router-link>
            <router-link :to="{ name: 'ContactExport' }" class="btn btn-info btn-sm me-3">
                <i class="fas fa-file-export"></i>Export
            </router-link>


        </div>
        <ul class="list-group">
            <li v-for="contact in contacts" :key="contact.id"
                class="list-group-item d-flex justify-content-between align-items-center">
                <div>
                    <strong>{{ contact.name }}</strong> - {{ contact.email }} - {{ contact.phone }}
                    <div>
                        <span v-for="tag in contact.tags" :key="tag.id" class="badge bg-secondary me-1">{{ tag.name
                            }}</span>
                    </div>
                    <div>
                        <small v-for="note in contact.notes" :key="note.id" class="d-block">{{ note.content }}</small>
                    </div>
                </div>
                <div>
                    <button @click="editContact(contact)" class="btn btn-sm btn-warning me-2">Edit</button>
                    <button @click="deleteContact(contact.id)" class="btn btn-sm btn-danger">Delete</button>
                </div>
            </li>
        </ul>

        <!-- Create/Edit Contact Modal -->
        <div v-if="showCreateContactModal" class="modal fade show d-block" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">{{ modalTitle }}</h5>
                        <button type="button" class="btn-close" @click="closeModal"></button>
                    </div>
                    <div class="modal-body">
                        <ContactForm :contactId="selectedContactId" @saved="handleSaved" />
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios';
import ContactForm from './ContactForm.vue';

export default {
    components: { ContactForm },
    data() {
        return {
            contacts: [],
            showCreateContactModal: false,
            selectedContactId: null,
            modalTitle: 'Add Contact'
        };
    },
    methods: {
        async fetchContacts() {
            const response = await axios.get('/v1/contacts_list');
            this.contacts = response.data;
        },
        editContact(contact) {
            this.selectedContactId = contact.id;
            this.modalTitle = 'Edit Contact';
            this.showCreateContactModal = true;
        },
        async deleteContact(id) {
            await axios.delete(`/v1/contacts/${id}`);
            this.fetchContacts();
        },

        openCreateModal() {
            this.selectedContactId = null;
            this.modalTitle = 'Add Contact';
            this.showCreateContactModal = true;
        },
        closeModal() {
            this.showCreateContactModal = false;
        },
        handleSaved() {
            this.fetchContacts();
            this.closeModal();
        }
    },
    mounted() {
        this.fetchContacts();
    },
};
</script>