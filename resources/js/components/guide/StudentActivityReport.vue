<template>
   <div v-if="activityReport.length" class="mt-3">
      <h4>Activity Report</h4>
      <table class="table table-striped">
         <thead>
            <tr>
               <th scope="col">Action</th>
               <th scope="col">Description</th>
               <th scope="col">Time</th>
            </tr>
         </thead>
         <tbody>
            <tr v-for="activity in activityReport" :key="activity.id">
             

               <td>{{ activity.action }}</td>

               <td>{{ activity.message }}</td>

               


               <td>{{ formatTimeAgo(activity.created_at) }}</td>



            </tr>
         </tbody>
      </table>
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
   const activityReport = ref([]);
   
   const fetchActivityReport = () => {
   apiService.getActivityReport(props.studentId)
   .then(response => {
   activityReport.value = response.data;
   })
   .catch(error => {
   console.error('Error fetching activity report:', error);
   });
   };
   
   const formatTimeAgo = (date) => {
   return formatDistanceToNow(new Date(date), { addSuffix: true });
   };
   
   onMounted(fetchActivityReport);
   
   return {
   activityReport,
   formatTimeAgo,
   };
   },
   };
   </script>
   