<template>
    <div>
        <h2 class="mb-4">{{ isEdit ? 'Edit Course' : 'Create Course' }}</h2>

        <!-- Progress Bar -->
        <div class="progress mb-4">
            <div class="progress-bar" role="progressbar" :style="{ width: progressPercentage + '%' }"
                :aria-valuenow="progressPercentage" aria-valuemin="0" aria-valuemax="100">{{ progressPercentage }}%
            </div>
        </div>

        <form @submit.prevent="saveCourse">
            <!-- Step 1: Course Details -->
            <div v-if="step === 1">
                <div class="card mb-4">
                    <div class="card-header">Course Details</div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="title" class="form-label">Title</label>
                            <input v-model="course.title" type="text" class="form-control" id="title"
                                placeholder="Enter course title" required>
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea v-model="course.description" class="form-control" id="description"
                                placeholder="Enter course description"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="instructor_id" class="form-label">Instructor ID</label>
                            <input v-model="course.instructor_id" type="number" class="form-control" id="instructor_id"
                                placeholder="Enter instructor ID" required>
                        </div>
                    </div>
                </div>
                <button type="button" class="btn btn-primary" @click="nextStep">Next</button>
            </div>

            <!-- Step 2: Schedule -->
            <div v-if="step === 2">
                <div class="card mb-4">
                    <div class="card-header">Schedule</div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="start_date" class="form-label">Start Date</label>
                            <input v-model="course.start_date" type="date" class="form-control" id="start_date">
                        </div>
                        <div class="mb-3">
                            <label for="end_date" class="form-label">End Date</label>
                            <input v-model="course.end_date" type="date" class="form-control" id="end_date">
                        </div>
                    </div>
                </div>
                <button type="button" class="btn btn-secondary" @click="prevStep">Previous</button>
                <button type="button" class="btn btn-primary" @click="nextStep">Next</button>
            </div>

            <!-- Step 3: Pricing -->
            <div v-if="step === 3">
                <div class="card mb-4">
                    <div class="card-header">Pricing</div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="price" class="form-label">Price</label>
                            <input v-model="course.price" type="number" step="0.01" class="form-control" id="price"
                                placeholder="Enter course price">
                        </div>
                    </div>
                </div>
                <button type="button" class="btn btn-secondary" @click="prevStep">Previous</button>
                <button type="button" class="btn btn-primary" @click="nextStep">Next</button>
            </div>

            <!-- Step 4: Additional Information -->
            <div v-if="step === 4">
                <div class="card mb-4">
                    <div class="card-header">Additional Information</div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="category" class="form-label">Category</label>
                            <input v-model="course.category" type="text" class="form-control" id="category"
                                placeholder="Enter course category">
                        </div>
                        <div class="mb-3">
                            <label for="duration" class="form-label">Duration</label>
                            <input v-model="course.duration" type="number" class="form-control" id="duration"
                                placeholder="Enter course duration in hours">
                        </div>
                        <div class="mb-3">
                            <label for="level" class="form-label">Level</label>
                            <input v-model="course.level" type="text" class="form-control" id="level"
                                placeholder="Enter course level (e.g., Beginner, Intermediate, Advanced)">
                        </div>
                        <div class="mb-3">
                            <label for="status" class="form-label">Status</label>
                            <select v-model="course.status" class="form-select" id="status">
                                <option value="draft">Draft</option>
                                <option value="published">Published</option>
                                <option value="archived">Archived</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="thumbnail" class="form-label">Thumbnail</label>
                            <input @change="onFileChange" type="file" class="form-control" id="thumbnail">
                        </div>
                    </div>
                </div>
                <button type="button" class="btn btn-secondary" @click="prevStep">Previous</button>
                <button type="submit" class="btn btn-primary">{{ isEdit ? 'Update' : 'Create' }}</button>
            </div>
        </form>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    data() {
        return {
            course: {
                title: '',
                description: '',
                instructor_id: '',
                category: '',
                duration: '',
                level: '',
                price: '',
                start_date: '',
                end_date: '',
                status: 'draft',
                thumbnail: null
            },
            isEdit: false,
            step: 1
        };
    },
    computed: {
        progressPercentage() {
            return (this.step / 4) * 100;
        }
    },
    created() {
        if (this.$route.params.id) {
            this.isEdit = true;
            this.fetchCourse(this.$route.params.id);
        }
    },
    methods: {
        fetchCourse(id) {
            axios.get(`/v1/courses/${id}`).then(response => {
                this.course = response.data;
            });
        },
        onFileChange(event) {
            this.course.thumbnail = event.target.files[0];
        },
        saveCourse() {
            const formData = new FormData();
            for (const key in this.course) {
                formData.append(key, this.course[key]);
            }

            if (this.isEdit) {
                axios.put(`/courses/${this.$route.params.id}`, formData).then(response => {
                    this.$router.push({ name: 'CourseList' });
                });
            } else {
                axios.post('/v1/courses', formData).then(response => {
                    this.$router.push({ name: 'CourseList' });
                });
            }
        },
        nextStep() {
            if (this.step < 4) {
                this.step++;
            }
        },
        prevStep() {
            if (this.step > 1) {
                this.step--;
            }
        }
    }
};
</script> 