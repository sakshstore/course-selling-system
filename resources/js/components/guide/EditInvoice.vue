<template>
    <div v-if="invoice">
        <!-- Company Details Section -->
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

        <!-- Contact and Invoice Details Section -->
        <div class="row mt-4">
            <div class="col-md-12">
                <h5>Contact Details</h5>
                <select v-model="invoice.contact_id" class="form-control mb-3" @change="updateContactDetails" required>
                    <option v-for="contact in contacts" :key="contact.id" :value="contact.id">{{ contact.name }}
                    </option>
                </select>
                <address>
                    <strong>{{ selectedContact.name }}</strong><br>
                    {{ selectedContact.billing_address_line1 }}<br>
                    {{ selectedContact.billing_address_line2 }}<br>
                    {{ selectedContact.billing_city }}, {{ selectedContact.billing_state }}<br>
                    {{ selectedContact.billing_country }} - {{ selectedContact.billing_pin_code }}
                </address>
            </div>
            <div class="col-md-12">
                <div class="row">
                    <h5>Invoice Details</h5>
                    <div class="mb-3 col-md-4">
                        <label for="invoiceNumber" class="form-label">Invoice Number</label>
                        <input v-model="invoice.invoice_number" type="text" class="form-control" id="invoiceNumber"
                            required />
                    </div>
                    <div class="mb-3 col-md-4">
                        <label for="orderNumber" class="form-label">Order Number</label>
                        <input v-model="invoice.order_number" type="text" class="form-control" id="orderNumber" />
                    </div>
                    <div class="mb-3 col-md-4">
                        <label for="status" class="form-label">Status</label>
                        <select v-model="invoice.status" class="form-control" id="status" required>
                            <option value="draft">Draft</option>
                            <option value="sent">Sent</option>
                            <option value="viewed">Viewed</option>
                            <option value="paid">Paid</option>
                            <option value="partially_paid">Partially Paid</option>
                            <option value="overdue">Overdue</option>
                            <option value="cancelled">Cancelled</option>
                        </select>
                    </div>
                </div>
                <button type="button" class="btn btn-primary mt-4" @click="updateInvoiceDetails">Update Invoice
                    Details</button>
            </div>
        </div>

        <!-- Invoice Dates and Terms Section -->
        <table class="table table-bordered mt-4">
            <thead>
                <tr>
                    <th>Invoice Date</th>
                    <th>Due Date</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><input v-model="invoice.invoice_date" type="date" class="form-control" /></td>
                    <td><input v-model="invoice.due_date" type="date" class="form-control" /></td>
                </tr>
            </tbody>
        </table>
        <button type="button" class="btn btn-primary mt-4" @click="updateInvoiceDatesAndTerms">Update Dates and
            Terms</button>

        <!-- Products Section -->
        <table class="table table-striped mt-4">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Item & Description</th>
                    <th class="text-right">Qty</th>
                    <th class="text-right">Rate</th>
                    <th class="text-right">Amount</th>
                    <th class="text-right">Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(product, index) in invoice.products" :key="product.id">
                    <td>{{ index + 1 }}</td>
                    <td>
                        <select v-model="product.id" class="form-control mb-1" @change="updateProductDetails(index)"
                            required>
                            <option v-for="prod in allProducts" :key="prod.id" :value="prod.id">{{ prod.name }}</option>
                        </select>
                        <textarea v-model="product.pivot.description" class="form-control"
                            placeholder="Product Description"></textarea>
                    </td>
                    <td class="text-right"><input v-model="product.pivot.quantity" type="number" class="form-control" />
                    </td>
                    <td class="text-right"><input v-model="product.price" type="number" class="form-control" /></td>
                    <td class="text-right">{{ (product.price * product.pivot.quantity).toFixed(2) }}</td>
                    <td class="text-right">
                        <button type="button" class="btn btn-danger btn-sm"
                            @click="removeProduct(index)">Remove</button>
                    </td>
                </tr>
            </tbody>
        </table>
        <button type="button" class="btn btn-secondary" @click="addProduct">Add Product</button>
        <br /><button type="button" class="btn btn-primary mt-4" @click="updateProducts">Update Products</button>

        <!-- Notes and Terms Section -->
        <div class="mt-5">
            <h5>Notes</h5>
            <textarea v-model="invoice.customer_note" class="form-control" placeholder="Customer Note"></textarea>
        </div>

        <div class="mt-5">
            <h5>Terms and Conditions</h5>
            <textarea v-model="invoice.terms" class="form-control" placeholder="Terms and Conditions"></textarea>
        </div>
        <button type="button" class="btn btn-primary mt-4" @click="updateCustomerNoteAndTerms">Update Notes and
            Terms</button>

        <!-- File Upload Section -->
        <div class="mt-5">
            <h5>Include File</h5>
            <input type="file" class="form-control" @change="handleFileUpload" />
        </div>

        <div class="mt-5" v-if="invoice.file_path">
            <h5>Attached File</h5>
            <a :href="`/storage/${invoice.file_path}`" target="_blank">Download File</a>
        </div>
        <button type="button" class="btn btn-primary mt-4" @click="updateFile">Update File</button>
    </div>
</template>



<script>

import apiService from '@/apiService.js';

export default {
    data() {
        return {
            invoice: null,
            companyDetails: {},
            allProducts: [],
            contacts: [],
            selectedContact: {},
            file: null
        };
    },
    created() {
        this.fetchInvoice();
        this.fetchProducts();
        this.fetchContacts();
    },
    methods: {
        async fetchInvoice() {
            const id = this.$route.params.id;
            try {
                const response = await apiService.getInvoice(id);
                this.invoice = response.data.invoice;
                this.companyDetails = response.data.companyDetails;
                this.updateSelectedContact();
            } catch (error) {
                console.error(error);
            }
        },
        async fetchProducts() {
            try {
                const response = await apiService.getProducts();
                this.allProducts = response.data;
            } catch (error) {
                console.error(error);
            }
        },
        async fetchContacts() {
            try {
                const response = await apiService.getContacts();
                this.contacts = response.data;
            } catch (error) {
                console.error(error);
            }
        },
        updateSelectedContact() {
            this.selectedContact = this.contacts.find(contact => contact.id === this.invoice.contact_id) || {};
        },
        updateContactDetails() {
            this.updateSelectedContact();
        },
        async updateInvoiceDetails() {
            try {
                await apiService.updateInvoiceDetails(this.invoice.id, this.invoice);
                this.$printtoast('Invoice details updated successfully');
            } catch (error) {
                console.error(error);
            }
        },
        async updateInvoiceDatesAndTerms() {
            try {
                await apiService.updateInvoiceDatesAndTerms(this.invoice.id, {
                    invoice_date: this.invoice.invoice_date,
                    due_date: this.invoice.due_date
                });
                this.$printtoast('Invoice dates and terms updated successfully');
            } catch (error) {
                console.error(error);
            }
        },
        async updateCustomerNoteAndTerms() {
            try {
                await apiService.updateCustomerNoteAndTerms(this.invoice.id, {
                    customer_note: this.invoice.customer_note,
                    terms: this.invoice.terms
                });
                this.$printtoast('Customer note and terms updated successfully');
            } catch (error) {
                console.error(error);
            }
        },
        async updateProducts() {
            try {
                await apiService.updateProducts(this.invoice.id, this.invoice.products);
                this.$printtoast('Products updated successfully');
            } catch (error) {
                console.error(error);
            }
        },
        async updateFile() {
            const formData = new FormData();
            formData.append('file', this.file);
            try {
                await apiService.updateFile(this.invoice.id, formData);
                this.$printtoast('File updated successfully');
            } catch (error) {
                console.error(error);
            }
        },
        handleFileUpload(event) {
            this.file = event.target.files[0];
        },
        addProduct() {
            this.invoice.products.push({ id: '', pivot: { description: '', quantity: 1 }, price: 0 });
        },
        removeProduct(index) {
            this.invoice.products.splice(index, 1);
        },
        updateProductDetails(index) {
            const product = this.allProducts.find(prod => prod.id === this.invoice.products[index].id);
            if (product) {
                this.invoice.products[index].price = product.price;
            }
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