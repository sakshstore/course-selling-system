<template>
    <div class="container-fluid">
    <section class="row justify-content-center align-items-center min-vh-100">
    <!-- Background Image and Header Text -->
    <div class="col-md-6 text-white text-center d-flex flex-column justify-content-center"
    :style="{ height: '100vh', backgroundImage: `url(${guide})`, backgroundSize: 'cover' }">
    <h2 class="mb-4">Welcome Back!!</h2>
    <p class="px-5">{{ settings.welcomeText }}</p>
    </div>
    
    <!-- Description Text and Support Contact Details -->
    <div class="col-md-6 d-flex flex-column justify-content-center">
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
    <button type="button" @click="resendOtp" class="btn btn-secondary w-100 mt-2">Resend OTP</button>
    <div v-if="errorMessage" class="text-danger mt-2">{{ errorMessage }}</div>
    </form>
    
    <div class="text-center mt-1">
    <p>{{ settings.supportText }}</p>
    </div>
    </div>
    </section>
    </div>
    </template>
    
    <script setup>
    import { ref, onMounted } from 'vue';
    import { useRouter } from 'vue-router';
    import axios from 'axios';
    import guide from '@/assets/images/guide.jpg';
    
    const email = ref('');
    const otp = ref('');
    const otpSent = ref(false);
    const errorMessage = ref('');
    const settings = ref({
    welcomeText: '',
    supportText: '',
    });
    
    const fetchSettings = async () => {
    try {
    const response = await axios.get('/v1/settings/brand-settings');
    settings.value = response.data;
    } catch (error) {
    console.error('Error fetching settings:', error);
    }
    };
    
    onMounted(() => {
    fetchSettings();
    });
    
    const sendOtp = async () => {
    try {
    await axios.post('/v1/admin-send-otp', { email: email.value });
    otpSent.value = true;
    } catch (error) {
    console.error('Failed to send OTP:', error);
    this.$printtoast('Failed to send OTP. Please try again.');
    }
    };
    
    const router = useRouter();
    
    const verifyOtp = async () => {
    errorMessage.value = ''; // Reset error message
    try {
    const response = await axios.post('/v1/admin-verify-otp', { email: email.value, otp: otp.value });
    localStorage.setItem('auth', 'true'); // Store as string
    localStorage.setItem('roles', JSON.stringify(response.data.role)); // Store roles array
    router.push('/admin/users');
    } catch (error) {
    console.error('OTP verification failed:', error);
    errorMessage.value = 'Invalid OTP. Please try again.'; // Set error message
    }
    };
    
    const resendOtp = async () => {
    try {
    await axios.post('/v1/admin-send-otp', { email: email.value });
    this.$printtoast('OTP resent successfully.');
    } catch (error) {
    console.error('Failed to resend OTP:', error);
    this.$printtoast('Failed to resend OTP. Please try again.');
    }
    };
    </script>