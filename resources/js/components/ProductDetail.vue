<template>
    <div>
        <h2 class="mb-4">Product Details</h2>
        <div v-if="product">
            <p><strong>Name:</strong> {{ product.name }}</p>
            <p><strong>Price:</strong> {{ product.price }}</p>
            <p><strong>Stock Quantity:</strong> {{ product.stock_quantity }}</p>
        </div>
    </div>
</template>

<script>
import { ref, onMounted } from 'vue';
import apiService from '@/apiService';


export default {
    setup() {
        const product = ref(null);

        const fetchProduct = async (id) => {
            try {
                const response = await apiService.getProduct(id);
                product.value = response.data;
            } catch (error) {
                console.error('Error fetching product:', error);
            }
        };

        onMounted(() => {
            fetchProduct(this.$route.params.id);
        });

        return {
            product,
            fetchProduct,
        };
    },
};
</script>