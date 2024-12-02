<template>
    <div  >
        <div class="card">
            <div class="card-header">
                Transaction History
            </div>
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Type</th>
                            <th>Amount</th>
                            <th>Description</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="transaction in transactions" :key="transaction.id">
                            <td>{{ transaction.created_at }}</td>
                            <td>{{ transaction.type }}</td>
                            <td>${{ transaction.amount.toFixed(2) }}</td>
                            <td>{{ transaction.description }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>

<script>
import { ref, onMounted } from 'vue';
import axios from 'axios';

export default {
    setup() {
        const transactions = ref([]);

        const fetchTransactions = async () => {
            try {
                const response = await axios.get('/transactions');
                transactions.value = response.data;
            } catch (error) {
                console.error('Error fetching transactions:', error);
            }
        };

        onMounted(fetchTransactions);

        return {
            transactions,
        };
    },
};
</script>

<style scoped>
.container {
    max-width: 800px;
}
</style>