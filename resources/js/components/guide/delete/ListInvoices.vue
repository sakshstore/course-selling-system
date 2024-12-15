<template>
    <div class="container mt-5">
        <h2 class="mb-4">Invoices</h2>
        <button class="btn btn-primary mb-3" @click="goToCreateInvoice">Create Invoice</button>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Invoice Number</th>
                    <th>Order Number</th>
                    <th>Customer</th>
                    <th>Status</th>
                    <th>Due Date</th>
                    <th>Amount</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="invoice in invoices" :key="invoice.id">
                    <td @click="viewInvoice(invoice.id)">{{ invoice.invoice_date }}</td>
                    <td @click="viewInvoice(invoice.id)">{{ invoice.invoice_number }}</td>
                    <td @click="viewInvoice(invoice.id)">{{ invoice.invoice_number }}</td>
                    <td @click="viewInvoice(invoice.id)">{{ invoice.contact.name }}</td>
                    <td @click="viewInvoice(invoice.id)">{{ invoice.status }}</td>
                    <td @click="viewInvoice(invoice.id)">{{ invoice.due_date }}</td>
                    <td @click="viewInvoice(invoice.id)">{{ invoice.amount }}</td>
                    <td>
                        <button class="btn btn-warning btn-sm" @click="editInvoice(invoice.id)">Edit</button>
                        <button class="btn btn-danger btn-sm" @click="deleteInvoice(invoice.id)">Delete</button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
import apiService from '@/apiService.js';

export default {
    data() {
        return {
            invoices: []
        };
    },
    created() {
        this.fetchInvoices();
    },
    methods: {
        async fetchInvoices() {
            try {
                const response = await apiService.getInvoices();
                this.invoices = response.data;
            } catch (error) {
                console.error('Error fetching invoices:', error);
            }
        },
        goToCreateInvoice() {
            this.$router.push('/guide/invoices/create');
        },
        viewInvoice(id) {
            this.$router.push(`/guide/invoices/${id}`);
        },
        editInvoice(id) {
            this.$router.push(`/guide/invoices/${id}/edit`);
        },
        async deleteInvoice(id) {
            if (confirm('Are you sure you want to delete this invoice?')) {
                try {
                    await apiService.deleteInvoice(id);
                    this.fetchInvoices();
                } catch (error) {
                    console.error('Error deleting invoice:', error);
                }
            }
        }
    }
};
</script>