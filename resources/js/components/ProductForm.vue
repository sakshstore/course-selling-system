<template>
    <div  >
        <h2 class="mb-4">{{ isEdit ? 'Edit Product' : 'Create Product' }}</h2>
        <form @submit.prevent="submitForm">
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control" id="name" v-model="product.name" required>
            </div>
            <div class="mb-3">
                <label for="price" class="form-label">Price</label>
                <input type="number" class="form-control" id="price" v-model="product.price" required>
            </div>
            <div class="mb-3">
                <label for="stock_quantity" class="form-label">Stock Quantity</label>
                <input type="number" class="form-control" id="stock_quantity" v-model="product.stock_quantity" required>
            </div>
            <button type="submit" class="btn btn-primary">{{ isEdit ? 'Update' : 'Create' }}</button>
        </form>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    data() {
        return {
            product: {
                name: '',
                price: 0,
                stock_quantity: 0
            },
            isEdit: false
        };
    },
    created() {
        if (this.$route.params.id) {
            this.isEdit = true;
            this.fetchProduct(this.$route.params.id);
        }
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
        },
        submitForm() {
            if (this.isEdit) {
                axios.put(`/v1/products/${this.$route.params.id}`, this.product)
                    .then(() => {
                        this.$router.push('/products');
                    })
                    .catch(error => {
                        console.error(error);
                    });
            } else {
                axios.post('/v1/products', this.product)
                    .then(() => {
                        this.$router.push('/products');
                    })
                    .catch(error => {
                        console.error(error);
                    });
            }
        }
    }
};
</script>