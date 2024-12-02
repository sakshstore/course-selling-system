Got it! I'll remove the button and directly display the referral link. Here's the updated code:

<template>
<div class="mt-5">
<!-- Referral Link and Earnings -->
<div class="card mb-4">
<div class="card-header">
Your Referral Link
</div>
<div class="card-body">
<div v-if="referralLink" class="mt-3">
<p>Share this link: <strong>{{ referralLink }}</strong></p>
</div>
<div class="mt-3">
<h5>Total Referral Income: {{ currencySymbol }}{{ totalIncome.toFixed(2) }}</h5>
</div>
</div>
</div>

<!-- Request Withdrawal Button -->
<div class="mb-4">
<button class="btn btn-success" @click="showWithdrawalModal = true">Request Withdrawal</button>
</div>

<!-- Tabs for Reports -->
<div>
<ul class="nav nav-tabs">
<li class="nav-item">
<a class="nav-link" :class="{ active: activeTab === 'referrals' }" @click="activeTab = 'referrals'">Referral Report</a>
</li>
<li class="nav-item">
<a class="nav-link" :class="{ active: activeTab === 'transactions' }" @click="activeTab = 'transactions'">Transaction History</a>
</li>
<li class="nav-item">
<a class="nav-link" :class="{ active: activeTab === 'withdrawals' }" @click="activeTab = 'withdrawals'">Withdrawal Report</a>
</li>
</ul>
<div class="tab-content mt-3">
<div v-if="activeTab === 'referrals'" class="tab-pane active">
<h5>Total Referrals: {{ referrals.length }}</h5>
<table class="table" v-if="referrals.length">
<thead>
<tr>
<th>Name</th>
<th>Email</th>
<th>Income</th>
</tr>
</thead>
<tbody>
<tr v-for="referral in referrals" :key="referral.id">
<td>{{ referral.name }}</td>
<td>{{ referral.email }}</td>
<td>{{ currencySymbol }}{{ referral.referral_income.toFixed(2) }}</td>
</tr>
</tbody>
</table>
<p v-else>You have no referrals yet.</p>
</div>
<div v-if="activeTab === 'transactions'" class="tab-pane active">
<table class="table"  v-if="transactions.length">
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
<td>{{ currencySymbol }}{{ transaction.amount.toFixed(2) }}</td>
<td>{{ transaction.description }}</td>
</tr>
</tbody>
</table><p v-else>You have no data yet.</p>
</div>
<div v-if="activeTab === 'withdrawals'" class="tab-pane active">
<table class="table"   v-if="withdrawals.length">
<thead>
<tr>
<th>Date</th>
<th>Amount</th>
<th>Status</th>
</tr>
</thead>
<tbody>
<tr v-for="withdrawal in withdrawals" :key="withdrawal.id">
<td>{{ withdrawal.created_at }}</td>
<td>{{ currencySymbol }}{{ withdrawal.amount.toFixed(2) }}</td>
<td>{{ withdrawal.status }}</td>
</tr>
</tbody>
</table><p v-else>You have no data yet.</p>
</div>
</div>
</div>

<!-- Withdrawal Modal -->
<div v-if="showWithdrawalModal" class="modal" tabindex="-1" role="dialog" style="display: block;">
<div class="modal-dialog" role="document">
<div class="modal-content">
<div class="modal-header">
<h5 class="modal-title">Request Withdrawal</h5>
<button type="button" class="close" @click="showWithdrawalModal = false" aria-label="Close">
<span aria-hidden="true">×</span>
</button>
</div>
<div class="modal-body">
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
<div class="modal-footer">
<button type="button" class="btn btn-secondary" @click="showWithdrawalModal = false">Close</button>
</div>
</div>
</div>
</div>
</div>
</template>

<script>
import { ref, onMounted } from 'vue';
import axios from 'axios';

export default {
setup() {
const referralLink = ref(null);
const amount = ref('');
const message = ref('');
const error = ref('');
const transactions = ref([]);
const referrals = ref([]);
const withdrawals = ref([]);
const totalIncome = ref(0);
const activeTab = ref('referrals');
const showWithdrawalModal = ref(false);
const currencySymbol = ref('$'); // Default symbol

const fetchCurrencySymbol = async () => {
try {
const response = await axios.get('/api/settings/currency-symbol');
currencySymbol.value = response.data.value;
} catch (error) {
console.error('Error fetching currency symbol:', error);
}
};

const fetchReferralLink = async () => {
try {
const response = await axios.post('/v1/generate-referral-code');
referralLink.value = response.data.referral_link;
} catch (error) {
console.error('Error fetching referral link:', error);
}
};

const submitRequest = async () => {
try {
const response = await axios.post('/v1/request-withdrawal', { amount: amount.value });
message.value = response.data.message;
error.value = '';
showWithdrawalModal.value = false;
} catch (err) {
error.value = err.response.data.error;
message.value = '';
}
};

const fetchTransactions = async () => {
try {
const response = await axios.get('/v1/transactions');
transactions.value = response.data;
} catch (error) {
console.error('Error fetching transactions:', error);
}
};

const fetchReferralReport = async () => {
try {
const response = await axios.get('/v1/referral-report');
referrals.value = response.data.referrals;
totalIncome.value = response.data.totalIncome;
} catch (error) {
console.error('Error fetching referral report:', error);
}
};

const fetchWithdrawals = async () => {
try {
const response = await axios.get('/v1/withdrawals');
withdrawals.value = response.data;
} catch (error) {
console.error('Error fetching withdrawals:', error);
}
};

onMounted(() => {
fetchCurrencySymbol();
fetchReferralLink();
fetchTransactions();
fetchReferralReport();
fetchWithdrawals();
});

return {
referralLink,
amount,
message,
error,
transactions,
referrals,
withdrawals,
totalIncome,
activeTab,
showWithdrawalModal,
currencySymbol,
fetchReferralLink,
submitRequest,
};
},
};
</script>
 