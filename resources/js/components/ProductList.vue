<template>
    <div >
        <h2 class="mb-4">Products</h2>
        <button class="btn btn-primary mb-3" @click="createProduct">Create Product</button>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Price</th>
                    <th>Stock</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="product in products" :key="product.id">
                    <td>{{ product.name }}</td>
                    <td>{{ product.price }}</td>
                    <td>{{ product.stock_quantity }}</td>
                    <td>
                        <button class="btn btn-info btn-sm" @click="viewProduct(product.id)">View</button>
                        <button class="btn btn-warning btn-sm" @click="editProduct(product.id)">Edit</button>
                        <button class="btn btn-danger btn-sm" @click="deleteProduct(product.id)">Delete</button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    data() {
        return {
            products: []
        };
    },
    created() {
        this.fetchProducts();
    },
    methods: {
        fetchProducts() {
            axios.get('/v1/products')
                .then(response => {
                    this.products = response.data;
                })
                .catch(error => {
                    console.error(error);
                });
        },
        createProduct() {
            this.$router.push('/guide/products/create');
        },
        viewProduct(id) {
            this.$router.push(`/guide/products/${id}`);
        },
        editProduct(id) {
            this.$router.push(`/guide/products/${id}/edit`);
        },
        deleteProduct(id) {
            if (confirm('Are you sure you want to delete this product?')) {
                axios.delete(`/products/${id}`)
                    .then(() => {
                        this.fetchProducts();
                    })
                    .catch(error => {
                        console.error(error);
                    });
            }
        }
    }
};
</script>