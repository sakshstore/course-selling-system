<template>
    <div>
        <h2 class="mb-4">Documents</h2>
        <button @click="showModal = true" class="btn btn-primary mb-3">Create Document</button>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Title</th>
                    <th scope="col">Contents</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="document in documents" :key="document.id">
                    <th scope="row">{{ document.id }}</th>
                    <td>{{ document.title }}</td>
                    <td>{{ document.contents }}</td>
                    <td>
                        <button @click="deleteDocument(document.id)" class="btn btn-danger btn-sm">Delete</button>
                    </td>
                </tr>
            </tbody>
        </table>

        <!-- Modal -->
        <div v-if="showModal" class="modal fade show" style="display: block;" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Create Document</h5>
                        <button type="button" class="btn-close" @click="showModal = false"></button>
                    </div>
                    <div class="modal-body">
                        <form @submit.prevent="createDocument">
                            <div class="mb-3">
                                <label for="title" class="form-label">Title</label>
                                <input v-model="title" type="text" class="form-control" id="title" placeholder="Title"
                                    required />
                            </div>
                            <div class="mb-3">
                                <label for="contents" class="form-label">Contents</label>
                                <textarea v-model="contents" class="form-control" id="contents" rows="3"
                                    placeholder="Contents" required></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">Create Document</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div v-if="showModal" class="modal-backdrop fade show"></div>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    data() {
        return {
            documents: [],
            showModal: false,
            title: '',
            contents: ''
        };
    },
    created() {
        this.fetchDocuments();
    },
    methods: {
        fetchDocuments() {
            axios.get('/v1/documents').then(response => {
                this.documents = response.data;
            }).catch(error => {
                console.error(error);
            });
        },

        deleteDocument(id) {
            axios.delete(`/v1/documents/${id}`).then(() => {
                this.fetchDocuments();
            }).catch(error => {
                console.error(error);
            });
        },
        createDocument() {
            axios.post('/v1/documents', {
                title: this.title,
                contents: this.contents
            }).then(response => {
                this.documents.push(response.data);
                this.showModal = false;
                this.title = '';
                this.contents = '';
            }).catch(error => {
                console.error(error);
            });
        }
    }
};
</script>