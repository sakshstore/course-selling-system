<template>
    <div>
        <h2>Profile</h2>
        <form @submit.prevent="updateProfile">
            <div class="mb-3">
                <label for="firstName" class="form-label">First Name</label>
                <input v-model="user.firstName" type="text" class="form-control" id="firstName" required>
            </div>
            <div class="mb-3">
                <label for="middleName" class="form-label">Middle Name</label>
                <input v-model="user.middleName" type="text" class="form-control" id="middleName">
            </div>
            <div class="mb-3">
                <label for="lastName" class="form-label">Last Name</label>
                <input v-model="user.lastName" type="text" class="form-control" id="lastName" required>
            </div>
            <div class="mb-3">
                <label for="dateOfBirth" class="form-label">Date of Birth</label>
                <input v-model="user.dateOfBirth" type="date" class="form-control" id="dateOfBirth" required>
            </div>
            <div class="mb-3">
                <label for="gender" class="form-label">Gender</label>
                <select v-model="user.gender" class="form-control" id="gender" required>
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                    <option value="Other">Other</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input v-model="user.email" type="email" class="form-control" id="email" required>
            </div>
            <div class="mb-3">
                <label for="phoneNumber" class="form-label">Phone Number</label>
                <input v-model="user.phoneNumber" type="text" class="form-control" id="phoneNumber" required>
            </div>
            <div class="mb-3">
                <label for="street" class="form-label">Street</label>
                <input v-model="user.street" type="text" class="form-control" id="street" required>
            </div>
            <div class="mb-3">
                <label for="city" class="form-label">City</label>
                <input v-model="user.city" type="text" class="form-control" id="city" required>
            </div>
            <div class="mb-3">
                <label for="state" class="form-label">State</label>
                <input v-model="user.state" type="text" class="form-control" id="state" required>
            </div>
            <div class="mb-3">
                <label for="postalCode" class="form-label">Postal Code</label>
                <input v-model="user.postalCode" type="text" class="form-control" id="postalCode" required>
            </div>
            <div class="mb-3">
                <label for="country" class="form-label">Country</label>
                <input v-model="user.country" type="text" class="form-control" id="country" required>
            </div>
            <div class="mb-3">
                <label for="profilePicture" class="form-label">Profile Picture</label>
                <input type="file" @change="handleFileUpload" id="profilePicture">
            </div>
            <div class="mb-3">
                <label for="preferredLanguage" class="form-label">Preferred Language</label>
                <select v-model="user.preferredLanguage" class="form-control" id="preferredLanguage" required>
                    <option value="English">English</option>
                    <option value="Hindi">Hindi</option>
                    <option value="Other">Other</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="specialAccommodations" class="form-label">Special Accommodations</label>
                <textarea v-model="user.specialAccommodations" class="form-control" id="specialAccommodations"
                    placeholder="Specify any special needs or accommodations"></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Update Profile</button>
        </form>
    </div>
</template>

<script>
import { ref, onMounted } from 'vue';


import apiService from '@/apiService';



export default {
    setup() {
        const user = ref({
            firstName: '',
            middleName: '',
            lastName: '',
            dateOfBirth: '',
            gender: '',
            email: '',
            phoneNumber: '',
            street: '',
            city: '',
            state: '',
            postalCode: '',
            country: '',
            profilePicture: '',
            preferredLanguage: '',
            specialAccommodations: ''
        });

        const fetchProfile = async () => {
            try {
                const response = await apiService.getProfile();
                user.value = response.data;
            } catch (error) {
                console.error('Error fetching profile:', error);
            }
        };

        const updateProfile = async () => {
            try {
                await apiService.updateProfile(user.value);
                this.$printtoast('Profile updated successfully!');
            } catch (error) {
                console.error('Error updating profile:', error);
            }
        };

        const handleFileUpload = (event) => {
            const file = event.target.files[0];
            user.value.profilePicture = file;
        };

        onMounted(() => {
            fetchProfile();
        });

        return {
            user,
            fetchProfile,
            updateProfile,
            handleFileUpload,
        };
    },
};
</script>