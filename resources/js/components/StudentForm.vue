<template>
    <div>
        <form @submit.prevent="isEditing ? updateStudent() : saveStudent()" class="needs-validation" novalidate>
            <!-- Name Field -->
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input v-model="studentForm.name" type="text" class="form-control" id="name" placeholder="Name"
                    required>
                <div class="invalid-feedback">
                    Please provide a name.
                </div>
            </div>
            <!-- Email Field -->
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input v-model="studentForm.email" type="email" class="form-control" id="email" placeholder="Email"
                    required>
                <div class="invalid-feedback">
                    Please provide a valid email.
                </div>
            </div>
            <!-- Phone Number Field -->
            <div class="mb-3">
                <label for="phoneNumber" class="form-label">Phone Number</label>
                <input v-model="studentForm.phoneNumber" type="text" class="form-control" id="phoneNumber"
                    placeholder="Phone Number" required>
                <div class="invalid-feedback">
                    Please provide a phone number.
                </div>
            </div>
            <!-- Tags Field -->
            <div class="mb-3">
                <label for="tags" class="form-label">Tags</label>
                <vue3-tags-input :tags="studentForm.tags" @on-tags-changed="updateTags" placeholder="Add a tag" />
                <div class="invalid-feedback">
                    Please provide tags.
                </div>
            </div>
            <!-- Submit Button -->
            <button type="submit" class="btn btn-primary" :disabled="loading">
                <span v-if="loading" class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                {{ isEditing ? 'Update' : 'Save' }}
            </button>
        </form>
    </div>
</template>

<script>
import axios from 'axios';
import Vue3TagsInput from 'vue3-tags-input';

export default {
    components: {
        Vue3TagsInput
    },
    props: {
        studentId: {
            type: Number,
            default: null
        },
        isEditing: {
            type: Boolean,
            default: false
        }
    },
    data() {
        return {
            studentForm: {
                id: null,
                name: '',
                email: '',
                phoneNumber: '',
                tags: [] // Ensure this is always an array
            },
            loading: false
        };
    },
    methods: {
        async saveStudent() {
            this.loading = true;
            try {


                console.log(this.studentForm);

                const response = await axios.post('/v1/students', this.studentForm);
                this.$emit('saved', response.data);
                this.resetForm();
            } catch (error) {
                console.error('Error saving student:', error);
            } finally {
                this.loading = false;
            }
        },
        async updateStudent() {
            this.loading = true;
            try {

                console.log(this.studentForm);


                const response = await axios.put(`/v1/students/${this.studentForm.id}`, this.studentForm);
                this.$emit('saved', response.data);
                this.resetForm();
            } catch (error) {
                console.error('Error updating student:', error);
            } finally {
                this.loading = false;
            }
        },
        updateTags(newTags) {
            this.studentForm.tags = newTags;

            console.log(this.studentForm);
        },
        resetForm() {
            this.studentForm = {
                id: null,
                name: '',
                email: '',
                phoneNumber: '',
                tags: []
            };
        },
        async fetchStudent(id) {
            try {
                const response = await axios.get(`/v1/students/${id}`);
                const student = response.data;

 


                    student.tags = Array.isArray(student.tags) ? student.tags.map(tag => tag.name) : [];


                    this.studentForm = student;


            } catch (error) {
                console.error('Error fetching student:', error);
            }
        }
    },
    watch: {
        studentId: {
            immediate: true,
            handler(newVal) {
                if (newVal) {
                    this.fetchStudent(newVal);
                }
            }
        }
    }
};
</script>

<style>
.v3ti .v3ti-new-tag {
    background-color: var(--bs-body-bg) !important;
}
</style>