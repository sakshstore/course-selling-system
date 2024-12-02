<template>
    <div>
        <h2 class="mb-4">{{ course.title }}</h2>
        <p>{{ course.description }}</p>
        <button @click="purchaseCourse(course.id)" class="btn btn-primary btn-sm ms-2">Purchase</button>
    </div>
</template>



<script>
import axios from 'axios';

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
                const response = await axios.get(`/v1/courses/${courseId}`);
                this.course = response.data;
            } catch (error) {
                console.error('Failed to load course details:', error);
                alert('Failed to load course details.');
            }
        },
        async purchaseCourse(courseId) {
            try {
                const response = await axios.post(`/v1/courses/${courseId}/purchase`);
                alert('Course purchased successfully!');
                this.$router.push({ name: 'Invoice', params: { invoiceId: response.data.invoice_id } });
            } catch (error) {
                console.error('Error purchasing course:', error);
                alert('Failed to purchase course.');
            }
        }
    }
};
</script>