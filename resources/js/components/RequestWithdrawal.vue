<template>
    <div>
        <div class="card">
            <div class="card-header">
                Request Withdrawal
            </div>
            <div class="card-body">
                <form @submit.prevent="submitRequest">
                    <div class="form-group">
                        <label for="amount">Amount</label>
                        <input type="number" class="form-control" id="amount" v-model="amount" required>
                    </div>
                    <button type="submit" class="btn btn-primary mt-3">Submit</button>
                </form>
                <div v-if="message" class="alert alert-success mt-3">{{ message }}</div>
                <div v-if="error" class="alert alert-danger mt-3">{{ error }}</div>
            </div>
        </div>
    </div>
</template>

<script>
import { ref } from 'vue';
import axios from 'axios';

export default {
    setup() {
        const amount = ref('');
        const message = ref('');
        const error = ref('');

        const submitRequest = async () => {
            try {
                const response = await axios.post('/request-withdrawal', { amount: amount.value });
                message.value = response.data.message;
                error.value = '';
            } catch (err) {
                error.value = err.response.data.error;
                message.value = '';
            }
        };

        return {
            amount,
            message,
            error,
            submitRequest,
        };
    },
};
</script>

 