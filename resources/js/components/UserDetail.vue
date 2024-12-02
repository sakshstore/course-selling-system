<template>
    <div>
        <h1>User Management</h1>
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item" role="presentation">
                <a class="nav-link" :class="{ active: activeTab === 'details' }" @click="activeTab = 'details'"
                    role="tab">User Details</a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link" :class="{ active: activeTab === 'edit' }" @click="activeTab = 'edit'"
                    role="tab">Edit User</a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link" :class="{ active: activeTab === 'loginHistory' }"
                    @click="activeTab = 'loginHistory'" role="tab">Login History</a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link" :class="{ active: activeTab === 'leads' }" @click="activeTab = 'leads'"
                    role="tab">Leads</a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link" :class="{ active: activeTab === 'contacts' }" @click="activeTab = 'contacts'"
                    role="tab">Contacts</a>
            </li>
        </ul>

        <div class="tab-content mt-3">{{ activeTab }}
            <div v-if="isLoading">Loading user details...</div>
            <div v-else>
                <div v-if="errorMessage">{{ errorMessage }}</div>
                <div v-else>
                    <div v-if="activeTab === 'details'" class="tab-pane fade show active" role="tabpanel">
                        <h2>{{ user.name }}</h2>
                        <p><strong>Email:</strong> {{ user.email }}</p>
                        <p><strong>Status:</strong> {{ user.is_suspended ? 'Suspended' : 'Active' }}</p>
                        <p><strong>Created At:</strong> {{ new Date(user.created_at).toLocaleString() }}</p>
                        <p><strong>Updated At:</strong> {{ new Date(user.updated_at).toLocaleString() }}</p>
                        <h2>Leadsss</h2>
                        <button @click="fetchLeads" class="btn btn-primary mb-3">Fetch Leads</button>
                        <ul>
                            <li v-for="lead in leads" :key="lead.id">{{ lead.name }} - {{ lead.email }}</li>
                        </ul>

                        <h2>Contactssss</h2>
                        <button @click="fetchContacts" class="btn btn-primary mb-3">Fetch Contacts</button>
                        <ul>
                            <li v-for="contact in contacts" :key="contact.id">{{ contact.name }} - {{ contact.email }}
                            </li>
                        </ul>




                    </div>

                    <div v-else-if="activeTab === 'edit'" class="tab-pane fade" role="tabpanel">
                        <h2>Edit User</h2>
                        <form @submit.prevent="updateUser">
                            <div class="mb-3">
                                <label for="name" class="form-label">Name:</label>
                                <input type="text" v-model="user.name" id="name" class="form-control" required />
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email:</label>
                                <input type="email" v-model="user.email" id="email" class="form-control" required />
                            </div>
                            <div class="mb-3">
                                <label for="status" class="form-label">Status:</label>
                                <select v-model="user.is_suspended" id="status" class="form-select">
                                    <option :value="false">Active</option>
                                    <option :value="true">Suspended</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary">Save Changes</button>
                        </form>
                    </div>

                    <div v-else-if="activeTab === 'loginHistory'" class="tab-pane fade" role="tabpanel">
                        <h2>Login History</h2>
                        <p>Login history will be displayed here.</p>
                    </div>

                    <div v-else-if="activeTab === 'leads'" class="tab-pane fade" role="tabpanel">
                        <h2>Leadsss</h2>
                        <button @click="fetchLeads" class="btn btn-primary mb-3">Fetch Leads</button>
                        <ul>
                            <li v-for="lead in leads" :key="lead.id">{{ lead.name }} - {{ lead.email }}</li>
                        </ul>
                    </div>

                    <div v-else-if="activeTab === 'contacts'" class="tab-pane fade" role="tabpanel">
                        <h2>Contactssss</h2>
                        <button @click="fetchContacts" class="btn btn-primary mb-3">Fetch Contacts</button>
                        <ul>
                            <li v-for="contact in contacts" :key="contact.id">{{ contact.name }} - {{ contact.email }}
                            </li>
                        </ul>
                    </div>

                    <div v-else>
                        <p>Loading user details...</p>
                    </div>
                </div>
            </div>
        </div>

        <button @click="goBack" class="btn btn-secondary mt-3">Back</button>
    </div>
</template>

<script>
import axios from 'axios';
import { ref, onMounted } from 'vue';
import { useRoute, useRouter } from 'vue-router';

export default {
    setup() {
        const user = ref({});
        const leads = ref([]);
        const contacts = ref([]);
        const activeTab = ref('details'); // Default active tab
        const route = useRoute();
        const router = useRouter();
        const isLoading = ref(true);
        const errorMessage = ref('');

        const fetchUserDetails = async () => {
            try {
                const response = await axios.get(`/v1/users/${route.params.id}`);
                user.value = response.data;
                console.log('User details:', user.value); // Debug log
            } catch (error) {
                console.error('Error fetching user details:', error);
                errorMessage.value = 'Failed to load user details.';
            } finally {
                isLoading.value = false;
            }
        };

        const fetchLeads = async () => {
            try {
                const response = await axios.get(`/v1/user/${route.params.id}/leads`);
                leads.value = response.data;
                console.log('Leads:', leads.value); // Debug log
            } catch (error) {
                console.error('Error fetching leads:', error);
                errorMessage.value = 'Failed to load leads.';
            }
        };

        const fetchContacts = async () => {
            try {
                const response = await axios.get(`/v1/user/${route.params.id}/contacts`);
                contacts.value = response.data;
                console.log('Contacts:', contacts.value); // Debug log
            } catch (error) {
                console.error('Error fetching contacts:', error);
                errorMessage.value = 'Failed to load contacts.';
            }
        };

        const updateUser = async () => {
            try {
                await axios.put(`/v1/users/${route.params.id}`, user.value);
                alert('User updated successfully!');
            } catch (error) {
                console.error('Error updating user:', error);
                errorMessage.value = 'Failed to update user.';
            }
        };

        const goBack = () => {
            router.go(-1); // Go back to the previous page
        };

        onMounted(() => {
            fetchUserDetails();
        });

        return { user, leads, contacts, activeTab, goBack, updateUser, fetchLeads, fetchContacts, isLoading, errorMessage };
    }
};
</script>

 