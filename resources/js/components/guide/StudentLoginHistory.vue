<template>
    

    <div class="mt-3">
        <h4  >Login History</h4>
       

            <table class="table table-striped">

                <thead>
            <tr>
               <th scope="col">Action</th>
               <th scope="col">Description</th>
               <th scope="col">Time</th>
            </tr>
         </thead>
         <tbody>


            <tr v-for="login in loginHistory" :key="login.id">
                <td>{{ login.ip_address }}</td>
            


                <td>{{ $formatTimeAgo(login.created_at) }}</td>
                <td>{{ $formatDate(login.created_at) }}</td>




            </tr>
        </tbody>
        </table>
    </div>


</template>

<script>
 
import apiService from '@/apiService';


export default {
    props: {
        studentId: {
            type: String,
            required: true,
        },
    },
    data() {
        return {
            loginHistory: [],
        };
    },
    created() {
        this.fetchLoginHistory();
    },
    methods: {
        fetchLoginHistory() {
            apiService.getLoginHistory(this.studentId)
                .then(response => {
                    this.loginHistory = response.data;
                })
                .catch(error => {
                    console.error('Error fetching login history:', error);
                });
        } 
    }
};
</script>