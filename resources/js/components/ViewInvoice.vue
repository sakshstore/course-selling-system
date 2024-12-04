<template>
    <div v-if="invoice">
        <div class="row">
            <div class="col-md-6">
                <img :src="companyDetails.logo" alt="Company Logo" class="img-fluid mb-3" /><br>
                <strong>{{ companyDetails.name }}</strong><br>
                <address>
                    {{ companyDetails.address }}
                </address>
            </div>
            <div class="col-md-6 text-right">
                <h4 class="mb-3">TAX INVOICE</h4>
                <p><strong>Invoice# {{ invoice.invoice_number }}</strong></p>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-md-6">
                <h5>Bill To</h5>
                <address>
                    <strong>{{ invoice.contact.name }}</strong><br>
                    {{ invoice.contact.billing_address_line1 }}<br>
                    {{ invoice.contact.billing_address_line2 }}<br>
                    {{ invoice.contact.billing_city }}, {{ invoice.contact.billing_state }}<br>
                    {{ invoice.contact.billing_country }} - {{ invoice.contact.billing_pin_code }}
                </address>
            </div>
            <div class="col-md-6">
                <h5>Ship To</h5>
                <address>
                    {{ invoice.contact.shipping_address_line1 }}<br>
                    {{ invoice.contact.shipping_address_line2 }}<br>
                    {{ invoice.contact.shipping_city }}, {{ invoice.contact.shipping_state }}<br>
                    {{ invoice.contact.shipping_country }} - {{ invoice.contact.shipping_pin_code }}
                </address>
            </div>
        </div>

        <table class="table table-bordered mt-4">
            <thead>
                <tr>
                    <th>Invoice Date</th>
                    <th>Terms</th>
                    <th>Due Date</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{ invoice.invoice_date }}</td>
                    <td>{{ invoice.terms }}</td>
                    <td>{{ invoice.due_date }}</td>
                </tr>
            </tbody>
        </table>

        <table class="table table-striped mt-4">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Item & Description</th>
                    <th class="text-right">Qty</th>
                    <th class="text-right">Rate</th>
                    <th class="text-right">Amount</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(product, index) in invoice.products" :key="product.id">
                    <td>{{ index + 1 }}</td>
                    <td>
                        <div>{{ product.name }}</div>
                        <div>{{ product.pivot.description }}</div>
                    </td>
                    <td class="text-right">{{ product.pivot.quantity }}</td>
                    <td class="text-right">{{ product.price }}</td>
                    <td class="text-right">{{ (product.price * product.pivot.quantity).toFixed(2) }}</td>
                </tr>
            </tbody>
        </table>

        <div class="row mt-4">
            <div class="col-md-6">
                <p><strong>Total In Words:</strong> <i>{{ totalInWords }}</i></p>
            </div>
            <div class="col-md-6 text-right">
                <table class="table">
                    <tbody>
                        <tr>
                            <td class="text-right"><strong>Sub Total</strong></td>
                            <td class="text-right">{{ subtotal }}</td>
                        </tr>
                        <tr>
                            <td class="text-right"><strong>Total</strong></td>
                            <td class="text-right"><strong>₹{{ total }}</strong></td>
                        </tr>
                        <tr>
                            <td class="text-right"><strong>Balance Due</strong></td>
                            <td class="text-right"><strong>₹{{ total }}</strong></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="mt-5">
            <h5>Notes</h5>
            <p>{{ invoice.customer_note }}</p>
        </div>

        <div class="mt-5">
            <h5>Terms and Conditions</h5>
            <p>{{ invoice.terms }}</p>
        </div>

        <div class="mt-5" v-if="invoice.file_path">
            <h5>Attached File</h5>
            <a :href="`/storage/${invoice.file_path}`" target="_blank">Download File</a>
        </div>
    </div>
</template>

<script>
import apiService from '@/apiservice';
import { toWords } from 'number-to-words';

export default {
    data() {
        return {
            invoice: null,
            companyDetails: {}
        };
    },
    created() {
        this.fetchInvoice();
    },
    methods: {
        fetchInvoice() {
            const id = this.$route.params.id;
            apiService.getInvoice(id).then(response => {
                this.invoice = response.data.invoice;
                this.companyDetails = response.data.companyDetails;
            }).catch(error => {
                console.error(error);
            });
        }
    },
    computed: {
        subtotal() {
            return this.invoice.products.reduce((sum, product) => {
                return sum + (product.price * product.pivot.quantity);
            }, 0).toFixed(2);
        },
        total() {
            const tax = this.invoice.tax ? parseFloat(this.invoice.tax) : 0;
            return (parseFloat(this.subtotal) + tax).toFixed(2);
        },
        totalInWords() {
            return toWords(parseFloat(this.total)) + ' Rupees Only';
        }
    }
};
</script>

<style scoped>
.invoice-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    border-bottom: 1px solid #ddd;
    padding-bottom: 10px;
    margin-bottom: 20px;
}

.logo img {
    max-width: 150px;
}

.invoice-details {
    display: flex;
    justify-content: space-between;
}

.invoice-info,
.customer-info {
    width: 48%;
}

.product-details table {
    width: 100%;
    border-collapse: collapse;
}

.product-details th,
.product-details td {
    padding: 10px;
    border: 1px solid #ddd;
}

.invoice-summary p {
    font-size: 1.2em;
    margin: 5px 0;
}

.badge {
    padding: 0.5em 1em;
    border-radius: 0.25em;
    color: #fff;
}

.badge-success {
    background-color: #28a745;
}

.badge-warning {
    background-color: #ffc107;
}

.badge-danger {
    background-color: #dc3545;
}
</style>