<template>
    <div class="mt-3">
        <h4>Purchase History</h4>
        <div v-if="purchaseHistory.length">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">Item Name</th>
                        <th scope="col">Amount</th>
                        <th scope="col">Time</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="purchase in purchaseHistory" :key="purchase.id">
                        <td>{{ purchase.item_name }}</td>
                        <td>{{ purchase.amount }}</td>
                        <td>{{ $formatTimeAgo(purchase.created_at) }}</td>




                    </tr>
                </tbody>
            </table>
        </div>
        <div v-else>
            <p>No data available</p>
        </div>
    </div>
</template>

<script>
import { ref, onMounted } from 'vue';
import { formatDistanceToNow } from 'date-fns';
import apiService from '@/apiService';

export default {
    props: {
        studentId: {
            type: String,
            required: true,
        },
    },
    setup(props) {
        const purchaseHistory = ref([]);

        const fetchPurchaseHistory = () => {
            apiService.getPurchaseHistory(props.studentId)
                .then(response => {
                    purchaseHistory.value = response.data;
                })
                .catch(error => {
                    console.error('Error fetching purchase history:', error);
                });
        };


        onMounted(fetchPurchaseHistory);

        return {
            purchaseHistory

        };
    },
};
</script>