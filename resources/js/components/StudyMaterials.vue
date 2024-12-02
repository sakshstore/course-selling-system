<template>
    <div  >
        <h2 class="mb-4">Study Materials for {{ course.title }}</h2>

        <button type="button" class="btn btn-success mt-4" data-bs-toggle="modal" data-bs-target="#addMaterialModal">
            Add Study Material
        </button>
        <div v-for="(materials, chapter) in groupedMaterials" :key="chapter" class="mb-4">
            <h3 class="mb-3">Chapter: {{ chapter }}</h3>
            <ul class="list-group">
                <li v-for="material in materials" :key="material.id" class="list-group-item border-5  ">
                    <h5 class="mb-1">{{ material.title }}</h5>
                    <p class="mb-1">{{ material.description }}</p>
                    <a :href="`/storage/${material.file_path}`" target="_blank"
                        class="btn btn-primary btn-sm">Download</a>
                </li>
            </ul>
        </div>
      

        <!-- Modal -->
        <div class="modal fade" id="addMaterialModal" tabindex="-1" aria-labelledby="addMaterialModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addMaterialModalLabel">Add Study Material</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form @submit.prevent="addStudyMaterial">
                            <div class="mb-3">
                                <label for="title" class="form-label">Title</label>
                                <input v-model="newMaterial.title" type="text" class="form-control" id="title"
                                    placeholder="Title" required>
                            </div>
                            <div class="mb-3">
                                <label for="description" class="form-label">Description</label>
                                <textarea v-model="newMaterial.description" class="form-control" id="description"
                                    placeholder="Description"></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="chapter" class="form-label">Chapter</label>
                                <input v-model="newMaterial.chapter" type="text" class="form-control" id="chapter"
                                    placeholder="Chapter" required>
                            </div>
                            <div class="mb-3">
                                <label for="file" class="form-label">File</label>
                                <input type="file" @change="handleFileUpload" class="form-control" id="file">
                            </div>
                            <button type="submit" class="btn btn-success">Add Study Material</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    data() {
        return {
            course: {},
            studyMaterials: [],
            newMaterial: {
                title: '',
                description: '',
                chapter: '',
                file: null
            }
        };
    },
    computed: {
        groupedMaterials() {
            return this.studyMaterials.reduce((groups, material) => {
                const chapter = material.chapter || 'Uncategorized';
                if (!groups[chapter]) {
                    groups[chapter] = [];
                }
                groups[chapter].push(material);
                return groups;
            }, {});
        }
    },
    created() {
        this.fetchCourse();
        this.fetchStudyMaterials();
    },
    methods: {
        fetchCourse() {
            const courseId = this.$route.params.courseId;
            axios.get(`/v1/courses/${courseId}`).then(response => {
                this.course = response.data;
            });
        },
        fetchStudyMaterials() {
            const courseId = this.$route.params.courseId;
            axios.get(`/v1/courses/${courseId}/study-materials`).then(response => {
                this.studyMaterials = response.data;
            });
        },
        handleFileUpload(event) {
            this.newMaterial.file = event.target.files[0];
        },
        addStudyMaterial() {
            const courseId = this.$route.params.courseId;
            const formData = new FormData();
            formData.append('title', this.newMaterial.title);
            formData.append('description', this.newMaterial.description);
            formData.append('chapter', this.newMaterial.chapter);
            formData.append('file', this.newMaterial.file);
            formData.append('uploaded_by', 1); // Replace with actual user ID
            formData.append('visibility', 'public'); // Default visibility

            axios.post(`/courses/${courseId}/study-materials`, formData).then(response => {
                this.studyMaterials.push(response.data);
                this.newMaterial = { title: '', description: '', chapter: '', file: null };
                // Close the modal
                const modal = bootstrap.Modal.getInstance(document.getElementById('addMaterialModal'));
                modal.hide();
            });
        }
    }
};
</script>

<style scoped>
/* Add any additional styling here */
</style>