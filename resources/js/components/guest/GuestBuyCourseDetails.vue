<template>
    <div>
        <h2 class="mb-4">{{ course.title }}</h2>
        <p>{{ course.description }}</p>
        <button @click="purchaseCourse(course.id)" class="btn btn-primary btn-sm ms-2">Purchase</button>
    </div>
</template>



<script>


import apiService from '@/apiGuestService.js';

export default {
    data() {
        return {
            course: {
                title: '',
                description: ''
            }
        };
    },
    created() {
        this.fetchCourseDetails();
    },
    methods: {
        async fetchCourseDetails() {
            const courseId = this.$route.params.id;
            try {
                const response = await apiService.getCourseDetails(courseId);
                this.course = response.data;
            } catch (error) {
                console.error('Failed to load course details:', error);
                this.$printtoast('Failed to load course details.');
            }
        },
        async purchaseCourse(courseId) {
            try {
                const response = await apiService.purchaseCourse(courseId);
                this.$printtoast('Course purchased successfully!');
                this.$router.push({ name: 'Invoice', params: { invoiceId: response.data.invoice_id } });
            } catch (error) {
                console.error('Error purchasing course:', error);
                this.$printtoast('Failed to purchase course.');
            }
        }
    }
};
</script>