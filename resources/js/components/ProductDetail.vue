<template>
    <div  >
        <h2 class="mb-4">Product Details</h2>
        <div v-if="product">
            <p><strong>Name:</strong> {{ product.name }}</p>
            <p><strong>Price:</strong> {{ product.price }}</p>
            <p><strong>Stock Quantity:</strong> {{ product.stock_quantity }}</p>
        </div>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    data() {
        return {
            product: null
        };
    },
    created() {
        this.fetchProduct(this.$route.params.id);
    },
    methods: {
        fetchProduct(id) {
            axios.get(`/v1/products/${id}`)
                .then(response => {
                    this.product = response.data;
                })
                .catch(error => {
                    console.error(error);
                });
        }
    }
};
</script>