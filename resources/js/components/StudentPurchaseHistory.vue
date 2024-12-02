
<template>
    <div v-if="purchaseHistory.length" class="mt-3">
    <h4>Purchase History</h4>
    <ul class="list-group">
    <li v-for="purchase in purchaseHistory" :key="purchase.id" class="list-group-item">
    {{ purchase.item_name }} - {{ purchase.amount }} - {{ formatTimeAgo(purchase.created_at) }}
    </li>
    </ul>
    </div>
    </template>
    
    <script>
    import axios from 'axios';
    import { formatDistanceToNow } from 'date-fns';
    
    export default {
    data() {
    return {
    purchaseHistory: [],
    };
    },
    props: {
    studentId: {
    type: String,
    required: true,
    },
    },
    created() {
    this.fetchPurchaseHistory();
    },
    methods: {
    fetchPurchaseHistory() {
    axios.get(`/v1/students/${this.studentId}/purchase-history`)
    .then(response => {
    this.purchaseHistory = response.data;
    })
    .catch(error => {
    console.error('Error fetching purchase history:', error);
    });
    },
    formatTimeAgo(date) {
    return formatDistanceToNow(new Date(date), { addSuffix: true });
    },
    },
    };
    </script>
    