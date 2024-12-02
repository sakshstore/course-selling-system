<template>
    <div  v-if="invoice">
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
                <div class="mb-3  col-md-4">
                    <label for="invoiceNumber" class="form-label">Invoice Number</label>
                    <input v-model="invoice.invoice_number" type="text" class="form-control" id="invoiceNumber"
                        required />
                </div>
                <div class="mb-3  col-md-4">
                    <label for="orderNumber" class="form-label">Order Number</label>
                    <input v-model="invoice.order_number" type="text" class="form-control" id="orderNumber" />
                </div>
                <div class="mb-3  col-md-4">
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



import axios from 'axios';

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
        fetchInvoice() {
            const id = this.$route.params.id;
            axios.get(`/v1/invoices/${id}`).then(response => {
                this.invoice = response.data.invoice;
                this.companyDetails = response.data.companyDetails;
                this.updateSelectedContact();
            }).catch(error => {
                console.error(error);
            });
        },
        fetchProducts() {
            axios.get('/v1/products').then(response => {
                this.allProducts = response.data;
            }).catch(error => {
                console.error(error);
            });
        },
        fetchContacts() {
            axios.get('/v1/contacts_list').then(response => {
                this.contacts = response.data;
            }).catch(error => {
                console.error(error);
            });
        },
        updateSelectedContact() {
            this.selectedContact = this.contacts.find(contact => contact.id === this.invoice.contact_id) || {};
        },
        updateContactDetails() {
            this.updateSelectedContact();
            this.updateInvoiceDetails();
        },
        addProduct() {
            this.invoice.products.push({ id: '', name: '', pivot: { quantity: 1, description: '', showDescription: false }, price: 0 });
        },
        removeProduct(index) {
            this.invoice.products.splice(index, 1);
        },
        updateProductDetails(index) {
            const selectedProduct = this.allProducts.find(prod => prod.id === this.invoice.products[index].id);
            if (selectedProduct) {
                this.invoice.products[index].price = selectedProduct.price;
                this.invoice.products[index].pivot.description = selectedProduct.description;
            }
        },
        updateProducts() {
            const productsData = this.invoice.products.map(product => ({
                id: product.id,
                name: product.name,
                quantity: product.pivot.quantity,
                description: product.pivot.description,
                price: product.price
            }));

            axios.put(`/v1/invoices/${this.invoice.id}/products`, { products: productsData })
                .then(response => {
                    alert('Products updated successfully!');
                })
                .catch(error => {
                    console.error(error);
                });
        },
        updateInvoiceDetails() {
            const detailsData = {
                contact_id: this.invoice.contact_id,
                invoice_number: this.invoice.invoice_number,
                order_number: this.invoice.order_number,
                invoice_date: this.invoice.invoice_date,
                due_date: this.invoice.due_date,
                status: this.invoice.status
            };

            axios.put(`/v1/invoices/${this.invoice.id}/details`, detailsData)
                .then(response => {
                    alert('Invoice details updated successfully!');
                })
                .catch(error => {
                    console.error(error);
                });
        },
        updateInvoiceDatesAndTerms() {
            const datesTermsData = {
                invoice_date: this.invoice.invoice_date,
                terms: this.invoice.terms,
                due_date: this.invoice.due_date
            };

            axios.put(`/v1/invoices/${this.invoice.id}/dates-terms`, datesTermsData)
                .then(response => {
                    alert('Invoice dates and terms updated successfully!');
                })
                .catch(error => {
                    console.error(error);
                });
        },
        updateCustomerNoteAndTerms() {
            const noteTermsData = {
                customer_note: this.invoice.customer_note,
                terms: this.invoice.terms
            };

            axios.put(`/v1/invoices/${this.invoice.id}/note-terms`, noteTermsData)
                .then(response => {
                    alert('Customer note and terms updated successfully!');
                })
                .catch(error => {
                    console.error(error);
                });
        },
        handleFileUpload(event) {
            this.file = event.target.files[0];
        },
        updateFile() {
            const formData = new FormData();
            if (this.file) {
                formData.append('file', this.file);
            }

            axios.post(`/v1/invoices/${this.invoice.id}/file`, formData, {
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
            }).then(response => {
                alert('File updated successfully!');
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