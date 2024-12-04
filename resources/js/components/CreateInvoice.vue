<template>
    <div>
        <h2 class="mb-4">Create Invoice</h2>
        <div v-if="step === 1">
            <h3>Step 1: Contact and Invoice Details</h3>
            <form @submit.prevent="nextStep">
                <div class="mb-3">
                    <label for="contact" class="form-label">Contact</label>
                    <select v-model="contactId" class="form-control" id="contact" required>
                        <option v-for="contact in contacts" :key="contact.id" :value="contact.id">{{ contact.name }}
                        </option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="invoiceNumber" class="form-label">Invoice Number</label>
                    <input v-model="invoiceNumber" type="text" class="form-control" id="invoiceNumber"
                        placeholder="Invoice Number" required />
                </div>
                <div class="mb-3">
                    <label for="orderNumber" class="form-label">Order Number</label>
                    <input v-model="orderNumber" type="text" class="form-control" id="orderNumber"
                        placeholder="Order Number" />
                </div>
                <div class="mb-3">
                    <label for="invoiceDate" class="form-label">Invoice Date</label>
                    <input v-model="invoiceDate" type="date" class="form-control" id="invoiceDate" required />
                </div>
                <div class="mb-3">
                    <label for="dueDate" class="form-label">Due Date</label>
                    <input v-model="dueDate" type="date" class="form-control" id="dueDate" required />
                </div>
                <div class="mb-3">
                    <label for="status" class="form-label">Status</label>
                    <select v-model="status" class="form-control" id="status" required>
                        <option value="draft">Draft</option>
                        <option value="sent">Sent</option>
                        <option value="viewed">Viewed</option>
                        <option value="paid">Paid</option>
                        <option value="partially_paid">Partially Paid</option>
                        <option value="overdue">Overdue</option>
                        <option value="cancelled">Cancelled</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Next</button>
            </form>
        </div>
        <div v-else-if="step === 2">
            <h3>Step 2: Product Details</h3>
            <form @submit.prevent="nextStep">
                <div class="mb-3">
                    <label for="products" class="form-label">Products</label>
                    <div v-for="(product, index) in products" :key="index" class="mb-2">
                        <select v-model="product.id" class="form-control mb-1" @change="showDescriptionField(index)"
                            required>
                            <option v-for="prod in allProducts" :key="prod.id" :value="prod.id">{{ prod.name }}</option>
                        </select>
                        <input v-model="product.quantity" type="number" class="form-control mb-1" placeholder="Quantity"
                            required />
                        <textarea v-if="product.showDescription" v-model="product.description" class="form-control"
                            placeholder="Product Description"></textarea>
                    </div>
                    <button type="button" class="btn btn-secondary" @click="addProduct">Add Product</button>
                </div>
                <button type="submit" class="btn btn-primary">Next</button>
            </form>
        </div>
        <div v-else-if="step === 3">
            <h3>Step 3: Customer Note and Terms</h3>
            <form @submit.prevent="createInvoice">
                <div class="mb-3">
                    <label for="customerNote" class="form-label">Customer Note</label>
                    <textarea v-model="customerNote" class="form-control" id="customerNote"
                        placeholder="Customer Note"></textarea>
                </div>
                <div class="mb-3">
                    <label for="terms" class="form-label">Terms and Conditions</label>
                    <textarea v-model="terms" class="form-control" id="terms"
                        placeholder="Terms and Conditions"></textarea>
                </div>
                <div class="mb-3">
                    <label for="file" class="form-label">Include File</label>
                    <input type="file" class="form-control" id="file" @change="handleFileUpload" />
                </div>
                <button type="submit" class="btn btn-primary">Create Invoice</button>
            </form>
        </div>
    </div>
</template>

<script>
import apiService from '@/apiservice';

export default {
    data() {
        return {
            step: 1,
            contactId: '',
            invoiceNumber: '',
            orderNumber: '',
            invoiceDate: '',
            dueDate: '',
            products: [{ id: '', quantity: 1, description: '', showDescription: false }],
            contacts: [],
            allProducts: [],
            customerNote: '',
            terms: '',
            status: 'draft', // Added this line
            file: null
        };
    },
    created() {
        this.fetchContacts();
        this.fetchProducts();
    },
    methods: {
        fetchContacts() {
            apiService.getContacts().then(response => {
                this.contacts = response.data;
            }).catch(error => {
                console.error(error);
            });
        },
        fetchProducts() {
            apiService.getProducts().then(response => {
                this.allProducts = response.data;
            }).catch(error => {
                console.error(error);
            });
        },
        addProduct() {
            this.products.push({ id: '', quantity: 1, description: '', showDescription: false });
        },
        showDescriptionField(index) {
            this.products[index].showDescription = true;
        },
        nextStep() {
            this.step++;
        },
        handleFileUpload(event) {
            this.file = event.target.files[0];
        },
        createInvoice() {
            const formData = new FormData();
            formData.append('contact_id', this.contactId);
            formData.append('invoice_number', this.invoiceNumber);
            formData.append('order_number', this.orderNumber);
            formData.append('invoice_date', this.invoiceDate);
            formData.append('due_date', this.dueDate);
            formData.append('customer_note', this.customerNote);
            formData.append('terms', this.terms);
            formData.append('file', this.file);
            formData.append('status', this.status); // Added this line

            this.products.forEach((product, index) => {
                formData.append(`products[${index}][id]`, product.id);
                formData.append(`products[${index}][quantity]`, product.quantity);
                formData.append(`products[${index}][description]`, product.description);
            });

            apiService.createInvoice(formData).then(response => {
                alert('Invoice created successfully!');
                this.$router.push('/invoices');
            }).catch(error => {
                console.error(error);
            });
        }
    }
};
</script>