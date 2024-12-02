<template>


    <div class="container-fluid">
        <section class="row justify-content-center align-items-center min-vh-100">
            <!-- Background Image and Header Text -->
            <div class="col-md-6 text-white text-center d-flex flex-column justify-content-center"
                :style="{ height: '100vh', backgroundImage: `url(${guide})`, backgroundSize: 'cover' }">
                <h2 class="mb-4">Welcome Back!!</h2>
                <p class="px-5">Guide login...</p>
            </div>

            <!-- Description Text and Support Contact Details -->
            <div class="col-md-6 d-flex flex-column justify-content-center">






                <div>
                    <form v-if="!otpSent" @submit.prevent="sendOtp" class="mt-4">
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input v-model="email" type="email" class="form-control" id="email" placeholder="Email"
                                required>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Send OTP to email</button>
                    </form>

                    <form v-else @submit.prevent="verifyOtp" class="mt-4">
                        <div class="mb-3">
                            <label for="otp" class="form-label">OTP</label>
                            <input v-model="otp" type="text" class="form-control" id="otp" placeholder="OTP" required>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Login</button>
                        <div v-if="errorMessage" class="text-danger mt-2">{{ errorMessage }}</div>
                    </form>
                </div>

                <div class="text-center mt-4">
                    <p>If you need support, contact us at <a href="mailto:support@system.com">support@system.com</a></p>
                </div>
            </div>
        </section>

        <!-- Footer with Copyright -->
        <footer class="text-center py-3">
            <p>© 2024 system. All rights reserved.</p>
        </footer>
    </div>

</template>

<script>
import axios from 'axios';
import guide from '@/assets/images/guide.jpg';
export default {
    data() {
        return {
            email: '',
            otp: '',
            otpSent: false,
            errorMessage: '',
            guide,
        };
    },
    methods: {
        async sendOtp() {
            try {
                await axios.post('/v1/send-otp', { email: this.email });
                this.otpSent = true;
            } catch (error) {
                console.error('Failed to send OTP:', error);
                alert('Failed to send OTP. Please try again.');
            }
        },
        async verifyOtp() {
            this.errorMessage = ''; // Reset error message
            try {
                const response = await axios.post('/v1/verify-otp', { email: this.email, otp: this.otp });
                localStorage.setItem('auth', 'true'); // Store as string


                localStorage.setItem('roles', JSON.stringify(response.data.role)); // Store roles array 


                this.$router.push('/guide/dashboard');
            } catch (error) {
                console.error('OTP verification failed:', error);
                this.errorMessage = 'Invalid OTP. Please try again.'; // Set error message
            }
        },
    },
};
</script>