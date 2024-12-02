<template>
    <div class=" ">
        <form @submit.prevent="verifyOtp" class="mt-4">
            <div class="mb-3">
                <label for="otp" class="form-label">OTP</label>
                <input v-model="otp" type="text" class="form-control" id="otp" placeholder="OTP" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Login</button>
            <div v-if="errorMessage" class="text-danger mt-2">{{ errorMessage }}</div>
        </form>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    data() {
        return {
            otp: '',
            errorMessage: '',
        };
    },
    computed: {
        email() {
            return this.$route.params.email;
        }
    },
    methods: {
        async verifyOtp() {
            this.errorMessage = ''; // Reset error message
            try {
                await axios.post('/v1/guest/verify-otp', { email: this.email, otp: this.otp });
                localStorage.setItem('auth', 'true'); // Store as string

                localStorage.setItem('role', 'guest'); // Store as string
                this.$router.push({ name: 'GuestDashboard'} );

               
            } catch (error) {
                console.error('OTP verification failed:', error);
                this.errorMessage = 'Invalid OTP. Please try again.'; // Set error message
            }
        },
    },
};
</script>
