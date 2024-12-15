<template>
    <div class=" ">
        <form @submit.prevent="login" class="mt-4">
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input v-model="email" type="email" class="form-control" id="email" placeholder="Email" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input v-model="password" type="password" class="form-control" id="password" placeholder="Password"
                    required>
            </div>
            <button type="submit" class="btn btn-primary">Login</button>
        </form>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    data() {
        return {
            email: '',
            password: '',
        };
    },
    methods: {

        async login() {
            try {
                await axios.post('/v1/login', {
                    email: this.email,
                    password: this.password,
                });
                localStorage.setItem('auth', true);
                this.$router.push('/auth/dashboard');
            } catch (error) {
                console.error('Login failed:', error);
                this.$printtoast('Login failed. Please check your credentials and try again.');
            }
        }



    },
};
</script>