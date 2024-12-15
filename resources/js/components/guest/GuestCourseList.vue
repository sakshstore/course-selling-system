<template>
    <div>
        <h2 class="mb-4">Your Learning Courses</h2>
        <div class="row">
            <div v-for="course in courses" :key="course.id" class="col-md-2 mb-4">
                <div class="course-item border" @click="viewCourseDetails(course.id)">
                    <img :src="getThumbnail(course.thumbnail)" class="card-img-top" alt="Course Thumbnail">
                    <div class="course-info p-3">
                        <h5 class="course-title">{{ course.title }}</h5>
                        <p class="course-description">{{ course.description }}</p>
                    </div>
                </div>
            </div>
        </div>
        <!-- Include GuestBuyCourseList component -->
        <GuestBuyCourseList />
    </div>
</template>


<script setup>
import { ref, onMounted } from 'vue';
import { useRouter } from 'vue-router';
import apiService from '@/apiGuestService.js';
import GuestBuyCourseList from '@/components/guest/GuestBuyCourseList.vue'; // Import the component

const courses = ref([]);
const router = useRouter();

const fetchCourses = async () => {
    try {
        const response = await apiService.getMyCourses();
        courses.value = response.data;
    } catch (error) {
        console.error('Error fetching courses:', error);
    }
};

const viewCourseDetails = (courseId) => {
    router.push({ name: 'GuestCourseDetails', params: { id: courseId } });
};

const getThumbnail = (thumbnail) => {
    return thumbnail || 'https://picsum.photos/id/1/367/267';
};

onMounted(() => {
    fetchCourses();
});
</script>


<style scoped>
.course-item {
    cursor: pointer;
    transition: transform 0.3s, box-shadow 0.3s;
}

.course-item:hover {
    transform: translateY(-10px);
    box-shadow: 0 15px 30px rgba(0, 0, 0, 0.2);
}

.course-title {
    font-size: 1.2rem;
    font-weight: bold;
}

.course-description {
    font-size: 0.9rem;
    color: #666;
}
</style>