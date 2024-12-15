<template>
    <div v-if="student" class="card p-3 mb-4 shadow-sm">
    <div class="card-body">
    <div class="d-flex align-items-center">
    <img :src="student.profile_picture || 'https://via.placeholder.com/150'" alt="Profile Picture"
    class="rounded-circle me-3 border" style="width: 100px; height: 100px;">
    <div>
    <h5 class="card-title mb-1">{{ student.firstName }} {{ student.middleName }} {{ student.lastName }}</h5>
    <p class="text-muted mb-2">{{ student.email }}</p>
    <p class="mb-1"><i class="bi bi-telephone"></i> {{ student.phoneNumber }}</p>
    <p class="mb-1"><i class="bi bi-geo-alt"></i> {{ student.street }}, {{ student.city }}, {{ student.state }}, {{ student.country }} - {{ student.postalCode }}</p>
    <p class="mb-1"><i class="bi bi-translate"></i> Preferred Language: {{ student.preferredLanguage }}</p>
    <p class="mb-1"><i class="bi bi-person-check"></i> Special Accommodations: {{ student.specialAccommodations }}</p>
    <p class="mb-0"><strong>Registered At:</strong> {{ formatTimeAgo(student.created_at) }}</p>
    </div>
    </div>
    </div>
    </div>
    </template>
    <script>
    import { ref, onMounted } from 'vue';
    import { formatDistanceToNow } from 'date-fns';
    import apiService from '@/apiService';
    
    export default {
    props: {
    studentId: {
    type: String,
    required: true,
    },
    },
    setup(props) {
    const student = ref(null);
    
    const fetchStudentDetails = () => {
    apiService.fetchStudentDetails(props.studentId)
    .then(response => {
    student.value = response.data;
    })
    .catch(error => {
    console.error('Error fetching student details:', error);
    });
    };
    
    const formatTimeAgo = (date) => {
    return formatDistanceToNow(new Date(date), { addSuffix: true });
    };
    
    onMounted(fetchStudentDetails);
    
    return {
    student,
    formatTimeAgo,
    };
    },
    };
    </script>